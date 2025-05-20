<?php

namespace BinaryCastle\Boilerplate\Http\Controllers\API;

use App\Http\Controllers\Controller;
use BinaryCastle\Boilerplate\Http\Requests\API\FileRequest;
use BinaryCastle\Boilerplate\Http\Requests\API\FileUpdateRequest;
use BinaryCastle\Boilerplate\Models\FileManager;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
class FileManagerController extends Controller
{
    CONST DEFAULT_FILE_PATH = '/vendor/boilerplate/images/file-thumbnail';
    /**
     * @var string
     */
    private string $original_file_extension;
    /**
     * @var string
     */
    private string $original_file_name;
    /**
     * @var
     */
    private $original_file_type;
    /**
     * @var string
     */
    private string $chunk_path = 'chunks';
    /**
     * @var
     */
    private $new_file_name;

    /**
     * get files
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $mimeCategories = FileManager::MIME_CATEGORIES;
        $extToMime = FileManager::EXT_TO_MIME;

        $user = auth()->user();

        $files = FileManager::with('user:id,name')
            ->when(!$user->is_admin, function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->when(!empty($request->search), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            })
            ->when(!empty($request->file_type), function ($query) use ($request, $extToMime, $mimeCategories) {
                $fileTypes = explode(',', $request->file_type);
                $mimeTypes = [];

                foreach ($fileTypes as $type) {
                    $type = trim($type);

                    // If it's an extension (starts with a dot), map it to its MIME type
                    if (str_starts_with($type, '.')) {
                        $extension = ltrim($type, '.');
                        if (isset($extToMime[$extension])) {
                            $mimeTypes[] = $extToMime[$extension];
                        }
                    }elseif (isset($mimeCategories[$type])) { // If it's a wildcard type like "image/*", map it to multiple MIME types
                        $mimeTypes = array_merge($mimeTypes, $mimeCategories[$type]);
                    } elseif (str_contains($type, '/')) { // If it's already a specific MIME type, add it directly
                        $mimeTypes[] = $type;
                    }
                }

                if (!empty($mimeTypes)) {
                    $query->whereIn('type', $mimeTypes);
                }
            })
            ->orderBy($request->input('sort', 'id'), $request->input('direction', 'desc'))
            ->paginate($request->input('per_page', 10));

        return response()->json($files);
    }

    /**
     * file store
     *
     * @param FileRequest $request
     * @return JsonResponse
     * @throws FileNotFoundException
     */
    public function store(FileRequest $request)
    {
        $upload_finish = false;
        $file_manager = '';

        // Check if the file is present in the request
        if (!$request->hasFile('file')) {
            return response()->json(['uploaded' => false, 'error' => 'No file provided']);
        }

        $file = $request->file('file');

        // Check if file is null after the file upload field check
        if (!$file) {
            return response()->json(['uploaded' => false, 'error' => 'File upload failed']);
        }

        $this->original_file_name = $file->getClientOriginalName();
        $this->original_file_type = $file->getClientMimeType();
        // get real extension of the file
        $split_dot = explode('.', basename($this->original_file_name, '.part'));
        $this->original_file_extension = end($split_dot);

        $this->makeChunkDirectory();
        $path = Storage::disk('local')->path("{$this->chunk_path}/{$this->original_file_name}");

        File::append($path, $file->get());

        if ($request->has('is_last') && $request->boolean('is_last')) {
            if (!Storage::disk('public')->exists('/')) {
                Storage::disk('public')->makeDirectory('/');
            }
            
            $random_string = Str::random(24);
            $this->new_file_name = $random_string . '.' . $this->original_file_extension;
            File::move($path, storage_path("app/public/{$this->new_file_name}"));
            $upload_finish = true;
            $file_manager = $this->saveFileManager();
            return response()->json(['message' => 'File Uploaded', 'uploaded' => true, 'is_finished' => $upload_finish, 'file_manager' => $file_manager->load('user:id,name')]);
        }
        return response()->json(['message' => 'File Uploading', 'uploaded' => true, 'is_finished' => $upload_finish, 'file_manager' => $file_manager]);
    }

    /**
     * save file manager info
     *
     * @return FileManager
     */
    private function saveFileManager()
    {
        $storage = Storage::disk('public');
        $file_manager = new FileManager();
        $file_manager->name = basename($this->original_file_name, '.part');
        $file_manager->type = $this->original_file_type;
        $file_manager->size = $storage->size($this->new_file_name);
        $file_manager->path = $storage->url($this->new_file_name);
        $file_manager->thumbnail = $this->generateThumbnail($storage);
        $file_manager->save();
        return $file_manager;
    }

    /**
     * get file thumbnail
     *
     * @param $storage
     */
    private function generateThumbnail($storage)
    {
        $fileExtension = $this->original_file_extension;
        $defaultFIlePath = self::DEFAULT_FILE_PATH;

        switch ($this->original_file_type) {
            case Str::startsWith($this->original_file_type, 'image/'):
                $filePath = $storage->path($this->new_file_name);

                // Check file size (in bytes) and compress if greater than 1MB (1 * 1024 * 1024 = 1048576 bytes)
                if (filesize($filePath) > 1048576) {
                    $compressedImagePath = storage_path("app/public/compressed_{$this->new_file_name}");
                    Image::make($filePath)
                        ->resize(1200, null, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        })
                        ->encode($this->original_file_extension, 80) // Adjust compression level (80%)
                        ->save($compressedImagePath);

                    // Use the compressed file as the thumbnail
                    return $storage->url("compressed_{$this->new_file_name}");
                }

                // If file size is less than or equal to 1MB, use the original image
                return $storage->url($this->new_file_name);

            case Str::startsWith($this->original_file_type, 'video/'):
                return url("{$defaultFIlePath}/video.png");
            default:
                if (!in_array($fileExtension, FileManager::DEFAULT_FILE_EXTENSIONS)) {
                    return url("{$defaultFIlePath}/default.png");
                }
                return url("{$defaultFIlePath}/{$this->original_file_extension}.png");
        }
    }

    /**
     * make chunk dir
     *
     * @return void
     */
    private function makeChunkDirectory()
    {
        Storage::disk('local')->makeDirectory($this->chunk_path);
    }

    /**
     * file update
     *
     * @param FileManager $fileManager
     * @param FileUpdateRequest $request
     * @return JsonResponse
     */
    public function update(FileManager $fileManager, FileUpdateRequest $request)
    {
        $fileManager->alt = $request->alt;
        $fileManager->name = $request->name;
        $fileManager->caption = $request->caption;
        $fileManager->description = $request->description;
        $fileManager->save();

        return response()->json([
            'status' => true,
            'message' => 'File successfully updated'
        ]);
    }

    /**
     * file delete
     *
     * @param FileManager $fileManager
     * @return JsonResponse
     */
    public function delete(FileManager $fileManager)
    {
        $disk = 'public';
        $filePath = str_replace(url('/storage'), "", $fileManager->path);

        if (Storage::disk($disk)->exists($filePath)) {
            Storage::disk($disk)->delete($filePath);
        }

        // Derive compressed file path
        $compressedFilePath = str_replace(basename($filePath), 'compressed_' . basename($filePath), $filePath);

        // Check if the compressed file exists and mark it for deletion
        if (Storage::disk($disk)->exists($compressedFilePath)) {
            Storage::disk($disk)->delete($compressedFilePath);
        }

        $fileManager->delete();

        return response()->json([
            'status' => true,
            'message' => 'File successfully deleted'
        ]);
    }

    /**
     * files multi delete
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function multiDelete(Request $request)
    {
        $disk = 'public';
        $fileIds = $request->input('ids', []);

        if (empty($fileIds)) {
            return response()->json([
                'status' => false,
                'message' => 'No file IDs provided'
            ]);
        }

        $fileManagers = FileManager::whereIn('id', $fileIds)->get();
        $pathsToDelete = [];

        foreach ($fileManagers as $fileManager) {
            $filePath = str_replace(url('/storage'), '', $fileManager->path);
            if (Storage::disk($disk)->exists($filePath)) {
                $pathsToDelete[] = $filePath;
            }

            // Derive compressed file path
            $compressedFilePath = str_replace(basename($filePath), 'compressed_' . basename($filePath), $filePath);

            // Check if the compressed file exists and mark it for deletion
            if (Storage::disk($disk)->exists($compressedFilePath)) {
                $pathsToDelete[] = $compressedFilePath;
            }
        }

        // Delete the files from storage
        if (!empty($pathsToDelete)) {
            Storage::disk($disk)->delete($pathsToDelete);
        }

        // Delete the file manager records from the database
        FileManager::whereIn('id', $fileIds)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Files successfully deleted'
        ]);
    }

    /**
     * get file types
     *
     * @return JsonResponse
     */
    public function getFileTypes()
    {
        $mimeCategories = FileManager::MIME_CATEGORIES;
        $extToMime = FileManager::EXT_TO_MIME;

        $types = [
            [
                'value' => 'image/*',
                'title' => 'Images',
                'options' => implode(',', $mimeCategories['image/*'] ?? [])
            ],
            [
                'value' => 'audio/*',
                'title' => 'Audio',
                'options' => implode(',', $mimeCategories['audio/*'] ?? [])
            ],
            [
                'value' => 'video/*',
                'title' => 'Video',
                'options' => implode(',', $mimeCategories['video/*'] ?? [])
            ],
            [
                'value' => 'application/*',
                'title' => 'Documents',
                'options' => implode(',', $mimeCategories['application/*'] ?? [])
            ],
            [
                'value' => 'application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'title' => 'Spreadsheets',
                'options' => 'application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            ],
            [
                'value' => 'application/zip,application/x-7z-compressed,application/x-gzip,application/x-rar-compressed',
                'title' => 'Archives',
                'options' => 'application/zip,application/x-7z-compressed,application/x-gzip,application/x-rar-compressed'
            ]
        ];

        // Add specific file extensions as individual filter options
        foreach ($extToMime as $ext => $mime) {
            $types[] = [
                'value' => $mime,
                'title' => strtoupper($ext),
                'options' => $mime
            ];
        }

        return response()->json([
            'data' => $types,
            'status' => true,
            'message' => 'Fetched file types'
        ]);
    }
}

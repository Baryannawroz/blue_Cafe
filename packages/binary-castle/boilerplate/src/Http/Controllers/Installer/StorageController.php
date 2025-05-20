<?php

namespace BinaryCastle\Boilerplate\Http\Controllers\Installer;

use App\Http\Controllers\Controller;
use BinaryCastle\Boilerplate\Http\Requests\Installer\StorageSetupRequest;
use Brotzka\DotenvEditor\DotenvEditor;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StorageController extends Controller
{
    public function index()
    {
        return view('boilerplate::installer.storage-driver');
    }

    public function save(StorageSetupRequest $request)
    {
        $this->setConfig($request);
        try {
            $fileName = 'test.txt';
            $fileContent = 'Hello, this is a test file!';
            Storage::disk($request->storage_type)->put($fileName, $fileContent,'public');
            $this->setConfigInEnv($request);
            return redirect()->to($request->next_route);
        } catch (Exception $exception) {
            throw $exception;
            return redirect()->back()->withInput()->withErrors(['server_error' => $exception->getMessage()]);
        }
    }

    private function setConfig($request)
    {
        if ($request->storage_type == 's3') {
            config([
                'filesystems.disks.s3.key' => $request->s3_key,
                'filesystems.disks.s3.secret' => $request->s3_secret,
                'filesystems.disks.s3.region' => $request->s3_region,
                'filesystems.disks.s3.bucket' => $request->s3_bucket,
                'filesystems.disks.s3.url' => $request->s3_url,
                'filesystems.disks.s3.endpoint' => $request->s3_endpoint,
            ]);
        }
    }

    private function setConfigInEnv($request)
    {
        $env = new DotenvEditor();
        $env->changeEnv([
            'FILESYSTEM_DISK' => "{$request->storage_type}",
            'AWS_ACCESS_KEY_ID' => "{$request->s3_key}",
            'AWS_SECRET_ACCESS_KEY' => "{$request->s3_secret}",
            'AWS_DEFAULT_REGION' => "{$request->s3_region}",
            'AWS_BUCKET' => "{$request->s3_bucket}",
            'AWS_URL' => "{$request->s3_url}",
            'AWS_ENDPOINT' => "{$request->s3_endpoint}",
        ]);
    }
}

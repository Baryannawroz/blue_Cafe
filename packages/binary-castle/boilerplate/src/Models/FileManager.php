<?php

namespace BinaryCastle\Boilerplate\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class FileManager extends Model
{

    const DEFAULT_FILE_EXTENSIONS = [
        'chevron-down', 'css', 'csv', 'doc', 'docx', 'html', 'javascript', 'pdf', 'pdf', 'photoshop', 'php', 'ppt',
        'sql', 'txt', 'video', 'xls', 'xlsx', 'xml', 'zip'
    ];

    const MIME_CATEGORIES = [
        'image/*' => ['image/png', 'image/jpeg', 'image/gif', 'image/bmp', 'image/svg+xml', 'image/webp', 'image/tiff'],
        'video/*' => ['video/mp4', 'video/avi', 'video/mpeg', 'video/webm', 'video/quicktime', 'video/x-msvideo', 'video/x-flv'],
        'audio/*' => ['audio/mpeg', 'audio/wav', 'audio/ogg', 'audio/aac', 'audio/mp4'],
        'text/*' => ['text/plain', 'text/css', 'text/html', 'text/javascript', 'text/xml'],
        'application/*' => ['application/pdf', 'application/zip', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/x-sql', 'application/x-photoshop', 'application/x-httpd-php']
    ];

    const EXT_TO_MIME = [
        'chevron-down' => 'image/svg+xml',  // Assuming an SVG icon
        'css' => 'text/css',
        'csv' => 'text/csv',
        'doc' => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'html' => 'text/html',
        'javascript' => 'text/javascript',
        'js' => 'text/javascript',
        'json' => 'application/json',
        'pdf' => 'application/pdf',
        'photoshop' => 'application/x-photoshop',
        'php' => 'application/x-httpd-php',
        'ppt' => 'application/vnd.ms-powerpoint',
        'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        'sql' => 'application/x-sql',
        'txt' => 'text/plain',
        'video' => 'video/mp4',  // Defaulting to mp4, but you may expand it to all video types
        'xls' => 'application/vnd.ms-excel',
        'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'xml' => 'text/xml',
        'zip' => 'application/zip',
    ];

    protected static function boot()
    {
        parent::boot();

        self::creating(function (FileManager $file_manager) {
            $file_manager->user_id = auth()->id();
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

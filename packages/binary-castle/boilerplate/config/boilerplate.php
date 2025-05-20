<?php

use BinaryCastle\Boilerplate\Http\Controllers\Installer\DatabaseController;
use BinaryCastle\Boilerplate\Http\Controllers\Installer\InstallerController;
use BinaryCastle\Boilerplate\Http\Controllers\Installer\IntroController;
use BinaryCastle\Boilerplate\Http\Controllers\Installer\LogController;
use BinaryCastle\Boilerplate\Http\Controllers\Installer\PermissionController;
use BinaryCastle\Boilerplate\Http\Controllers\Installer\RequirementController;
use BinaryCastle\Boilerplate\Http\Controllers\Installer\StorageController;
use BinaryCastle\Boilerplate\Http\Controllers\Installer\VerificationController;
use BinaryCastle\Boilerplate\Http\Controllers\Installer\EmailController;
use BinaryCastle\Boilerplate\Http\Controllers\Installer\QueueController;

return [

    'project_name' => '',

    'installation_required' => true,

    'installation_finish_url' => '/',

    // php minimum version checker
    'core' => [
        'minPhpVersion' => '7.2.0'
    ],

    // php module requirements
    'requirements' => [
        'php' => [
            'OpenSSL',
            'PDO',
            'Mbstring',
            'Tokenizer',
            'XML',
            'JSON',
            'cURL',
            'Ctype',
            'Fileinfo'
        ],
        'apache' => [
            'mod_rewrite'
        ]
    ],
    // will check the directory and permission
    'permissions' => [
        'storage/framework/' => '775',
        'storage/logs/' => '775',
        'bootstrap/cache/' => '775',
    ],

    // must have steps
    'fixed_steps' => [
        'intro' => [
            'url' => '',
            'controller' => [IntroController::class, 'index'],
            'title' => 'Intro'
        ],
        'requirements' => [
            'url' => 'requirements',
            'controller' => [RequirementController::class, 'index'],
            'title' => 'Requirements',
        ],
        'permissions' => [
            'url' => 'permissions',
            'controller' => [PermissionController::class, 'index'],
            'title' => 'Permissions',
            'description' => 'permissions'
        ],
        'verify' => [
            'url' => 'verify',
            'controller' => [VerificationController::class, 'index'],
            'title' => 'Verification Centre',
            'description' => 'Verification Centre'
        ]
    ],

    'steps_enable' => [
        'database' => true,
        'pusher' => false,
        'email' => true,
        'queue' => false,
        'storage-driver' => false,
        'logs' => false,
        'finish' => true
    ],

    // I am thinking about a kvp what will decide which step will show or hide,
    // plus it will handle the order of the steps
    'steps' => [
        'database' => [
            'url' => 'database',
            'controller' => [DatabaseController::class, 'index'],
            'title' => 'Database',
            'description' => 'database',
        ],
        'pusher' => [
            'url' => 'pusher',
            'controller' => [InstallerController::class, 'pusher'],
            'title' => 'Pusher',
            'description' => 'pusher',
            'skippable' => true
        ],
        'email' => [
            'url' => 'mail',
            'controller' => [EmailController::class, 'index'],
            'title' => 'Email Setup',
            'description' => 'mail',
            'skippable' => false
        ],
        'queue' => [
            'url' => 'queue',
            'controller' => [QueueController::class, 'index'],
            'title' => 'Queue Setup',
            'description' => 'queue',
            'skippable' => true
        ],
        'storage-driver' => [
            'url' => 'storage-driver',
            'controller' => [StorageController::class, 'index'],
            'title' => 'Storage Driver',
            'description' => 'storage-driver',
        ],
        'logs' => [
            'url' => 'logs',
            'controller' => [LogController::class, 'index'],
            'title' => 'Logs',
            'description' => 'logs',
            'skippable' => true
        ],
        'finish' => [
            'url' => 'finish',
            'controller' => [InstallerController::class, 'installationComplete'],
            'title' => 'Finish'
        ]
    ]
];

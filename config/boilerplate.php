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

    'project_name' => 'Restulator - Restaurant Management System with integrated POS in Laravel',
    
    'installation_finish_url' => '/installation-complete',

    // php minimum version checker
    'core' => [
        'minPhpVersion' => '8.1.0',
    ],

    'steps_enable' => [
        'database' => true,
        'pusher' => true,
        'email' => true,
        'queue' => true,
        'logs' => false,
        'storage-driver' => false,
        'finish' => true
    ],


];

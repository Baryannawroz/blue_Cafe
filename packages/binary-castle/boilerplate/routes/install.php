<?php

use BinaryCastle\Boilerplate\Http\Controllers\Installer\DatabaseController;
use BinaryCastle\Boilerplate\Http\Controllers\Installer\EmailController;
use BinaryCastle\Boilerplate\Http\Controllers\Installer\IntroController;
use BinaryCastle\Boilerplate\Http\Controllers\Installer\LogController;
use BinaryCastle\Boilerplate\Http\Controllers\Installer\PermissionController;
use BinaryCastle\Boilerplate\Http\Controllers\Installer\PusherController;
use BinaryCastle\Boilerplate\Http\Controllers\Installer\QueueController;
use BinaryCastle\Boilerplate\Http\Controllers\Installer\RequirementController;
use BinaryCastle\Boilerplate\Http\Controllers\Installer\StorageController;
use BinaryCastle\Boilerplate\Http\Controllers\Installer\VerificationController;
use BinaryCastle\Boilerplate\Http\Middleware\VerifyInstall;
use BinaryCastle\Boilerplate\Http\Middleware\VerifyPurchase;
use BinaryCastle\Boilerplate\Services\Installer\Navigator;
use Illuminate\Support\Facades\Route;

$installerRoutes = Navigator::activeSteps()->values();

$installerRoutes->each(function ($item) {
    Route::get("{$item['url']}", $item['controller'])->name($item['url'])
        ->middleware(VerifyPurchase::class);
});


Route::post('intro', [IntroController::class, 'save'])->name('save.intro');
Route::post('requirements', [RequirementController::class, 'save'])->name('save.requirements');
Route::post('permissions', [PermissionController::class, 'save'])->name('save.permissions');
Route::post('verify', [VerificationController::class, 'save'])->name('save.verify');
Route::post('database', [DatabaseController::class, 'save'])->name('save.database');
Route::post('mail', [EmailController::class, 'save'])->name('save.mail');
Route::post('logs', [LogController::class, 'save'])->name('save.logs');
Route::post('storage-driver', [StorageController::class, 'save'])->name('save.storage');
Route::post('queue', [QueueController::class, 'save'])->name('save.queue');
Route::post('pusher', [PusherController::class, 'save'])->name('save.pusher');

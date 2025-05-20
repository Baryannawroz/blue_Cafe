<?php

use Illuminate\Support\Facades\Route;
use BinaryCastle\Boilerplate\Http\Controllers\API\AuthController;
use BinaryCastle\Boilerplate\Http\Controllers\API\FileManagerController;
use BinaryCastle\Boilerplate\Http\Controllers\API\PasswordResetController;
use BinaryCastle\Boilerplate\Http\Controllers\API\RoleController;

Route::middleware('guest')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forget-password', [PasswordResetController::class, 'forgotPassword']);
    Route::post('/reset-password', [PasswordResetController::class, 'resetPassword']);

});

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/auth-history', 'authHistory');
        Route::delete('/auth-history/{id}', 'deleteAuthHistory');
        Route::get('/get-current-user', 'currentUser');
        Route::post('/change-email', 'changeEmailAddress');
        Route::post('/logout', 'logout');
        Route::post('/change-password', [PasswordResetController::class, 'changePassword']);
        Route::get('/check-token', 'checkToken');
        Route::post('/profile', 'updateProfile');
    });

    Route::apiResource('role', RoleController::class);
    Route::get('/permissions', [RoleController::class, 'getAllPermission']);

    // File Manager
    Route::controller(FileManagerController::class)->group(function () {
        Route::post('/file-upload', 'store')->can('file-manager');
        Route::put('/file-update/{fileManager}', 'update')->can('file-manager');
        Route::get('/files', 'index')->can('file-manager');
        Route::delete('/file-delete/{fileManager}', 'delete')->can('file-manager');
        Route::post('/file-multi-delete', 'multiDelete')->can('file-manager');
        Route::get('/file-types', 'getFileTypes')->can('file-manager');
    });
});

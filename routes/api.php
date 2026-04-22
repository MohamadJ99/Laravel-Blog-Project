<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//  AUTH (login / register)
Route::middleware('throttle:auth')->group(function () {
    Route::post('register', [UserController::class, 'register']);
    Route::post('login', [UserController::class, 'login']);
});


//  READ (GET requests)
Route::middleware('throttle:api')->group(function () {

    Route::get('/posts', [PostController::class, 'index']);
    Route::get('/posts/{slug}', [PostController::class, 'show']);

    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{slug}/posts', [CategoryController::class, 'posts']);

    Route::get('/tags', [TagController::class, 'index']);
    Route::get('/tags/{slug}/posts', [TagController::class, 'posts']);
});


//  WRITE (POST / PUT / DELETE)
Route::middleware(['auth:sanctum', 'throttle:api.write'])->group(function () {

    Route::post('/posts', [PostController::class, 'store']);
    Route::put('/posts/{slug}', [PostController::class, 'update']);
    Route::delete('/posts/{slug}', [PostController::class, 'destroy']);
    Route::post('/posts/{slug}/publish', [PostController::class, 'publish']);
});





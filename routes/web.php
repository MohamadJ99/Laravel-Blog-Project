<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;



Route::get('/', [PostController::class, 'index'])
    ->name('posts.index');




Route::middleware('auth')->group(function () {

    // Create Post
    Route::get('/posts/create', [PostController::class, 'create'])
        ->name('posts.create');

    Route::post('/posts', [PostController::class, 'store'])
        ->name('posts.store');

    // Edit Post
    Route::get('/posts/{slug}/edit', [PostController::class, 'edit'])
        ->name('posts.edit');

    Route::put('/posts/{slug}', [PostController::class, 'update'])
        ->name('posts.update');

    // Delete Post
    Route::delete('/posts/{slug}', [PostController::class, 'destroy'])
        ->name('posts.destroy');

    // Publish Post
    Route::post('/posts/{slug}/publish', [PostController::class, 'publish'])
        ->name('posts.publish');

    
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});


Route::get('/posts/{slug}', [PostController::class, 'show'])
    ->name('posts.show');

    
Route::get('/dashboard', function () {
    return redirect('/');
})->middleware(['auth'])->name('dashboard');


require __DIR__.'/auth.php';
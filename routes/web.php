<?php

use App\Http\Controllers\PostsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\GalleryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/feed', [FeedController::class, 'index'])->name('feed');

Route::prefix('posts')->group(function () {
    Route::get('/', [PostsController::class, 'index'])->name('posts.index');
    Route::get('/store', [PostsController::class, 'create'])->name('posts.create');
    Route::get('/{post}', [PostsController::class, 'edit'])->name('posts.edit');
    Route::get('/detail/{post}', [PostsController::class, 'detail'])->name('posts.detail');
    Route::get('/profile/{user}', [PostsController::class, 'profile'])->name('posts.profile');
    Route::post('/store', [PostsController::class, 'store'])->name('posts.store');
    Route::put('/update/{id}', [PostsController::class, 'update'])->name('posts.update');
    Route::delete('/delete/{id}', [PostsController::class, 'delete'])->name('posts.delete');
});

Route::prefix('profile')->group(function () {
    Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/update/profile', [ProfileController::class, 'profile'])->name('profile.update.profile');
    Route::put('/update/detail', [ProfileController::class, 'detail'])->name('profile.update.detail');
    Route::post('/upload', [ProfileController::class, 'upload'])->name('profile.upload');
});

Route::prefix('gallery')->group(function () {
    Route::get('/create', [GalleryController::class, 'create'])->name('gallery.create');
    Route::get('/edit/{id}', [GalleryController::class, 'edit'])->name('gallery.edit');
    Route::get('/show/{id}', [GalleryController::class, 'show'])->name('gallery.show');
    Route::post('/store', [GalleryController::class, 'store'])->name('gallery.store');
    Route::put('/{id}', [GalleryController::class, 'update'])->name('gallery.update');
    Route::delete('/delete/{id}', [GalleryController::class, 'delete'])->name('images.delete');
    Route::delete('/destroy/{id}', [GalleryController::class, 'destroy'])->name('gallery.delete');
});


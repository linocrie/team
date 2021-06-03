<?php

use App\Http\Controllers\PostsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\GalleriesController;
use App\Http\Controllers\Admin\ProfessionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\UploadController;

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

Route::prefix('/posts')->group(function () {
    Route::get('/', [PostsController::class, 'index'])->name('posts.index');
    Route::get('/store', [PostsController::class, 'create'])->name('posts.create');
    Route::get('/{post}', [PostsController::class, 'edit'])->name('posts.edit');
    Route::get('/detail/{post}', [PostsController::class, 'show'])->name('posts.detail');
    Route::get('/profile/{user}', [PostsController::class, 'profile'])->name('posts.profile');
    Route::post('/store', [PostsController::class, 'store'])->name('posts.store');
    Route::put('/update/{post}', [PostsController::class, 'update'])->name('posts.update');
    Route::delete('/delete/{post}', [PostsController::class, 'delete'])->name('posts.delete');
});

Route::prefix('/profile')->group(function () {
    Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/update/profile', [ProfileController::class, 'update'])->name('profile.update.profile');
    Route::put('/update/detail', [DetailController::class, 'update'])->name('profile.update.detail');
    Route::post('/upload', [UploadController::class, 'update'])->name('profile.upload');
});

Route::prefix('/gallery')->group(function () {
    Route::get('/create', [GalleryController::class, 'create'])->name('gallery.create');
    Route::get('/edit/{gallery}', [GalleryController::class, 'edit'])->name('gallery.edit');
    Route::get('/show/{id}', [GalleryController::class, 'show'])->name('gallery.show');
    Route::post('/store', [GalleryController::class, 'store'])->name('gallery.store');
    Route::put('/update/{gallery}', [GalleryController::class, 'update'])->name('gallery.update');
    Route::delete('/delete/{images}', [GalleryController::class, 'delete'])->name('images.delete');
    Route::delete('/destroy/{gallery}', [GalleryController::class, 'destroy'])->name('gallery.delete');
});

Route::prefix('/admin')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::delete('/users/{user}', [UserController::class, 'delete'])->name('admin.users.delete');
    Route::get('/posts', [PostController::class, 'index'])->name('admin.posts.index');
    Route::get('/galleries', [GalleriesController::class, 'index'])->name('admin.galleries.index');
    Route::get('/professions', [ProfessionController::class, 'index'])->name('admin.professions.index');
});


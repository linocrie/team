<?php

use App\Http\Controllers\PostsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FeedController;

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
Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
Route::get('/posts', [PostsController::class, 'index'])->name('posts.index');
Route::get('/posts/store', [PostsController::class, 'showCreate'])->name('posts.create');
Route::get('/posts/{post}', [PostsController::class, 'showEdit'])->name('posts.edit');

Route::put('/posts/update/{id}', [PostsController::class, 'update'])->name('posts.update');
Route::delete('/posts/delete/{id}', [PostsController::class, 'delete'])->name('posts.delete');
Route::post('/posts/store', [PostsController::class, 'store'])->name('posts.store');
Route::put('/profile/updateProfile', [ProfileController::class, 'updateProfile'])->name('profile.update.profile');
Route::put('/profile/updateDetail', [ProfileController::class, 'updateDetail'])->name('profile.update.detail');
Route::put('/profile/upload', [ProfileController::class, 'upload'])->name('profile.upload');


<?php

use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
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

Route::post('upload/upload', [UploadController::class, 'store'])->name('filepond.store');
Route::delete('upload/delete', [UploadController::class, 'delete'])->name('filepond.delete');


Route::group(['middleware' => 'auth'], function (){
    Route::get('/dashboard', [MovieController::class, 'index'])->name('dashboard');
    Route::resource('profile', ProfileController::class)->except(['search']);
    Route::resource('movies', MovieController::class)->except(['search']);
    Route::resource('posts', PostController::class)->except(['store', 'search']);
    Route::post('posts/{id?}', [PostController::class, 'store'])->name('posts.store');
    Route::resource('comments', CommentController::class)->except(['store']);
    Route::post('comments/{id?}', [CommentController::class, 'store'])->name('comments.store');
    Route::get('follow/{id?}',[ProfileController::class, 'follow'] )->name('profile.follow');
    Route::get('unfollow/{id?}',[ProfileController::class, 'unfollow'] )->name('profile.unfollow');
    Route::get('search/movies',[MovieController::class, 'search'] )->name('movies.search');
    Route::get('search/posts',[PostController::class, 'search'] )->name('posts.search');
    Route::get('search/people',[ProfileController::class, 'search'] )->name('profile.search');
});

require __DIR__.'/auth.php';

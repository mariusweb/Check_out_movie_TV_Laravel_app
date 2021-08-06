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
    Route::resource('profile', ProfileController::class);
    Route::resource('movies', MovieController::class);
    Route::resource('posts', PostController::class)->except(['store']);
    Route::post('posts/{id?}', [PostController::class, 'store'])->name('posts.store');
    Route::resource('comments', CommentController::class);
});

require __DIR__.'/auth.php';

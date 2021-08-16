<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\ReviewController;


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

Route::get('/',[Postcontroller::class, 'index']);

Auth::routes();
Route::group(['middleware' => 'auth'], function() {
    Route::get('post/create', [PostController::class, 'create'])->name('post.create');
    Route::post('post/store', [PostController::class, 'store'])->name('post.store');
    Route::get('post/{post}/edit', [PostController::class, 'edit'])->name('post.edit');
    Route::put('post/{post}', [PostController::class, 'update'])->name('post.update');
    Route::delete('post/{post}', [PostController::class, 'destroy'])->name('post.destroy');
    Route::get('create/{id}', [ReviewController::class, 'create'])->name('review.create');
    Route::post('review', [ReviewController::class, 'store'])->name('review.store');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::post('post/search', [PostController::class, 'search'])->name('post.search');

Route::resource('post', PostController::class)->only([
    'index','show'
]);



Route::get('tag/{tag}',[TagController::class, 'tagIndex'])->name('tag.index');
Route::get('map',[MapController::class, 'mapIndex'])->name('map.index');
Route::get('map/{id}',[MapController::class, 'mapShow'])->name('map.show');

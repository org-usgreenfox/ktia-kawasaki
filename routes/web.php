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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('post', PostController::class);
Route::get('create/{id}', [ReviewController::class, 'create'])->name('review.create');
Route::post('review', [ReviewController::class, 'store'])->name('review.store');

Route::get('tag',[TagController::class, 'tagIndex'])->name('tag.index');
Route::get('map',[MapController::class, 'mapIndex'])->name('map.index');
Route::get('map/{id}',[MapController::class, 'mapShow'])->name('map.show');

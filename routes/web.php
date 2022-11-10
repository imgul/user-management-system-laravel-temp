<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ImageUploadController;

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

Route::controller(FrontendController::class)->group(function () {
    Route::get('/', 'index')->name('front.index');
});

Route::controller(ImageUploadController::class)->group(function () {
    Route::get('/image-upload', 'create')->name('front.image-upload.show');
    Route::post('/image-upload-submit', 'store')->name('fron.image-upload.store');
});

Route::controller(TodoController::class)->group(function () {
    Route::get('/todo', 'index')->name('todo.index');
    Route::post('/todo', 'store')->name('todo.store');
    Route::get('/fetch-todos', 'fetchTodo')->name('todo.fetch');
    Route::get('/todo/edit/{id}', 'editTodo')->name('todo.edit');
    Route::post('/todo/update/{id}', 'updateTodo')->name('todo.update');
});

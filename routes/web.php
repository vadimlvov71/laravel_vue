<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ShopController;
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
/*
Route::get('/', function () {
    return view('welcome');
});
* */
/*
Route::get('/home', function () {
    return view('home');
});
* */
//Auth::routes();
//Route::get('test', [TestController::class, 'test']);
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Route::get('/api/update', [PostController::class, 'update']);
//Route::get('/post/add', [PostController::class, 'add']);
//Route::get('/api/posts', [PostController::class, 'index']);
//Route::post('/post/update', [PostController::class, 'update']);

Route::prefix('api')->group(function () {
	Route::post('/add', [PostController::class, 'add']);
	Route::post('/update/{id}', [ShopController::class, 'update']);
	Route::get('/update/{id}', [ShopController::class, 'update']);
	Route::get('/items', [ShopController::class, 'index']);
	Route::get('/show/{id}', [ShopController::class, 'show']);
	Route::post('/savephoto', [PhotoController::class, 'savephoto']);
	Route::get('/getCategories', [ShopController::class, 'getCategories']);

});

Route::get('{any}', function () {
    return view('layouts.app');
})->where('any', '.*');

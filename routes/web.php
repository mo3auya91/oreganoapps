<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\TypesController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\ImagesController;

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

Route::namespace('App\Http\Controllers')->group(function () {
    Auth::routes();
});

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::resource('types', TypesController::class)->except('show');
    Route::get('categories/{category}/status', [CategoriesController::class, 'updateStatus'])->name('categories.status');
    Route::resource('categories', CategoriesController::class)->except('show');
    Route::resource('categories.images', ImagesController::class);
});

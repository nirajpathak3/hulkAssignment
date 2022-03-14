<?php

use Illuminate\Support\Facades\Route;

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

// user protected routes
Route::group(['middleware' => ['auth', 'user'], 'prefix' => 'user'], function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('user_dashboard');
    Route::get('/{post_url}', [App\Http\Controllers\HomeController::class, 'showForm'])->name('user_Form');    
    Route::post('/submitform', [App\Http\Controllers\HomeController::class, 'submitForm']);
    
});

// admin protected routes
Route::group(['middleware' => ['auth', 'admin'], 'prefix' => 'admin'], function () {
    Route::get('/', [App\Http\Controllers\AdminController::class, 'index'])->name('admin_dashboard');
    Route::get('/createform', [App\Http\Controllers\AdminController::class, 'createForm']);
    Route::post('/createform', [App\Http\Controllers\AdminController::class, 'saveForm']);
    Route::get('/formlist', [App\Http\Controllers\AdminController::class, 'listAllForms']);
});

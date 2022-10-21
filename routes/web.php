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

require __DIR__.'/auth.php';

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware(['auth']);
Route::post('/postRecipe', [App\Http\Controllers\HomeController::class, 'postRecipe'])->name('postRecipe');
Route::post('/deleteRecipe', [App\Http\Controllers\HomeController::class, 'deleteRecipe'])->name('deleteRecipe');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

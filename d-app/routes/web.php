<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [MainController::class, 'index']);

Route::post('/upload', [MainController::class, 'upload']);

Route::get('/getId/{id}', [MainController::class, 'getId']);

Route::post('/upsert', [MainController::class, 'upsert']);

Route::get('/delete/{id}', [MainController::class, 'delete']);



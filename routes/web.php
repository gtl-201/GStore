<?php

use App\Http\Controllers\AdminControler;
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

// Route::get('/', [AdminControler::class, 'index']);
Route::get('/admin', [AdminControler::class, 'login']);
Route::get('/admin/login', [AdminControler::class, 'login']);
Route::get('/admin/dashboard', [AdminControler::class, 'index']);
Route::get('/admin/icons', [AdminControler::class, 'icons']);
Route::get('/admin/product', [AdminControler::class, 'product']);
Route::get('/admin/logout', [AdminControler::class, 'handleLogout']);

Route::post('/admin/login', [AdminControler::class, 'handleLogin']);




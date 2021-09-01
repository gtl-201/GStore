<?php

use App\Http\Controllers\AdminControler;
use App\Http\Controllers\warehouseAjaxController;
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

Route::get('/admin/chooseWarehouse', [AdminControler::class, 'chooseWarehouse']);
Route::post('/admin/chooseWarehouse', [AdminControler::class, 'chooseWarehouseHandle']);

// Route::get('/admin/warehouse/all', [AdminControler::class, 'allWarehouse']);
// Route::post('/admin/warehouse/all', [AdminControler::class, 'addWarehouse'])->name('create');
// Route::get('/admin/warehouse/all/{id}', [AdminControler::class, 'deleteWarehouse'])->name('delete');

Route::post('/admin/login', [AdminControler::class, 'handleLogin']);
// Route::resource('', 'warehouseAjaxController');

Route::prefix('/admin/warehouse')->group(function () {
    //admin route
    Route::get('/', [warehouseAjaxController::class, 'index']);
    Route::post('/', [warehouseAjaxController::class, 'store']);
    Route::get('/{id}', [warehouseAjaxController::class, 'edit']);
    Route::post('/update', [warehouseAjaxController::class, 'update']);
    Route::delete('/{id}', [warehouseAjaxController::class, 'destroy']);
 });

Route::resource('/warehouseAjax','warehouseAjaxController');

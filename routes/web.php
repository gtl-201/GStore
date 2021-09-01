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
Route::prefix('admin')->group(function () {
    Route::middleware(['auth.admin'])->group(function () {
        Route::get('/', [AdminControler::class, 'login'])->withoutMiddleware('auth.admin');
        Route::get('/login', [AdminControler::class, 'login'])->name('admin.login')->withoutMiddleware('auth.admin');
        Route::get('/dashboard', [AdminControler::class, 'index']);
        Route::get('/icons', [AdminControler::class, 'icons']);
        Route::get('/product', [AdminControler::class, 'product']);
        Route::get('/logout', [AdminControler::class, 'handleLogout']);

        Route::get('/chooseWarehouse', [AdminControler::class, 'chooseWarehouse']);
        Route::post('/chooseWarehouse', [AdminControler::class, 'chooseWarehouseHandle']);

    // Route::get('/admin/warehouse/all', [AdminControler::class, 'allWarehouse']);
    // Route::post('/admin/warehouse/all', [AdminControler::class, 'addWarehouse'])->name('create');
    // Route::get('/admin/warehouse/all/{id}', [AdminControler::class, 'deleteWarehouse'])->name('delete');

        Route::post('/login', [AdminControler::class, 'handleLogin'])->withoutMiddleware('auth.admin');
        // Route::resource('', 'warehouseAjaxController');

        Route::prefix('/warehouse')->group(function () {
            //admin route
            Route::get('/', [warehouseAjaxController::class, 'index']);
            Route::post('/', [warehouseAjaxController::class, 'store']);
            Route::get('/{id}', [warehouseAjaxController::class, 'edit']);
            Route::post('/update', [warehouseAjaxController::class, 'update']);
            Route::delete('/{id}', [warehouseAjaxController::class, 'destroy']);
            
        });
    });
});


Route::resource('/warehouseAjax','warehouseAjaxController');

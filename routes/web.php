<?php

use App\Http\Controllers\AdminControler;
use App\Http\Controllers\attributeAjaxController;
use App\Http\Controllers\productController;
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
        Route::get('/dashboard', [AdminControler::class, 'index'])->name('dashboard');
        
        Route::prefix('account')->group(function () {
            Route::middleware(['auth.superAdmin'])->group(function () {
                Route::get('/', [AdminControler::class, 'IndexAccount']);
                Route::post('/', [AdminControler::class, 'addAccount']);
                Route::delete('/{id}', [AdminControler::class, 'destroyAccount']);
                Route::get('/{id}', [AdminControler::class, 'editAccount']);
                Route::post('/update', [AdminControler::class, 'updateAccount']);

            });         
        });
        
        Route::get('/icons', [AdminControler::class, 'icons']);
        Route::get('/product', [productController::class, 'index']);
        Route::get('/logout', [AdminControler::class, 'handleLogout']);

        Route::get('/chooseWarehouse', [AdminControler::class, 'chooseWarehouse']);
        Route::post('/chooseWarehouse', [AdminControler::class, 'chooseWarehouseHandle']);

        Route::post('/login', [AdminControler::class, 'handleLogin'])->withoutMiddleware('auth.admin');

        Route::prefix('/product')->group(function () {
            Route::prefix('/attribute')->group(function () {
                Route::prefix('/color')->group(function () {
                    Route::get('/', [attributeAjaxController::class, 'indexColor']);
                    Route::post('/', [attributeAjaxController::class, 'storeColor']);
                    Route::get('/{id}', [attributeAjaxController::class, 'editColor']);
                    Route::post('/update', [attributeAjaxController::class, 'updateColor']);
                    Route::delete('/{id}', [attributeAjaxController::class, 'destroyColor']);
                });
                Route::prefix('/size')->group(function () {
                    Route::get('/', [attributeAjaxController::class, 'indexSize']);
                    Route::post('/', [attributeAjaxController::class, 'storeSize']);
                    Route::get('/{id}', [attributeAjaxController::class, 'editSize']);
                    Route::post('/update', [attributeAjaxController::class, 'updateSize']);
                    Route::delete('/{id}', [attributeAjaxController::class, 'destroySize']);
                });
                Route::prefix('/brand')->group(function () {
                    Route::get('/', [attributeAjaxController::class, 'indexBrand']);
                    Route::post('/', [attributeAjaxController::class, 'storeBrand']);
                    Route::get('/{id}', [attributeAjaxController::class, 'editBrand']);
                    Route::post('/update', [attributeAjaxController::class, 'updateBrand']);
                    Route::delete('/{id}', [attributeAjaxController::class, 'destroyBrand']);
                });
            });
        });

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

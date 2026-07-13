<?php

use App\Http\Controllers\ApiControllers\AuthController;
use App\Http\Controllers\ApiControllers\CategoryController;
use App\Http\Controllers\ApiControllers\CustomerController;
use App\Http\Controllers\ApiControllers\DashboardController;
use App\Http\Controllers\ApiControllers\ProductController;
use App\Http\Controllers\ApiControllers\PurchaseController;
use App\Http\Controllers\ApiControllers\ReportController;
use App\Http\Controllers\ApiControllers\SaleController;
use App\Http\Controllers\ApiControllers\SettingController;
use App\Http\Controllers\ApiControllers\SupplierController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;









/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/**
 * public routes
*/
Route::post('/login', [AuthController::class, 'login'])->name('api.login');
Route::post('/register', [AuthController::class, 'register'])->name('api.register');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('api.reset-password');


/**
 * protected routes
*/
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');

    Route::prefix('dashboard')->group(function(){
        Route::get('/', [DashboardController::class, 'index'])->name('api.dashboard.index');
    });

    Route::prefix('report')->group(function(){
        Route::get('/', [ReportController::class, 'index'])->name('api.report.index');
    });

   Route::prefix('customers')->group(function(){
        Route::get('/', [CustomerController::class, 'index'])->name('api.customers.index');
        Route::get('/{id}', [CustomerController::class, 'show'])->name('api.customers.show');
        Route::post('/create', [CustomerController::class, 'store'])->name('api.customers.store');
        Route::put('/update/{id}', [CustomerController::class, 'update'])->name('api.customers.update');
        Route::delete('/delete/{id}', [CustomerController::class, 'destroy'])->name('api.customers.destroy');
   });
   Route::prefix('categories')->group(function(){
        Route::get('/', [CategoryController::class, 'index'])->name('api.categories.index');
        Route::get('/{id}', [CategoryController::class, 'show'])->name('api.categories.show');
        Route::post('/create', [CategoryController::class, 'store'])->name('api.categories.store');
        Route::put('/update/{id}', [CategoryController::class, 'update'])->name('api.categories.update');
        Route::delete('/delete/{id}', [CategoryController::class, 'destroy'])->name('api.categories.destroy');

   });

    Route::prefix('products')->group(function(){
        Route::get('/', [ProductController::class, 'index'])->name('api.products.index');
        Route::get('/{id}', [ProductController::class, 'show'])->name('api.products.show')->whereNumber('id');
        Route::post('/create', [ProductController::class, 'store'])->name('api.products.store');
        Route::put('/update/{id}', [ProductController::class, 'update'])->name('api.products.update')->whereNumber('id');
        Route::delete('/delete/{id}', [ProductController::class, 'destroy'])->name('api.products.destroy')->whereNumber('id');
    });

    Route::prefix('suppliers')->group(function(){
        Route::get('/', [SupplierController::class, 'index'])->name('api.suppliers.index');
        Route::get('/{id}', [SupplierController::class, 'show'])->name('api.suppliers.show')->whereNumber('id');
        Route::post('/create', [SupplierController::class, 'store'])->name('api.suppliers.store');
        Route::put('/update/{id}', [SupplierController::class, 'update'])->name('api.suppliers.update')->whereNumber('id');
        Route::delete('/delete/{id}', [SupplierController::class, 'destroy'])->name('api.suppliers.destroy')->whereNumber('id');
    });

    Route::prefix('purchases')->group(function(){
        Route::get('/', [PurchaseController::class, 'index'])->name('api.purchases.index');
        Route::get('/{id}', [PurchaseController::class, 'show'])->name('api.purchases.show')->whereNumber('id');
        Route::post('/create', [PurchaseController::class, 'store'])->name('api.purchases.store');
        Route::put('/update/{id}', [PurchaseController::class, 'update'])->name('api.purchases.update')->whereNumber('id');
        Route::delete('/delete/{id}', [PurchaseController::class, 'destroy'])->name('api.purchases.destroy')->whereNumber('id');
    });

    Route::prefix('sales')->group(function(){
        Route::get('/', [SaleController::class, 'index'])->name('api.sales.index');
        Route::get('/{id}', [SaleController::class, 'show'])->name('api.sales.show');
        Route::post('/create', [SaleController::class, 'store'])->name('api.sales.store');
        Route::put('/update/{id}', [SaleController::class, 'update'])->name('api.sales.update');
        Route::delete('/delete/{id}', [SaleController::class, 'destroy'])->name('api.sales.destroy');
    });

    Route::prefix('setting')->group(function(){
        Route::get('/', [SettingController::class, 'index'])->name('api.setting.index');
        Route::post('/create', [SettingController::class, 'store'])->name('api.setting.store');
    });
});





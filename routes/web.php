<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;












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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');

    Route::get('/', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/forget-password', [AuthController::class, 'showForgetPassword'])->name('password.forget');
    Route::post('/forget-password', [AuthController::class, 'forgetPassword'])->name('password.forget.store');
    Route::get('/reset-password', [AuthController::class, 'resetPasswordForm'])->name('password.reset.show');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.reset.store');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


Route::middleware('auth')->group(function () {

        Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        Route::view('/admin/suppliers', 'admin.suppliers')->name('admin.suppliers');
        Route::view('/admin/purchases', 'admin.purchases')->name('admin.purchases');
        Route::view('/admin/sales', 'admin.sales')->name('admin.sales');
        Route::view('/admin/customers', 'admin.customers')->name('admin.customers');
        Route::view('/admin/reports', 'admin.reports')->name('admin.reports');
        Route::view('/admin/settings', 'admin.settings')->name('admin.settings');


        Route::prefix('/products')->group(function () {
            Route::get('/', [ProductController::class, 'index'])->name('products.index');
            Route::get('/single/{id}', [ProductController::class, 'show'])->name('products.show');
            Route::get('/create', [ProductController::class, 'create'])->name('products.create');
            Route::post('/store', [ProductController::class, 'store'])->name('products.store');
            Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
            Route::put('/update/{id}', [ProductController::class, 'update'])->name('products.update');
            Route::delete('/delete/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
        });

        Route::prefix('/categories')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
            Route::get('/single/{id}', [CategoryController::class, 'show'])->name('categories.show');
            Route::get('/create', [CategoryController::class, 'create'])->name('categories.create');
            Route::post('/store', [CategoryController::class, 'store'])->name('categories.store');
            Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('categories.edit');
            Route::put('/update/{id}', [CategoryController::class, 'update'])->name('categories.update');
            Route::delete('/delete/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
        });


        Route::prefix('/stock-movements')->group(function () {
            Route::get('/', [StockMovementController::class, 'index'])->name('stock-movements.index');
            Route::get('/create', [StockMovementController::class, 'create'])->name('stock-movements.create');
            Route::post('/store', [StockMovementController::class, 'store'])->name('stock-movements.store');
        });


        Route::prefix('/suppliers')->group(function () {
            Route::get('/', [SupplierController::class, 'index'])->name('suppliers.index');
            Route::get('/single/{id}', [SupplierController::class, 'show'])->name('suppliers.show');
            Route::get('/create', [SupplierController::class, 'create'])->name('suppliers.create');
            Route::post('/store', [SupplierController::class, 'store'])->name('suppliers.store');
            Route::get('/edit/{id}', [SupplierController::class, 'edit'])->name('suppliers.edit');
            Route::put('/update/{id}', [SupplierController::class, 'update'])->name('suppliers.update');
            Route::delete('/delete/{id}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');
        });


        Route::prefix('/purchases')->group(function () {
            Route::get('/', [PurchaseController::class, 'index'])->name('purchases.index');
            Route::get('/single/{id}', [PurchaseController::class, 'show'])->name('purchases.show');
            Route::get('/create', [PurchaseController::class, 'create'])->name('purchases.create');
            Route::post('/store', [PurchaseController::class, 'store'])->name('purchases.store');
            Route::delete('/delete/{id}', [PurchaseController::class, 'destroy'])->name('purchases.destroy');
        });


        Route::prefix('/sales')->group(function () {
            Route::get('/', [SaleController::class, 'index'])->name('sales.index');
            Route::get('/single/{id}', [SaleController::class, 'show'])->name('sales.show');
            Route::get('/create', [SaleController::class, 'create'])->name('sales.create');
            Route::post('/store', [SaleController::class, 'store'])->name('sales.store');
            Route::get('/edit/{id}', [SaleController::class, 'edit'])->name('sales.edit');
            Route::put('/update/{id}', [SaleController::class, 'update'])->name('sales.update');
            Route::delete('/delete/{id}', [SaleController::class, 'destroy'])->name('sales.destroy');
        });

        Route::prefix('/customers')->group(function () {
            Route::get('/', [CustomerController::class, 'index'])->name('customers.index');
            Route::get('/single/{id}', [CustomerController::class, 'show'])->name('customers.show');
            Route::get('/create', [CustomerController::class, 'create'])->name('customers.create');
            Route::post('/store', [CustomerController::class, 'store'])->name('customers.store');
            Route::get('/edit/{id}', [CustomerController::class, 'edit'])->name('customers.edit');
            Route::put('/update/{id}', [CustomerController::class, 'update'])->name('customers.update');
            Route::delete('/delete/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');
        });


        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

        Route::prefix('/settings')->group(function () {
            Route::get('/', [SettingController::class, 'index'])->name('settings.index');
            Route::post('/update', [SettingController::class, 'update'])->name('settings.update');
        });

});




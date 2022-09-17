<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SalesTypeController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('auth.login');
})->name('login');

Route::post('/auth', [AuthController::class, 'auth']);

Route::group(['middleware' => ['auth']], function () {
    Route::get('home', function () {
        return view('home.index');
    })->name('home');

    Route::get('order', [OrderController::class, 'index'])->name('order.index');
    
    Route::get('category/data', [CategoryController::class, 'data'])->name('category.data');
    Route::resource('category', CategoryController::class);
    
    Route::get('products/items', [ProductController::class, 'items'])->name('products.items');
    Route::get('products/data', [ProductController::class, 'data'])->name('products.data');
    Route::resource('products', ProductController::class);

    Route::get('sales_type/data', [SalesTypeController::class, 'data'])->name('sales_type.data');
    Route::resource('sales_type', SalesTypeController::class);

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

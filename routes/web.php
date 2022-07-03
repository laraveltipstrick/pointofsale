<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

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
    Route::get('category/data', [CategoryController::class, 'data'])->name('category.data');
    Route::resource('category', CategoryController::class);
    
    Route::get('products/data', [ProductController::class, 'data'])->name('products.data');
    Route::resource('products', ProductController::class);

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

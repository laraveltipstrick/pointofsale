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

Route::get('/test', function () {
    // return view('welcome');
    // $collection = collect(['Java', 'Python', 'PHP', 'C#']);
 
    // $reversed = $collection->reverse();
    
    // $reversed->all();

    $collection = collect([
        10 => ['product' => 'Desk', 'price' => 200],
        15 => ['product' => 'Desk', 'price' => 200],
    ]);
     
    $values = $collection->values();
     
    dd($values->all());
    
});

Route::get('/', function () {
    return view('auth.login');
})->name('login');

Route::post('/auth', [AuthController::class, 'auth']);

Route::group(['middleware' => ['auth']], function () {
    Route::get('home', function () {
        return view('home.index');
    })->name('home');

    Route::get('order', [OrderController::class, 'index'])->name('order.index');
    Route::post('order', [OrderController::class, 'store'])->name('order.store');
    Route::get('billing_list', [OrderController::class, 'billing_list'])->name('order.billing.list');
    Route::get('billing_select/{transaction_id}', [OrderController::class, 'billing_select']);
    
    Route::get('category/data', [CategoryController::class, 'data'])->name('category.data');
    Route::resource('category', CategoryController::class);
    
    Route::get('products/items', [ProductController::class, 'items'])->name('products.items');
    Route::get('products/data', [ProductController::class, 'data'])->name('products.data');
    Route::resource('products', ProductController::class);

    Route::get('sales_type/data', [SalesTypeController::class, 'data'])->name('sales_type.data');
    Route::resource('sales_type', SalesTypeController::class);

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

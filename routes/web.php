<?php

use App\Http\Controllers\Blog\BlogWebController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentCallbackController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Auth;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();
Route::middleware(['auth', 'blogWeb'])->group(function () {
    Route::prefix('blog')->group(function () {
        Route::get('/home', [BlogWebController::class, 'index'])->name('blog.index');
        Route::get('/detail/{post_id}', [BlogWebController::class, 'show'])->name('blog.detail');
        Route::get('/category/{category_id}', [BlogWebController::class, 'byCategory'])->name('blog.byCategory');
        Route::get('/tag/{tag_id}', [BlogWebController::class, 'byTag'])->name('blog.byTag');
        Route::get('/my-pages', [BlogWebController::class, 'myPages'])->name('blog.myPages');
    });
});

Route::middleware(['auth', 'olshop'])->group(function () {
    Route::prefix('olshop')->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('home');
        // Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        Route::get('/cart', [CartController::class, 'index'])->name('cart');
        Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    });
});


Route::get('/test-payment/{id}', [PaymentController::class, 'index'])->name('test.payment');
Route::post('/payment-callback', PaymentCallbackController::class)->name('payment_callback');
Route::get('checkout', CheckoutController::class)->name('checkout');

//for ajax
Route::post('/cart/{id}', [CartController::class, 'updateQty'])->name('cart.qty.update')->secure();
Route::get('/cart/new-total', [CartController::class, 'getNewTotal'])->name('cart.new.total')->secure();
Route::get('cart/add/{id}', [CartController::class, 'addCart'])->name('cart.add');
Route::delete('cart/delete/{id}', [CartController::class, 'deleteCart'])->name('cart.delete');

Route::fallback(function () {
    return redirect()->route('login');
});
<?php

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

require 'admin.php';

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

// Route::view('/admin', 'admin.dashboard.index');

Route::get('/aneer', function () {

    $order = Order::first();

    // $product = Product::all();
    $order->products()->sync([
        1 => [
            'price' => '1000',
            'quantity' => 1,
        ],
    2 => [
            'price' => '300',
            'quantity' => 3,
        ]
    ]);
    $aneer = Order::first()->products()->get()->toArray();

    return response()->json($aneer);


});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', 'Site\HomeController@index');
// Route::view('/', 'site.pages.homepage');

Route::get('/category/{slug}', 'Site\CategoryController@show')->name('category.show');
Route::get('/product/{slug}', 'Site\ProductController@show')->name('product.show');

Route::get('/product/{id}/click', 'Site\ProductController@click')->name('product.click');

Route::post('/product/add/cart', 'Site\ProductController@addToCart')->name('product.add.cart');
Route::get('/cart', 'Site\CartController@getCart')->name('checkout.cart');
Route::get('/cart/item/{id}/remove', 'Site\CartController@removeItem')->name('checkout.cart.remove');
Route::get('/cart/clear', 'Site\CartController@clearCart')->name('checkout.cart.clear');

Route::get('/payment/complete', 'Site\CheckoutController@complete')->name('complete.payment');

Route::get('/order/complete/{order_number}', 'Site\CheckoutController@order')->name('order.complete');

Route::post('/payment/update', 'Site\CheckoutController@complete')->name('payment.update');

Route::get('/invitation/{token}', 'Auth\InvitationController@password')->name('invitation.validate');

Route::get('/order/print/{id}', 'Auth\DeliveryController@print');

Route::group(['prefix'  =>   'orders'], function() {


    Route::get('/{order_number}', 'Site\OrderController@index');


});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/checkout', 'Site\CheckoutController@getCheckout')->name('checkout.index');
    Route::post('/checkout/order', 'Site\CheckoutController@placeOrder')->name('checkout.place.order');

    Route::get('checkout/payment/complete', 'Site\CheckoutController@complete')->name('checkout.payment.complete');
    Route::get('account/orders', 'Site\AccountController@getOrders')->name('account.orders');

});


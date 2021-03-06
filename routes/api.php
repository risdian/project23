<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/', function () {
    return 'aneer';
});


Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'Auth\AuthController@login')->name('login');
    Route::post('register', 'Auth\AuthController@register');
    Route::post('invitation/create', 'Auth\InvitationController@invite');

    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'Auth\AuthController@logout');
        Route::get('user', 'Auth\AuthController@user');
        Route::get('user/{id}', 'Auth\AuthController@getUser');
        Route::get('product/index', 'Auth\ProductController@index');
        Route::get('product/{id}/edit', 'Auth\ProductController@edit');
        Route::post('product/create', 'Auth\ProductController@create');
        Route::post('product/update', 'Auth\ProductController@update');


        Route::group(['prefix'  =>   'invitations'], function() {

            Route::get('/{id}', 'Auth\InvitationController@profile');
            Route::post('/store', 'Auth\InvitationController@store');
            Route::get('', 'Auth\InvitationController@index');
        });

        Route::group(['prefix'  =>   'users'], function() {

            Route::post('/update', 'Auth\UserController@update');
            Route::post('/password', 'Auth\UserController@password');

        });

        Route::group(['prefix'  =>   'brands'], function() {

            Route::get('', 'Auth\BrandController@index');
            Route::get('/{id}/edit', 'Auth\BrandController@edit');
            Route::post('/store', 'Auth\BrandController@store');
            Route::post('/update', 'Auth\BrandController@update');
            Route::get('/{id}/delete', 'Auth\BrandController@delete');

        });

        Route::group(['prefix'  =>   'categories'], function() {

            Route::get('', 'Auth\CategoryController@index');
            Route::post('/store', 'Auth\CategoryController@store');
            Route::get('/{id}/edit', 'Auth\CategoryController@edit');
            Route::post('/update', 'Auth\CategoryController@update');
            Route::get('/{id}/delete', 'Auth\CategoryController@delete');

        });

        Route::group(['prefix'  =>   'products'], function() {

            Route::get('', 'Auth\ProductController@index');

            Route::get('/create', 'Auth\ProductController@create');
             Route::get('/items', 'Auth\ProductController@items');

            Route::post('/store', 'Auth\ProductController@store');
            Route::get('/{id}/edit', 'Auth\ProductController@edit');
            Route::get('/{id}', 'Auth\ProductController@select');
            Route::post('/update', 'Auth\ProductController@update');
            Route::get('/{id}/delete', 'Auth\ProductController@delete');

            Route::get('/images/{id}', 'Auth\ProductController@image');

            Route::post('/images/upload', 'Auth\ProductImageController@upload');
            Route::get('/images/{id}/delete', 'Auth\ProductImageController@delete');


        });


        Route::group(['prefix'  =>   'productshipping'], function() {

            Route::get('/{id}/{shipping_method}/{postcode}', 'Auth\ShippingController@select');

        });

        Route::group(['prefix'  =>   'orders'], function() {
            Route::group(['prefix'  =>   'sale-expert'], function() {

                Route::get('', 'Auth\OrderController@sale_expert');
                Route::get('/search', 'Auth\OrderController@sale_expert_search');
                Route::get('/search/agent', 'Auth\OrderController@sale_expert_search_agent');

            });

            Route::group(['prefix' => 'personal-shopper'], function(){
                Route::get('', 'Auth\OrderController@personal_shopper');
                Route::get('/search', 'Auth\OrderController@personal_shopper_search');
                Route::get('/search/agent', 'Auth\OrderController@personal_shopper_search_agent');
            });

            Route::group(['prefix' => 'agent'], function(){
                Route::get('', 'Auth\OrderController@agent');
                Route::get('/search', 'Auth\OrderController@agent_search');
            });

            Route::get('', 'Auth\OrderController@index');
            Route::get('/sale-expert', 'Auth\OrderController@sale_expert');
            Route::get('/sale-expert/search', 'Auth\OrderController@sale_expert_search');


            Route::get('/create', 'Auth\OrderController@create');
            Route::post('/store', 'Auth\OrderController@store');
            Route::get('/{id}/edit', 'Auth\OrderController@edit');
            Route::get('/{id}/view', 'Auth\OrderController@view');
            Route::get('/{id}/sale-expert', 'Auth\OrderController@view_sale_expert');
            Route::get('/{id}/products', 'Auth\OrderController@products');
            Route::post('/payment', 'Auth\OrderController@payment');

            Route::get('/{id}/select', 'Auth\OrderController@select');
            Route::post('/update', 'Auth\OrderController@update');
            Route::get('/{id}/delete', 'Auth\OrderController@delete');

        });


        Route::post('/checkout/order', 'Auth\OrderController@placeOrder');

        Route::group(['prefix'  =>   'items'], function() {

            Route::get('', 'Auth\ItemController@index');
            Route::get('/products', 'Auth\ItemController@products');
            Route::post('/store', 'Auth\ItemController@store');

            Route::get('/subcat/{id}', 'Auth\ItemController@subCat');
            Route::get('/{id}/edit', 'Auth\ItemController@edit');

            Route::post('/update', 'Auth\ItemController@update');

            Route::get('/find/{product_id}', 'Auth\ItemController@findItem');

            Route::post('/add', 'Auth\ItemController@add');
            Route::get('/remove/{id}', 'Auth\ItemController@remove');
        });

        Route::group(['prefix'  =>   'branches'], function() {

            Route::get('', 'Auth\BranchController@index');
            Route::get('/{id}', 'Auth\BranchController@getBranch');
        });

        Route::group(['prefix'  =>   'settings'], function() {

            Route::get('/tax', 'Auth\SettingController@tax');
            Route::get('/tier', 'Auth\SettingController@commision_tier');
        });

        Route::group(['prefix'  =>   'deliveries'], function() {

            Route::get('', 'Auth\DeliveryController@index');
            Route::get('/{id}/agent', 'Auth\DeliveryController@agent');
            Route::get('/{branch}/{id}', 'Auth\DeliveryController@edit');
            Route::post('/update', 'Auth\DeliveryController@update');

        });

        Route::group(['prefix'  =>   'sales'], function() {

            Route::get('/index', 'Auth\DashboardController@index');

            Route::get('', 'Auth\DashboardController@sales');
            Route::get('/commission', 'Auth\DashboardController@commission');
            Route::post('/commission/sale', 'Auth\DashboardController@search');
        });


        Route::group(['prefix'  =>   'reports'], function() {

            Route::get('/personal_shopper', 'Auth\ReportController@personal_shopper_report');
            Route::post('/personal_shopper/search', 'Auth\ReportController@personal_shopper_search');
            Route::get('/agent', 'Auth\ReportController@agent_report');
            Route::post('/agent/search', 'Auth\ReportController@agent_report');
            Route::get('/sale_expert', 'Auth\ReportController@sale_expert_report');
            Route::post('/sale_expert/search', 'Auth\ReportController@sale_expert_report_search');
            Route::get('/personal_shopper/details/{date}', 'Auth\ReportController@personal_shopper_report_details');
            Route::get('/personal_shopper/agent/{date}', 'Auth\ReportController@agent_shopper_report_details');
            Route::get('/personal_shopper/sale_expert/{date}', 'Auth\ReportController@sale_expert_report_details');

        });

        Route::group(['prefix'  =>   'withdrawals'], function() {

            Route::get('', 'Auth\WithdrawalController@index');
            Route::post('/store', 'Auth\WithdrawalController@store');

        });

        Route::group(['prefix'  =>   'bank-accounts'], function() {

            Route::get('', 'Auth\BankAccountController@index');
            Route::post('/store', 'Auth\BankAccountController@store');
            Route::get('/{id}', 'Auth\BankAccountController@edit');
            Route::post('/{id}/update', 'Auth\BankAccountController@update');
            Route::delete('delete/{id}', 'Auth\BankAccountController@delete');


        });

        Route::group(['prefix'  =>   'searching'], function() {

            Route::get('/products', 'Auth\SearchController@product');
            Route::get('/products/items', 'Auth\SearchController@item_product');
            Route::get('/orders', 'Auth\SearchController@order');
            Route::get('/items', 'Auth\SearchController@item');
            Route::get('/invitations', 'Auth\SearchController@invite');

        });

        Route::group(['prefix'  =>   'balance'], function() {

            Route::get('', 'Auth\BalanceController@index');
            Route::get('/personal-shopper', 'Auth\BalanceController@personal_shopper');
            Route::get('/agent', 'Auth\BalanceController@agent');

        });

    });
});

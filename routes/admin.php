<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth']], function () {

    Route::group(['prefix'  =>  'admin'], function () {

        // Route::get('login', 'Admin\LoginController@showLoginForm')->name('admin.login');
        // Route::post('login', 'Admin\LoginController@login')->name('admin.login.post');
        // Route::get('logout', 'Admin\LoginController@logout')->name('admin.logout');

        Route::get('/', function () {

            return view('admin.dashboard.index');

        })->name('admin.dashboard');

        Route::get('/settings', 'Admin\SettingController@index')->name('admin.settings');
        Route::post('/settings', 'Admin\SettingController@update')->name('admin.settings.update');


        Route::group(['prefix'  =>   'settings'], function() {

            Route::get('/commissions', 'Admin\CommissionController@index')->name('admin.commissions.index');
            Route::get('/commissions/create', 'Admin\CommissionController@create')->name('admin.commissions.create');


        });


        Route::group(['prefix'  =>   'users'], function() {

            Route::get('/', 'Admin\UserController@index')->name('admin.users.index');
            Route::get('/create', 'Admin\UserController@create')->name('admin.users.create');
            Route::post('/store', 'Admin\UserController@store')->name('admin.users.store');
            Route::get('/{id}/edit', 'Admin\UserController@edit')->name('admin.users.edit');
            Route::post('/update', 'Admin\UserController@update')->name('admin.users.update');
            Route::get('/{id}/delete', 'Admin\UserController@delete')->name('admin.users.delete');
            Route::get('/export', 'Admin\UserController@export');
        });

        Route::group(['prefix'  =>   'branches'], function() {

            Route::get('/', 'Admin\BranchController@index')->name('admin.branches.index');
            Route::get('/create', 'Admin\BranchController@create')->name('admin.branches.create');
            Route::post('/store', 'Admin\BranchController@store')->name('admin.branches.store');
            Route::get('/{id}/edit', 'Admin\BranchController@edit')->name('admin.branches.edit');
            Route::post('/update', 'Admin\BranchController@update')->name('admin.branches.update');
            Route::get('/{id}/delete', 'Admin\BranchController@delete')->name('admin.branches.delete');

        });
        Route::group(['prefix'  =>   'categories'], function() {

            Route::get('/', 'Admin\CategoryController@index')->name('admin.categories.index');
            Route::get('/create', 'Admin\CategoryController@create')->name('admin.categories.create');
            Route::post('/store', 'Admin\CategoryController@store')->name('admin.categories.store');
            Route::get('/{id}/edit', 'Admin\CategoryController@edit')->name('admin.categories.edit');
            Route::post('/update', 'Admin\CategoryController@update')->name('admin.categories.update');
            Route::get('/{id}/delete', 'Admin\CategoryController@delete')->name('admin.categories.delete');

        });

        Route::group(['prefix'  =>   'attributes'], function() {

            Route::get('/', 'Admin\AttributeController@index')->name('admin.attributes.index');
            Route::get('/create', 'Admin\AttributeController@create')->name('admin.attributes.create');
            Route::post('/store', 'Admin\AttributeController@store')->name('admin.attributes.store');
            Route::get('/{id}/edit', 'Admin\AttributeController@edit')->name('admin.attributes.edit');
            Route::post('/update', 'Admin\AttributeController@update')->name('admin.attributes.update');
            Route::get('/{id}/delete', 'Admin\AttributeController@delete')->name('admin.attributes.delete');

            Route::post('/get-values', 'Admin\AttributeValueController@getValues');
            Route::post('/add-values', 'Admin\AttributeValueController@addValues');
            Route::post('/update-values', 'Admin\AttributeValueController@updateValues');
            Route::post('/delete-values', 'Admin\AttributeValueController@deleteValues');

        });

        Route::group(['prefix'  =>   'brands'], function() {

            Route::get('/', 'Admin\BrandController@index')->name('admin.brands.index');
            Route::get('/create', 'Admin\BrandController@create')->name('admin.brands.create');
            Route::post('/store', 'Admin\BrandController@store')->name('admin.brands.store');
            Route::get('/{id}/edit', 'Admin\BrandController@edit')->name('admin.brands.edit');
            Route::post('/update', 'Admin\BrandController@update')->name('admin.brands.update');
            Route::get('/{id}/delete', 'Admin\BrandController@delete')->name('admin.brands.delete');

        });

        Route::group(['prefix' => 'products'], function () {

            Route::get('/', 'Admin\ProductController@index')->name('admin.products.index');
            Route::get('/create', 'Admin\ProductController@create')->name('admin.products.create');
            Route::post('/store', 'Admin\ProductController@store')->name('admin.products.store');
            Route::get('/edit/{id}', 'Admin\ProductController@edit')->name('admin.products.edit');
            Route::post('/update', 'Admin\ProductController@update')->name('admin.products.update');

            Route::post('images/upload', 'Admin\ProductImageController@upload')->name('admin.products.images.upload');
            Route::get('images/{id}/delete', 'Admin\ProductImageController@delete')->name('admin.products.images.delete');

            // Load attributes on the page load
            Route::get('attributes/load', 'Admin\ProductAttributeController@loadAttributes');
            // Load product attributes on the page load
            Route::post('attributes', 'Admin\ProductAttributeController@productAttributes');
            // Load option values for a attribute
            Route::post('attributes/values', 'Admin\ProductAttributeController@loadValues');
            // Add product attribute to the current product
            Route::post('attributes/add', 'Admin\ProductAttributeController@addAttribute');
            // Delete product attribute from the current product
            Route::post('attributes/delete', 'Admin\ProductAttributeController@deleteAttribute');

        });

        Route::group(['prefix'  =>   'items'], function() {

            Route::get('/', 'Admin\ItemController@index')->name('admin.items.index');
            Route::get('/create', 'Admin\ItemController@create')->name('admin.items.create');
            Route::post('/store', 'Admin\ItemController@store')->name('admin.items.store');
            Route::get('/{id}/edit', 'Admin\ItemController@edit')->name('admin.items.edit');
            Route::post('/update', 'Admin\ItemController@update')->name('admin.items.update');
            Route::get('/{id}/delete', 'Admin\ItemController@delete')->name('admin.items.delete');

            // Route::post('subcat', 'CategoryController@subCat');

            Route::post('/subcat', 'Admin\ItemController@subCat')->name('admin.items.subcat');



        });

        Route::group(['prefix' => 'orders'], function () {
            Route::get('/', 'Admin\OrderController@index')->name('admin.orders.index');
            Route::get('/{order}/show', 'Admin\OrderController@show')->name('admin.orders.show');
        });
    });
});

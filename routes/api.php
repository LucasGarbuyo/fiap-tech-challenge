<?php

use Illuminate\Support\Facades\Route;
use TechChallenge\Adapter\Driver\Api\V1\Product;
use TechChallenge\Adapter\Driver\Api\V1\Customer;
use TechChallenge\Adapter\Driver\Api\V1\Category;
use TechChallenge\Adapter\Driver\Api\V1\Order;

Route::controller(Product::class)
    ->prefix('/product')
    ->group(function () {
        Route::get('/index', [Product::class, "index"]);
        Route::get('/show/{id}', [Product::class, "show"]);
        Route::post('/store', [Product::class, "store"]);
        Route::put('/update/{id}', [Product::class, "update"]);
        Route::delete('/delete/{id}', [Product::class, "delete"]);
    });

Route::controller(Customer::class)
    ->prefix('/customer')
    ->group(function () {
        Route::get('', [Customer::class, "index"]);
        Route::get('/{id}', [Customer::class, "show"]);
        Route::post('', [Customer::class, "store"]);
        Route::put('/{id}', [Customer::class, "update"]);
        Route::delete('/{id}', [Customer::class, "delete"]);
        Route::get('/cpf/{cpf}', [Customer::class, "showByCfp"]);
    });


Route::controller(Category::class)
    ->prefix('/category')
    ->group(function () {
        Route::get('/index', [Category::class, "index"]);
        Route::get('/show/{id}', [Category::class, "show"]);
        Route::post('/store', [Category::class, "store"]);
        Route::put('/update/{id}', [Category::class, "update"]);
        Route::delete('/delete/{id}', [Category::class, "delete"]);
    });


Route::controller(Order::class)
    ->prefix('/orders')
    ->group(function () {
        Route::get('/index', [Order::class, "index"]);
        Route::post('/', "store");
    });

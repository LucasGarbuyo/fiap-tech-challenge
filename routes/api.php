<?php

use Illuminate\Support\Facades\Route;
use TechChallenge\Api\Customer\Customer;
use TechChallenge\Api\Product\Product;
use TechChallenge\Api\Category\Category;
use TechChallenge\Api\Order\Order;

Route::controller(Product::class)
    ->prefix('/product')
    ->group(function () {
        Route::get('/', [Product::class, "index"]);
        Route::get('/{id}', [Product::class, "show"]);
        Route::post('/', [Product::class, "store"]);
        Route::put('/{id}', [Product::class, "update"]);
        Route::delete('/{id}', [Product::class, "delete"]);
    });

Route::controller(Customer::class)
    ->prefix('/customer')
    ->group(function () {
        Route::get('/', [Customer::class, "index"]);
        Route::get('/{id}', [Customer::class, "show"]);
        Route::post('', [Customer::class, "store"]);
        Route::put('/{id}', [Customer::class, "update"]);
        Route::delete('/{id}', [Customer::class, "delete"]);
        Route::get('/cpf/{cpf}', [Customer::class, "showByCfp"]);
    });

Route::controller(Category::class)
    ->prefix('/category')
    ->group(function () {
        Route::get('/', [Category::class, "index"]);
        Route::get('/{id}', [Category::class, "show"]);
        Route::post('/', [Category::class, "store"]);
        Route::put('/{id}', [Category::class, "update"]);
        Route::delete('/{id}', [Category::class, "delete"]);
    });

Route::controller(Order::class)
    ->prefix('/order')
    ->group(function () {
        Route::get('/', [Order::class, "index"]);
        Route::get('/{id}', [Order::class, "show"]);
        Route::post('/', [Order::class, "store"]);
        Route::put('/{id}', [Order::class, "update"]);
        Route::delete('/{id}', [Order::class, "delete"]);
        Route::post('/checkout/{id}', [Order::class, "checkout"]);
        Route::post('/status/{id}', [Order::class, "changeStatus"]);
        Route::post('/webhook', [Order::class, "webhook"]);
    });

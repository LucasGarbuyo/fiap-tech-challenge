<?php

use Illuminate\Support\Facades\Route;
use TechChallenge\Adapter\Driver\Api\V1\Product;
use TechChallenge\Adapter\Driver\Api\V1\Customer;
use TechChallenge\Adapter\Driver\Api\V1\Category;

Route::controller(Product::class)
    ->prefix('/product')
    ->group(function () {
        Route::get('/index', [Product::class, "index"]);
        Route::get('/edit/{id}', [Product::class, "edit"]);
        Route::post('/store', [Product::class, "store"]);
        Route::put('/update/{id}', [Product::class, "update"]);
        Route::delete('/delete/{id}', [Product::class, "delete"]);
    });

Route::controller(Customer::class)
    ->prefix('/customer')
    ->group(function () {
        Route::get('/index', [Customer::class, "index"]);
        Route::get('/edit/{id}', [Customer::class, "edit"]);
        Route::post('/store', [Customer::class, "store"]);
        Route::put('/update/{id}', [Customer::class, "update"]);
        Route::delete('/delete/{id}', [Customer::class, "delete"]);
        Route::get('/edit/cpf/{cpf}', [Customer::class, "editByCfp"]);
    });


Route::controller(Category::class)
    ->prefix('/category')
    ->group(function () {
        Route::get('/index', [Category::class, "index"]);
        Route::get('/edit/{id}', [Category::class, "edit"]);
        Route::post('/store', [Category::class, "store"]);
        Route::put('/update/{id}', [Category::class, "update"]);
        Route::delete('/delete/{id}', [Category::class, "delete"]);
});

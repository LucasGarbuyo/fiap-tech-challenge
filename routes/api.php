<?php

use Illuminate\Support\Facades\Route;
use TechChallenge\Adapter\Driver\Controller\Product;
use TechChallenge\Adapter\Driver\Controller\Customer;

/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');*/

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
    });

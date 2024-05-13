<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use TechChallenge\Adapter\Driver\Controller\Product;

/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');*/

    Route::controller(Product::class)->group(function () {
        Route::post('/product/store', [Product::class, "store"]);
        Route::put('/product/edit/{productId}', [Product::class, "edit"]);
    });


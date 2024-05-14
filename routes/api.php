<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use TechChallenge\Adapter\Driver\Controller\Product;

/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');*/

Route::controller(Product::class)->group(function () {
    Route::get('/product/index', [Product::class, "index"]);
    Route::get('/product/edit/{id}', [Product::class, "edit"]);
    Route::post('/product/store', [Product::class, "store"]);
    Route::put('/product/update/{id}', [Product::class, "update"]);
    Route::delete('/product/delete/{id}', [Product::class, "delete"]);
});

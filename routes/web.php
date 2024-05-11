<?php

use Illuminate\Support\Facades\Route;
use TechChallenge\Adapter\Driver\Controller\Product;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', [Product::class, "store"]);

<?php

use Illuminate\Support\Facades\Route;
use Tech\Test;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', [Test::class, "test"]);

<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Env;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return response()->json([
        'env_function' => env('APP_NAME', 'default'),
        'haha_function' => haha() ?? 'Function not found'
    ]);
});

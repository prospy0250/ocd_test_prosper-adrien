<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('people', PersonController::class)->only([
    'index', 'show', 'create', 'store'
]);



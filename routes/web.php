<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoreController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [StoreController::class, 'index']);
Route::get('/parts/{storeId}', [StoreController::class, 'getPartsByStore']);

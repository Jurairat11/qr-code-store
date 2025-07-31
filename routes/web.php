<?php

use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Route;

Route::get('/', [StoreController::class, 'index']);
Route::get('/parts/{storeId}', [StoreController::class, 'getPartsByStore']);

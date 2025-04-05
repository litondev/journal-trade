<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TradeController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/trade',[TradeController::class,"index"]);
Route::post('/trade',[TradeController::class,"store"]);
Route::put("/trade/{trade}",[TradeController::class,"update"]);
Route::get("/trade/{trade}",[TradeController::class,"show"]);

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('paytabs/completed', function(Request $request){
    Log::info(json_encode(request()->all()));
})->name('paytabs.api.return');

Route::post('paytabs/callback', function(Request $request){
    Log::alert(json_encode(request()->all()));
})->name('paytabs.api.callback');
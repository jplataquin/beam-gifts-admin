<?php

use Illuminate\Http\Request;
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

Route::middleware(['auth:sanctum'])->group(function(){

    Route::get('/partners',[App\Http\Controllers\PartnerController::class, '_list']);
    Route::post('/partner/{id}',[App\Http\Controllers\PartnerController::class,'_update']);
});


Route::get('items',[App\Http\Controllers\ItemController::class, '_list']);
Route::get('brands',[App\Http\Controllers\BrandController::class, '_list']);
Route::get('categories',[App\Http\Controllers\ItemController::class, 'categoryList']);
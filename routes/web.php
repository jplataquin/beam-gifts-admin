<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::middleware(['auth'])->group(function () {

    Route::get('/item/create', [App\Http\Controllers\ItemController::class, 'create']);
    Route::post('/item/create', [App\Http\Controllers\ItemController::class, '_create']);
    Route::get('/item/display/{id}', [App\Http\Controllers\ItemController::class, 'display']);
    Route::post('/item/display/{id}', [App\Http\Controllers\ItemController::class, '_edit']);
    Route::get('/items', [App\Http\Controllers\ItemController::class, 'list']);

    Route::get('/brand/create', [App\Http\Controllers\BrandController::class, 'create']);
    Route::post('/brand/create', [App\Http\Controllers\BrandController::class, '_create']);
    Route::get('/brand/display/{id}', [App\Http\Controllers\BrandController::class, 'display']);
    Route::post('/brand/display/{id}', [App\Http\Controllers\BrandController::class, '_edit']);
    Route::get('/brands', [App\Http\Controllers\BrandController::class, 'list']);

    Route::get('/partner/create',[App\Http\Controllers\PartnerController::class,'create']);
    Route::post('/partner/create',[App\Http\Controllers\PartnerController::class,'_create']);
});




Route::get('adarna.js', function(){

    $response = Response::make(File::get(base_path('node_modules/adarna/dist/adarna.js')), 200);
    $response->header("Content-Type", 'text/javascript');

    return $response;
});
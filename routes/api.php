<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post("login", [UserController::class,'login'])->name('login');


Route::group(['prefix' => 'user', 'controller' => UserController::class,'middleware' => 'auth:sanctum'], function() {

    Route::post("add","create");
    Route::get("index","index");
    Route::post("menu/add","store");
    Route::post("delete/{user_id}","delete");
    Route::post("active/{user_id}","active");


});

Route::group(['prefix' => 'menu', 'controller' => MenuItemController::class,/*'middleware' => 'auth:sanctum'*/], function() {

    Route::post("add","store");
    Route::get("index","index");
    Route::post("update/{menu_item_id}","update");
    Route::get("delete/{menu_item_id}","destroy");




});

Route::group(['prefix' => 'order', 'controller' => OrderController::class,/*'middleware' => 'auth:sanctum'*/], function() {

    Route::post("add","store");
    Route::get("index","index");


});

Route::group(['prefix' => 'customer', 'controller' => CustomerController::class,/*'middleware' => 'auth:sanctum'*/], function() {

    Route::post("add","store");
    Route::get("index","index");


});


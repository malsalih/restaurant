<?php

use App\Http\Controllers\BillController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\NotificationController;
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

Route::group(['prefix' => 'notifications', 'controller' => NotificationController::class,'middleware' => 'auth:sanctum'], function() {

Route::get('unread','index');
Route::post('mark/{notification_id}','mark_Notification');
});

Route::group(['prefix' => 'user', 'controller' => UserController::class,'middleware' => 'auth:sanctum'], function() {

    Route::post("add","create");
    Route::get("index","index");
    Route::post("menu/add","store");
    Route::post("delete/{user_id}","delete");
    Route::post("update/{user_id}","update");

    Route::post("active/{user_id}","active");


});

Route::group(['prefix' => 'menu', 'controller' => MenuItemController::class], function() {

    Route::post("add","store");
    Route::get("index","index");
    Route::post("update/{menu_item_id}","update");
    Route::get("delete/{menu_item_id}","destroy")->middleware("auth:sanctum");
    Route::middleware('auth:sanctum')->get("all_items","show_all");





});

Route::group(['prefix' => 'order', 'controller' => OrderController::class], function() {

    Route::post("add/","store");
    Route::post("prepaired/{order_id}","order_prepaired")->middleware("auth:sanctum");
    Route::post("done/{order_id}","order_done")->middleware("auth:sanctum");


    Route::post("cancel/{bill_id}","cancel_order");
    Route::post("delivery/{bill_id}","in_delivery")->middleware("auth:sanctum");


    Route::get("index","index",);
    Route::get("user_index","index_by_user",)->middleware("auth:sanctum");

    Route::get("report","report");



});

Route::group(['controller' => NotificationController::class,'middleware' => 'auth:sanctum'], function() {
Route::get('notification','index');
});

Route::group(['prefix' => 'customer', 'controller' => CustomerController::class,/*'middleware' => 'auth:sanctum'*/], function() {

    Route::post("add","store");
    Route::post("update/{customer_id}","update");

    Route::get("index","index");


});

Route::group(['prefix' => 'bill', 'controller' => BillController::class,/*'middleware' => 'auth:sanctum'*/], function() {

    Route::post("sd","store");
    Route::get("search","search");


});



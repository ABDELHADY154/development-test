<?php

use App\Http\Controllers\OrderController;
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

Route::get('/orders/{orderid}', [OrderController::class, 'getOrder'])->name('get.order');
Route::get('/orders', [OrderController::class, 'getUsersOrder'])->name('get.user.orders');
Route::post('/orders', [OrderController::class, 'createOrder'])->name('post.user.order');
Route::put('/orders/{orderid}', [OrderController::class, 'updateOrder'])->name('put.order');

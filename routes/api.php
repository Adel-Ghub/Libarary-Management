<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\AuthController;
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
Route::get('/books', [BookController::class,'index']);
Route::post('/books', [BookController::class,'store']);
Route::get('/users', [UserController::class,'index']);
Route::get('/reservations',[ReservationController::class,'index']);
Route::post('/reservations',[ReservationController::class,'store']);
Route::post('/users', [UserController::class, 'store']);
Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
Route::post('/logout',[AuthController::class,'logout']);
Route::get('/books/search/{title}', [BookController::class, 'search']);

Route::delete('/books/{id}', [BookController::class,'destroy']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

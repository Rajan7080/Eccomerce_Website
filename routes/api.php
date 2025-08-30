<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\ApiController\UserController;
use App\Http\Controllers\Frontend\FrontendAuthController;
use App\Http\Controllers\ApiController\CategoryController;
use App\Http\Controllers\ApiController\ProductsController;

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



//categories
Route::apiResource('category', CategoryController::class);


////Products
Route::apiResource('product', ProductsController::class);

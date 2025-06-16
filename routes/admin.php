<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\DashboardController;

Route::get('/category', [DashboardController::class, 'category'])->name('admincategory');
Route::get('/product', [DashboardController::class, 'product'])->name('adminproduct');

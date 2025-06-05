<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminAuthController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\ApiController\ProfileController;
use App\Http\Controllers\Frontend\FrontendAuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


////AdminAuth
Route::get('/register', [DashboardController::class, 'register'])->name('registerpage');
Route::get('/login', function () {
    return view('admin.pages.authPage.signin');
})->name('loginpage');

// Auth actions
Route::post('/adminregister', [AdminAuthController::class, 'register'])->name('submit.register');
Route::post('/adminlogin', [AdminAuthController::class, 'logInPost'])->name('login.submit');
Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

// Protected dashboard route
Route::middleware('auth', 'admin')->group(function () {
    Route::get('admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});








//frontend pages

Route::get('/userregister', [FrontendController::class, 'register'])->name('user.register');
Route::get('/userlogin', [FrontendController::class, 'login'])->name('user.login');

Route::post('registerPost', [FrontendAuthController::class, 'register'])->name('user.registerpost');
Route::post('loginPost', [FrontendAuthController::class, 'login'])->name('user.loginpost');

Route::middleware('auth')->group(function () {

    Route::get('/', [FrontendController::class, 'home'])->name('api.website');
});


//admin dashbaord pages

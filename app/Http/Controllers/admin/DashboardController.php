<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Categories;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.pages.Dashboard');
    }


    public function Products()
    {
        return view('admin.pages.Products');
    }
    public function logIn()
    {
        return view('admin.pages.authPage.signin');
    }
    public function register()
    {
        return view('admin.pages.authPage.register');
    }



    public function category()
    {
        return view('admin.pages.Categories ');
    }
    public function product()
    {
        return view('admin.pages.Products');
    }
}

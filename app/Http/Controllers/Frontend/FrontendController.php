<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use App\Models\Products;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class FrontendController extends Controller
{

    public function home()
    {
        return view('welcome');
    }
}

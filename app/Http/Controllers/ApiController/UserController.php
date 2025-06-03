<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 400);
        }

        $data = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password // Hashing the password
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User created successfully',
            'data' => $data
        ], 201);
    }
}

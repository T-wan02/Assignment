<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            $accessToken = $user->createToken('API Token')->accessToken;

            return response()->json([
                'status' => 'success',
                'message' => 'Logged in successfully',
                'token' => $accessToken,
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials',
            ], 401);
        }
    }

    public function register(Request $request)
    {
        // Validate the data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
                'message' => 'Please fill below fields'
            ]);
        }

        // Validate same password
        if ($request->password !== $request->confirm_password) {
            return response()->json([
                'status' => 'error',
                'message' => 'Please fill same password'
            ]);
        }

        $user = User::where('email', $request->email)->first();
        if ($user) {
            return response()->json([
                'status' => 'error',
                'message' => 'You already have an account with this email'
            ], 401);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password
        ]);

        $token = $user->createToken('API Token')->accessToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Registered successfully',
            'token' => $token
        ], 201);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Logged out successfully'
        ]);
    }
}

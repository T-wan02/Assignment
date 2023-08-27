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
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
                'message' => 'Please fill below fields'
            ]);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            $accessToken = $user->createToken('Auth Token')->accessToken;

            return response()->json([
                'status' => 'success',
                'message' => 'Logged in successfully',
                'token' => $accessToken,
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => "Email and password don't match",
            ], 401);
        }
    }

    public function register(Request $request)
    {
        // Validate the data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password|min:6'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
                'message' => 'Please fill below fields'
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
            'password' => bcrypt($request->password)
        ]);

        $token = $user->createToken('Auth Token')->accessToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Registered successfully',
            'data' => $user,
            'token' => $token
        ], 201);
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        $user->tokens->each(function ($token, $key) {
            $token->delete();
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Logged out successfully'
        ]);
    }
}

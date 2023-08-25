<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Return Login blade
    public function showLogin()
    {
        return view('auth.login');
    }
    // Return Register blade
    public function showRegister()
    {
        return view('auth.register');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        return view('hr.index');
    }
}

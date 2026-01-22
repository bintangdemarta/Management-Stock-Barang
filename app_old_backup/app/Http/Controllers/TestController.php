<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        return '<h1>Test Controller Working</h1><p>The routing system is properly configured and working.</p><p><a href="/">Return Home</a></p>';
    }
}
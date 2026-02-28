<?php

namespace App\Http\Controllers\WEB\Admin; // Change if it's in the User folder

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MenuVisibilityController extends Controller
{
    public function index()
    {
        return view('admin.menu-visibility'); // Adjust this based on your actual view file
    }
}

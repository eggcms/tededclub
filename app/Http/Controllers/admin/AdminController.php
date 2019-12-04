<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index()
    {
        if(auth()->user()->isAdmin()) return view('admin/index');
        else return view('home/index');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function __construct()
    {
        $this->middleware('Admin');
    }

    public function index()
    {
        return view('admin.index');
    }
}

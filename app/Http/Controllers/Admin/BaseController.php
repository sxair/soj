<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    public function isStudent() {
        return Auth::user()->control & config('soj.admin.student');
    }
}

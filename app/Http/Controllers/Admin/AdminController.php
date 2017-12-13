<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function help($title) {
        $content = DB::table('soj_helps')->where('name', 'admin.'.$title)->first();
        return view('admin.help', ['content' => $content]);
    }
}

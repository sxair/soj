<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function help($title) {
        if(view()->exists('help.'.$title)) {
            return view('help.'.$title);
        }
        return '';
    }
}

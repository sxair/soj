<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContestController extends Controller
{
    public function contests()
    {
        $contests = DB::table('contests')->paginate('15');
        return view('contests', ['contests' => $contests]);
    }
}

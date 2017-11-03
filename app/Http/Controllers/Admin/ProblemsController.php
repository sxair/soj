<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ProblemsController extends Controller
{
    public function problems(Request $request)
    {
        $page =  $request->input('page');
        if(is_null($page)) $page = 1;
        $perPage = 50;
        $total = DB::table('admin_problems')->count();
        $problems = DB::table('admin_problems')
            ->offset(($page - 1) * $perPage)->limit($perPage)->get();
        return response()->json(array_merge(['problems' => $problems], ['total' => $total]));
    }

    public function addProblem(Request $request) {

        return response()->json($request->all());
    }
}

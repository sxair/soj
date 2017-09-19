<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function userinfo($name)
    {
        $user = DB::table('users')->select('id')->where('name',$name)->first();
        if(is_null($user)) {
            return;
        }
        $userinfo = DB::table('user_infos')->where('id', $user->id)->first();
        $user = (object)array_merge((array)$userinfo, (array)$user);
        $user->name = $name;
        $solveds = DB::table('oj_solved_problems')
            ->select(['problem_id', 'submitted', 'accepted'])
            ->where('user_id', $user->id)->get();
        return view('userinfo', ['user' => $user, 'solveds' => $solveds]);
    }
}

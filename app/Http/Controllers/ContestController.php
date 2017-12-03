<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('contests');
    }

    public function contests(Request $request)
    {
        $sql = DB::table('contests')->orderBy('id', 'DESC');
        $page = getCurrentPage($request->input('page'));
        $content = $request->input('content');
        $type = $request->input('type');
        $time = $request->input('time');
        if(!is_null($content)) {
            if ($type == 0) {
                $sql = $sql->where('title', 'like', '%' . $content . '%');
            } else $sql = $sql->where('user_name', 'like','%' . $content . '%');
        }
        if(!is_null($time) && $time != 0) {
            if($time == 1) {
                $sql = $sql->where('start_time', '<=', now())
                ->where('end_time', '>', now());
            } else if($time == 2) {
                $sql = $sql->where('end_time', '<', now());
            } else {
                $sql = $sql->where('start_time', '>', now());
            }
        }
        $contest = getPaginate($sql, [], $page, 50);
        foreach ($contest['content'] as $c) {
            $c->password = ($c->password == "");
        }
        return $contest;
    }

    public function contest($id)
    {
        return view('contest.contest');
    }
}

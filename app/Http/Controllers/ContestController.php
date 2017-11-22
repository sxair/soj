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

    public function contests() {
        $sql = DB::table('contests')->orderBy('id', 'DESC');
        $content = getPage($sql, '', 1, 50);
        foreach ($content['content'] as $c) {
           $c->password = ($c->password == "");
        }
        return $content;
    }

    public function contest($id) {
        return view('contest.contest');
    }
}

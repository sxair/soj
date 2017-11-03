<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class ProblemsController extends Controller
{
    public function problems(Request $request)
    {
        $type = $request->input('type');
        $search = $request->input('search');
        $page =  $request->input('page');
        if(is_null($page)) $page = 1;
        $perPage = 10;
        if(!is_null($search)) {
            if($type == 'author' || $type == 'source') {
                $sql = DB::table('oj_problems')
                    ->join('problems', 'problems.id', '=', 'oj_problems.problem_id')
                    ->where('problems.'.$type, 'like', '%'.$search.'%');
                $total = $sql->count();
                $problems = $sql->select(['oj_problems.id', 'oj_problems.title', 'oj_problems.accepted', 'oj_problems.submitted',
                        'problems.author', 'problems.source'])
                    ->offset(($page - 1) * $perPage)->limit($perPage)->get();
            } else {
                $sql = DB::table('oj_problems')
                    ->where('title', 'like', '%'.$search.'%');
                $total = $sql->count();
                $problems = $sql->select(['id', 'title', 'accepted', 'submitted'])
                    ->offset(($page - 1) * $perPage)->limit($perPage)->get();
            }
        } else {
            $total = DB::table('oj_problems')->count();
            $problems = DB::table('oj_problems')
                ->select(['id', 'title', 'accepted', 'submitted'])
                ->offset(($page - 1) * $perPage)->limit($perPage)->get();
        }
        return response()->json(array_merge(['problems' => $problems], ['total' => $total]));
    }

    public function problem($id = 1000)
    {
        $problem = $this->ToProblems($id);
        if(is_null($problem)) {
            return view('errors.noFind');
        }
        return view('problem', ['pro' => $problem]);
    }

    public function proinfo($id)
    {
        $pro = DB::table('oj_problem_infos')
            ->where('oj_problem_infos.id', $id)
            ->join('oj_problems','oj_problems.id', '=', 'oj_problem_infos.id')
            ->get();
        if($pro->isEmpty()){
            return ;
        }
        dump($pro);
        return view('proinfo', ['pro' => $pro[0]]);
    }

    public function rank()
    {
        $ranks = DB::table('user_infos')->orderBy('accepted', 'dasc')
            ->orderBy('submitted', 'asc')->paginate(15);
        return view('rank', ['ranks' => $ranks]);
    }

    public function status(Request $request)
    {
        $page =  $request->input('page');
        if(is_null($page)) $page = 1;
        $perPage = 30;
        $search = $request->input();
        $status = $request->input('status');
        if(array_key_exists('page', $search))
            $search['page']=null;
        if(array_key_exists('status', $search))
            $search['status']=null;
        $search = array_filter($search);
        $sql = DB::table('oj_status')->where($search)->orderBy('id', 'dasc');
        if (is_null($status) || $status == 0) {
            $total = $sql->count();
            $status = $sql->offset(($page - 1) * $perPage)->limit($perPage)->get();
        } else if($status > 4) {
            $total = $sql->where('status', '>', $status * 10000)
                ->where('status', '<', ($status + 1) * 10000)
                ->count();
            $status = $sql->where('status', '>', $status * 10000)
                ->where('status', '<', ($status + 1) * 10000)
                ->offset(($page - 1) * $perPage)->limit($perPage)->get();
        } else {
            $status = $sql->where('status', $status)
                ->offset(($page - 1) * $perPage)->limit($perPage)->get();
        }
        return response()->json(array_merge(['status' => $status], ['total' => $total]));
    }

    public function submitPage($id, $time, $memory)
    {
        if(!Auth::check()) {
            return redirect('login?to='.urlencode(url()->current()));
        }
        return view('submit', ['id' => $id, 'time' => $time, 'memory' => $memory]);
    }

    /*
     * add for judge: oj_status,judges,oj_codes
     * add for problem:oj_problems
     * add for user: user_infos,solved_problmes
     */
    public function submit(Request $request)
    {
        $user = Auth::user();
        if (is_null($user)) {
            return redirect()->back()->withErrors('Login','请登录后再提交');
        }
        $code = $request->input('code');
        $this->validate($request, [
            'code' => 'min:50|max:65535',
            'problem_id' => 'numeric|exists:oj_problems,id'
        ]);
        DB::statement('CALL `oj_submit`('.$request->input('problem_id').$request->input('lang').$code
            .$request->input('user_name').$request->input('user_id').strlen($code).')');
        return redirect('status');
    }

    public function showcode($id)
    {
        if(Auth::guest()) {
            return redirect()->back();
        }
        $status = DB::table('oj_status')->where(['id' => $id, 'user_id' => Auth::id()])->get();
        if ($status->isEmpty()) {
            return redirect()->back();
        }
        $code = DB::table('oj_codes')->where(['status_id' => $id])->get();
        return view('showcode', ['code' => $code[0], 'status' => $status[0]]);
    }
}

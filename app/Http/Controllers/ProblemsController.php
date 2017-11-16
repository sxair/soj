<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class ProblemsController extends Controller
{
    public function getPageJson($sql, $select, $pageName, $page, $perPage)
    {
        $total = $sql->count();
        if (!empty($select)) {
            $sql = $sql->select($select);
        }
        $problems = $sql->offset(($page - 1) * $perPage)->limit($perPage)->get();
        return array_merge([$pageName => $problems], ['total' => $total]);
    }

    public function problems(Request $request)
    {
        $type = $request->input('type');
        $search = $request->input('search');
        $page = (int)$request->input('page');
        if (is_null($page) || $page <= 0) $page = 1;
        $perPage = 50;
        if (!is_null($search)) {
            if ($type == 'author' || $type == 'source') {
                $sql = DB::table('oj_problems')
                    ->join('problems', 'problems.id', '=', 'oj_problems.problem_id')
                    ->where('problems.' . $type, 'like', '%' . $search . '%');
            } else {
                $sql = DB::table('oj_problems')
                    ->where('title', 'like', '%' . $search . '%');
            }
        } else {
            $sql = DB::table('oj_problems');
        }
        return response()->json($this->getPageJson($sql, ['id', 'title', 'accepted', 'submitted'],
            'problems', $page, $perPage));
    }

    public function status(Request $request)
    {
        $search['author'] = $request->input('author');
        $search['problem_id'] = $request->input('proId');
        $search['lang'] = $request->input('lang');
        $search = array_filter($search);
        $page = $request->input('page');
        $perPage = 15;
        $status = (integer)$request->input('status');
        $sql = DB::table('oj_status')->where($search)->orderBy('id', 'dasc');
        if ($status > 0 && $status <= 11 && $status != 2 && $status != 4 && $status != 5) {
            if ($status < 4) {
                $sql = $sql->where('status', $status);
            } else {
                $sql = $sql->where('status', '>', $status * 10000)
                    ->where('status', '<', ($status + 1) * 10000);
            }
        }
        return response()->json($this->getPageJson($sql, [], 'status', $page, $perPage));
    }

    public function problem($id = 1000)
    {
        $ojpro = DB::table('oj_problems')->where('id', $id)->first();
        if (is_null($ojpro)) return view('errors.noFind');
        $pro = DB::table('problems')->where('id', $ojpro->problem_id)->first();
        $problem = (object)array_merge((array)$pro, (array)$ojpro);
        return view('problem', ['pro' => $problem]);
    }

    public function label()
    {
        $lable = DB::table('soj')->select('content')
            ->where('name', 'label')->first();
        return response()->json($lable);
    }

    public function proinfo($id)
    {
        $pro = DB::table('oj_problem_infos')
            ->where('oj_problem_infos.id', $id)
            ->join('oj_problems', 'oj_problems.id', '=', 'oj_problem_infos.id')
            ->get();
        if ($pro->isEmpty()) {
            return;
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

    public function submitPage($id)
    {
        if (!Auth::check()) {
            return redirect('login?to=' . urlencode(url()->current()));
        }
        return view('submit', ['id' => $id]);
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
            return redirect()->back()->withErrors('Login', '请登录后再提交');
        }
        $code = $request->input('code');
        $this->validate($request, [
            'code' => 'min:50|max:65535',
            'problem_id' => 'numeric|exists:oj_problems,id'
        ]);
        DB::statement('CALL `oj_submit`(' . $request->input('problem_id') . $request->input('lang') . $code
            . $request->input('user_name') . $request->input('user_id') . strlen($code) . ')');
        return redirect('status');
    }

    public function showcode($id)
    {
        if (Auth::guest()) {
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

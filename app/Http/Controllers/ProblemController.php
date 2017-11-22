<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class ProblemController extends Controller
{
    /**
     * for problem list api
     * @return \Illuminate\Http\JsonResponse
     */
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
                return response()->json(getPage($sql, ['oj_problems.id', 'oj_problems.title',
                    'oj_problems.accepted', 'oj_problems.submitted',
                    'problems.author', 'problems.source'], $page, $perPage));
            } else {
                $sql = DB::table('oj_problems')
                    ->where('title', 'like', '%' . $search . '%');
            }
        } else {
            $sql = DB::table('oj_problems');
        }
        return response()->json(getPage($sql, ['id', 'title', 'accepted', 'submitted'], $page, $perPage));
    }

    /**
     * for status api
     * @return \Illuminate\Http\JsonResponse
     */
    public function status(Request $request)
    {
        $search['user_name'] = $request->input('author');
        $search['problem_id'] = $request->input('proId');
        $search['lang'] = $request->input('lang');
        $search = array_filter($search);
        $page = $request->input('page');
        $perPage = 15;
        $status = (integer)$request->input('status');
        $sql = DB::table('oj_status')->where($search)->orderBy('id', 'desc');
        if ($status > 0 && $status <= 11 && $status != 1 && $status != 4 && $status != 5) {
            if ($status < 4) {
                $sql = $sql->where('status', $status);
            } else {
                $sql = $sql->where('status', '>', $status * 10000)
                    ->where('status', '<', ($status + 1) * 10000);
            }
        }
        return response()->json(getPage($sql, [], $page, $perPage));
    }

    public function problem($id = 1000)
    {
        $ojpro = DB::table('oj_problems')->where('id', $id)->first();
        if (is_null($ojpro)) return view('errors.noFind');
        $pro = DB::table('problems')->where('id', $ojpro->problem_id)->first();
        return view('problem', ['pro' => array_merge((array)$pro, (array)$ojpro)]);
    }

    /**
     * for label api
     * @return \Illuminate\Http\JsonResponse
     */
    public function label()
    {
        return response()->json(DB::table('soj')->select('content')
            ->where('name', 'label')->first());
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

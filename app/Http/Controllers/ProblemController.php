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
        $label = (int) $request->input('label');
        $page = getCurrentPage($request->input('page'));
        $perPage = 50;
        $sql = DB::table('oj_problems');
        if($label != 0) {
            if($label % 1000 == 0) {
                $sql = DB::table('oj_label_problems')
                    ->where('oj_label_problems.id', '>=', $label)
                    ->where('oj_label_problems.id', '<', $label+1000);
            } else {
                $sql = DB::table('oj_label_problems')
                    ->where('oj_label_problems.id', '=', $label);
            }
            $sql = $sql->join('oj_problems', 'oj_label_problems.problem_id','=', 'oj_problems.id');
        }
        if (!is_null($search)) {
            if ($type == 'author' || $type == 'source') {
                $sql = $sql->join('problems', 'problems.id', '=', 'oj_problems.problem_id')
                    ->where('problems.' . $type, 'like', '%' . $search . '%');
                return response()->json(getPaginate($sql, ['oj_problems.id', 'oj_problems.title',
                    'oj_problems.accepted', 'oj_problems.submitted',
                    'problems.author', 'problems.source'], $page, $perPage));
            } else {
                $sql = $sql->where('title', 'like', '%' . $search . '%');
            }
        }
        return response()->json(getPaginate($sql, '', $page, $perPage));
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
        $page = getCurrentPage($request->input('page'));
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
        return response()->json(getPaginate($sql, [], $page, $perPage));
    }

    public function statusRange($l, $r)
    {
        $l = (int)$l;
        $r = (int)$r;
        if($r < $l || $r - $l > 15) {
            return '[]';
        }
        $status = DB::table('oj_status')
            ->where('id', '>=', $l)
            ->where('id', '<=', $r)
            ->select(['id', 'status'])
            ->orderBy('id', 'desc')
            ->get();
        return response()->json($status);
    }

    public function problem($id)
    {
        $ojpro = DB::table('oj_problems')->where('id', $id)->first();
        if (is_null($ojpro)) return '{}';
        $pro = DB::table('problems')->where('id', $ojpro->problem_id)->first();
        return response()->json(array_merge((array)$pro, (array)$ojpro));
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

    public function rank(Request $request)
    {
        $page = getCurrentPage($request->input('page'));
        $ranks = DB::table('user_infos')->orderBy('accepted', 'dasc')
            ->join('users', 'users.id', '=', 'user_infos.id')
            ->orderBy('submitted', 'asc');
        return response()->json(getPaginate($ranks, ['users.id', 'users.name', 'user_infos.accepted', 'user_infos.submitted'
            , 'user_infos.motto'], $page, 15));
    }

    public function submitPage($id)
    {
        if (!Auth::check()) {
            return redirect('login?to=' . urlencode(url()->current()));
        }
        return view('problems');
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

    /*
     * add for judge: oj_status,judges,oj_codes
     * add for problem:oj_problems
     * add for user: user_infos,solved_problmes
     */
    public function submit(Request $request)
    {
        $user = Auth::user();
        if (is_null($user)) {
            return response()->json(['failed' => '请登录']);
        }
        $lang = (int)$request->input('lang');
        if($lang <= 0 || $lang > 4) return response()->json(['failed' => '请选择正确语言']);
        $this->validate($request, [
            'code' => 'min:50|max:65535',
            'problem_id' => 'numeric|exists:oj_problems,id'
        ]);
        DB::statement('CALL `oj_submit`(?,?,?,?,?,?)', [
            $request->input('problem_id'),
            $request->input('lang'),
            $request->input('code'), $user->name, $user->id,
            strlen($request->input('code'))]);
        return response()->json(['success' => true]);
    }

    public function getCode($id)
    {
        $status = DB::table('oj_status')->where(['id' => $id])->get();
        if ($status->isEmpty() || Auth::guest() || $status[0]->user_name != Auth::user()->name) {
            return response()->json(['code' => '']);
        }
        $code = DB::table('oj_codes')->where(['status_id' => $id])->get();
        if($code->isEmpty()) return response()->json(['code' => '']);
        return response()->json(['code' => $code[0]->code, 'status' => $status[0]]);
    }
}

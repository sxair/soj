<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ProblemsController extends Controller
{
    public function problems(Request $request)
    {
        $page = $request->input('page');
        if (is_null($page)) $page = 1;
        $perPage = 50;
        $total = DB::table('admin_problems')
            ->where('user_name',Auth::user()->name)
            ->orWhere('public', 1)
            ->count();
        $problems = DB::table('admin_problems')
            ->where('user_name',Auth::user()->name)
            ->orWhere('public', 1)
            ->offset(($page - 1) * $perPage)->limit($perPage)->get();
        return response()->json(array_merge(['problems' => $problems], ['total' => $total]));
    }

    public function addProblem(Request $request)
    {
        $user = Auth::user();
        if (!($user->control & config('soj.admin.addProblem'))) {
            return response()->json(['result' => -1]);
        }
        $this->validate($request, [
            'title' => 'required|max:30',
            'time' => 'required|numeric|max:99999',
            'memory' => 'required|numeric|max:524288',
            'spj' => 'required|numeric|min:0|max:3',
            'content' => 'required|max:65535',
            'author' => 'max:50',
            'source' => 'max:50',
        ]);
        $spj = $request->input('spj');
        if ($spj > 2) {
            if (is_null($request->input('judge'))) {
                return response()->json(['result' => 0]);
            }
            $spj = DB::table('spj')->insertGetId([
                'code' => $request->input('judge')
            ]);
        }
        $id = DB::table('problems')->insertGetId([
            'title' => $request->input('title'),
            'time_limit' => $request->input('time'),
            'memory_limit' => $request->input('memory'),
            'judge_cnt' => 0,
            'spj' => $spj,
            'content' => $request->input('content'),
            'author' => $request->input('author'),
            'source' => $request->input('source'),
        ]);

        DB::table('admin_problems')->insert([
            'problem_id' => $id,
            'title' => $request->input('title'),
            'user_name' => $user->name,
            'public' => 1,
            'show' => 0,
        ]);
        DB::table('oj_problems')->insert([
            'problem_id' => $id,
            'title' => $request->input('title'),
        ]);
        return response()->json(['result' => $id]);
    }

    public function addProblemToOj(Request $request)
    {
        $proId = $request->input('proid');
        $pro = DB::table('problems')->where('id',$proId)->first();
        if(is_null($pro)) {
            return;
        }
        if(DB::table('oj_problems')->where('problem_id',$proId)->first()) {
            return;
        }
        $id = DB::table('oj_problems')->insert([
            'problem_id' => $pro->id,
            'title' => $pro->title,
        ]);
        DB::table('oj_problem_infos')->insert([
            'id' => $id
        ]);
        return redirect()->back();
    }

    public function cgLabel(Request $request) {
        DB::table('soj')->where('name', 'label')
            ->update(['content' => $request->input('label')]);
        return response()->json(['result' => 1]);
    }
}

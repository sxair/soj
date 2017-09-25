<?php

namespace App\Http\Controllers;

use App\Http\Base\OjProblemsTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProblemController extends Controller
{
    use OjProblemsTrait;
    public function problems(Request $request)
    {
        $type = $request->input('type');
        $search = $request->input('search');
        $problems = $this->getOjProblems($type, $search);
        return view('problems', ['problems' => $problems, 'type' => $type, 'search' => $search]);
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
        $search = $request->input();
        $status = $request->input('status');
        if(array_key_exists('page', $search))
            $search['page']=null;
        if(array_key_exists('status', $search))
            $search['status']=null;
        $search = array_filter($search);
        $sql = DB::table('oj_status')->where($search)->orderBy('id', 'dasc');
        if (is_null($status) || $status == 0) {
            $status = $sql->paginate(15);
        } else if($status > 4) {
            $status = $sql->where('status', '>', $status * 10000)
                ->where('status', '<', ($status + 1) * 10000)
                ->paginate(15);
        } else {
            $status = $sql->where('status', $status)
                ->paginate(15);
        }
        return view('status', ['status' => $status]);
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
            echo "please login";
            return;
        }
        $problem_id = $request->input('problem_id');
        $lang = $request->input('lang');
        $code = $request->input('code');
        $this->validate($request, [
            'code' => 'min:50|max:65535',
            'problem_id' => 'numeric|exists:oj_problems,id'
        ]);
        $id = DB::table('oj_status')->insertGetId([
            'problem_id' => $problem_id,
            'lang' => $lang,
            'user_name' => $user->name,
            'user_id' => $user->id,
            'code_len' => strlen($code)
        ]);
        DB::insert("INSERT INTO judges(status_id,judge_for) VALUES (?,?)", [$id, 0]);
        DB::insert("INSERT INTO oj_codes(status_id,code) VALUES (?,?)", [$id, $code]);
        DB::update("UPDATE oj_problems SET submitted=submitted+1 WHERE id=?", [$problem_id]);
        DB::update("UPDATE user_infos SET submitted=submitted+1 WHERE id=?", [$user->id]);
        DB::transaction(function () use($user, $problem_id){
            if (!DB::update("UPDATE oj_solved_problems SET submitted=submitted+1 WHERE user_id=? AND problem_id=?", [$user->id, $problem_id])) {
                DB::insert("INSERT INTO oj_solved_problems(user_id,problem_id) VALUES (?,?)", [$user->id, $problem_id]);
            }
        });
        return redirect('status');
    }

    public function showcode($id)
    {
        if(Auth::guest()) {
            return;
        }
        $status = DB::table('oj_status')->where(['id' => $id, 'user_id' => Auth::id()])->get();
        if ($status->isEmpty()) {
            return;
        }
        $code = DB::table('oj_codes')->where(['status_id' => $id])->get();
        return view('showcode', ['code' => $code[0], 'status' => $status[0]]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProblemsController extends Controller
{
    public function problems(Request $request)
    {
        $page = getCurrentPage($request->input('page'));
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

    /**
     * store input and output file
     * if a kind of file is none,then will create a empty file
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setProblemData(Request $request)
    {
        $in = $request->file('input_file');
        $out = $request->file('output_file');
        if (is_null($in) && is_null($out)) {
            return response()->json(['failed' => "请选择输入输出文件"]);
        }
        $proId = $request->input('id');
        $cnt_in = count($in); $cnt_out = count($out);
        $max = max($cnt_in, $cnt_out);
        for($i = 0; $i < $max; $i++) {
            $in_file =  $proId . '/pro' . $proId . '_test' . ($i + 1) . '.in';
            $out_file =  $proId . '/pro' . $proId . '_test' . ($i + 1) . '.out';
            if($i < $cnt_in) {
                if ($in[$i]->isValid()) { // if upload success
                    $x = $in[$i]->getClientOriginalExtension();
                    if ($x != 'txt' && $x != 'in') {
                        return response()->json(['failed' => "第 " . ($i + 1) . " 个输入文件后缀为 $x 应为txt或in"]);
                    }
                    $in[$i]->storeAs('data', $in_file);
                } else {
                    return response()->json(['failed' => "第 " . ($i + 1) . " 个输入文件上传失败"]);
                }
            } else {
                Storage::disk()->put('data/' . $in_file,"");
            }
            if($i < $cnt_out) {
                if ($out[$i]->isValid()) { // if upload success
                    $x = $out[$i]->getClientOriginalExtension();
                    if ($x != 'txt' && $x != 'out') {
                        return response()->json(['failed' => "第 " . ($i + 1) . " 个输出文件后缀为 $x 应为txt或out"]);
                    }
                    $out[$i]->storeAs('data', $out_file);
                } else {
                    return response()->json(['failed' => "第 " . ($i + 1) . " 个输出文件上传失败"]);
                }
            } else {
                Storage::disk()->put('data/' . $out_file,"");
            }
        }
        DB::table('problems')->where('id', $proId)->update(['judge_cnt' => $max]);
        return response()->json(['success' => '成功上传' . $cnt_in . '个输入文件和' . $cnt_out . '个输出文件']);
    }

    public function cgLabel(Request $request) {
        DB::table('soj')->where('name', 'label')
            ->update(['content' => $request->input('label')]);
        return response()->json(['result' => 1]);
    }
}

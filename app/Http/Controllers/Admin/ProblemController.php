<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Tools\zip;

class ProblemController extends Controller
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
            'content' => 'required|min:50|max:65535',
            'md' => 'required|min:50|max:65535',
            'author' => 'max:50',
            'source' => 'max:50',
        ]);
        /*
         * 存入题目库
         */
        $id = DB::table('problems')->insertGetId([
            'title' => $request->input('title'),
            'time_limit' => $request->input('time'),
            'memory_limit' => $request->input('memory'),
            'judge_cnt' => 0,
            'content' => $request->input('content'),
            'author' => $request->input('author'),
            'source' => $request->input('source'),
        ]);
        /*
         * 存入admin表
         */
        DB::table('admin_problems')->insert([
            'problem_id' => $id,
            'title' => $request->input('title'),
            'user_name' => $user->name,
            'public' => 1,
            'show' => 0,
        ]);
        /*
         * 存入markdown源码
         */
        DB::table('problem_md')->insert([
            'id' => $id,
            'content' => $request->input('md')
        ]);
        return response()->json(['result' => $id]);
    }

    public function changeProblem(Request $request)
    {

    }

    public function addToOj($proId)
    {
        /*
         * 验证题目是否存在
         */
        $pro = DB::table('problems')->where('id', $proId)->first();
        $ad_pro = DB::table('admin_problems')->where('problem_id', $proId)->first();
        if (is_null($pro) || is_null($ad_pro)) {
            return response()->json(['failed' => '题目不存在']);
        }
        /*
         * 验证是否已经在oj库中
         */
        if ($ad_pro->show) {
            return response()->json(['failed' => '题目已经在oj库中']);
        }
        $id = DB::table('oj_problems')->insertGetId([
            'problem_id' => $pro->id,
            'title' => $pro->title,
        ]);
        /*
         * 增加oj_problem_infos内
         * 使用ignore避免重复插入
         */
        DB::insert("INSERT IGNORE INTO `oj_problem_infos`(`id`) VALUES (?)", [$id]);
        DB::table('admin_problems')->where('problem_id')->update(['show' => 1]);
        return response()->json(['success' => $id]);
    }

    public function delFromOj($proId) {

    }

    /**
     * store input and output file
     * if a kind of file is none,then will create a empty file
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setProblemData(Request $request)
    {
        /*
         * if in1 out1=null in2=null out2
         * then will be in1 out1
         * if want to solve this
         * use id
         */
        $in = $request->file('input_file');
        $out = $request->file('output_file');
        if (is_null($in) && is_null($out)) {
            return response()->json(['failed' => "请选择输入输出文件"]);
        }
        $proId = $request->input('id');
        $cnt_in = count($in);
        $cnt_out = count($out);
        $max = max($cnt_in, $cnt_out);
        for ($i = 0; $i < $max; $i++) {
            $in_file = $proId . '/pro' . $proId . '_test' . ($i + 1) . '.in';
            $out_file = $proId . '/pro' . $proId . '_test' . ($i + 1) . '.out';
            if ($i < $cnt_in) {
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
                Storage::disk()->put('data/' . $in_file, "");
            }
            if ($i < $cnt_out) {
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
                Storage::disk()->put('data/' . $out_file, "");
            }
        }
        DB::table('problems')->where('id', $proId)->update(['judge_cnt' => $max]);
        return response()->json(['success' => '成功上传' . $cnt_in . '个输入文件和' . $cnt_out . '个输出文件']);
    }

    public function downTest($id)
    {
        $testPath = storage_path('app/data/' . $id);
        if (!is_dir($testPath)) {
            return view('errors.alert', ['content' => '题目数据不存在']);
        }
        $zipname = $testPath . '/pro' . $id . '.zip';
        if (!file_exists($zipname)) {
            $zip = new zip;
            if ($zip->create($zipname) !== true) {
                return view('errors.alert', ['content' => '压缩文件创建失败']);
            }
            $zip->addDir(storage_path('app/data/' . (int)$id));
        }
        return response()->download($zipname);
    }

    public function cgLabel(Request $request)
    {
        DB::table('soj')->where('name', 'label')
            ->update(['content' => $request->input('label')]);
        return response()->json(['result' => 1]);
    }

    public function getProblem($id)
    {
        $pro = DB::table('admin_problems')->where(['problem_id' => $id])->first();
        if(is_null($pro)) {
            return response()->json(['failed' => '题目不存在']);
        }
        if($pro->user_name != Auth::user()->name && !$pro->public) {
            return response()->json(['failed' => '您没有修改权限']);
        }
        $pro = DB::table('problems')->where('id', $id)->first();
        $md = DB::table('problem_md')->where('id', $id)->first();
        $pro->md = $md->content;
        return response()->json(['pro' => $pro]);
    }
}

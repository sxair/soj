<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\BaseController as Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Tools\zip;

class ProblemController extends Controller
{

    public function problems(Request $request)
    {
        $page = getCurrentPage($request->input('page'));
        $perPage = 50;
        if($this->isStudent()) {
            $total = DB::table('admin_problems')
                ->where('user_name', Auth::user()->name)
                ->orWhere('public', 1)
                ->count();
            $problems = DB::table('admin_problems')
                ->where('user_name', Auth::user()->name)
                ->orWhere('public', 1)
                ->offset(($page - 1) * $perPage)->limit($perPage)->get();
        } else {
            $total = DB::table('admin_problems')
                ->count();
            $problems = DB::table('admin_problems')
                ->offset(($page - 1) * $perPage)->limit($perPage)->get();
        }
        return response()->json(array_merge(['problems' => $problems], ['total' => $total]));
    }

    public function problemValidator(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:30',
            'time' => 'required|numeric|max:99999',
            'memory' => 'required|numeric|max:524288',
            'content' => 'required|min:50|max:65535',
            'md' => 'required|min:50|max:65535',
            'author' => 'max:50',
            'source' => 'max:50',
            'public' => 'required'
        ]);
    }

    public function addProblem(Request $request)
    {
        $this->problemValidator($request);
        /*
         * 存入题目库
         */
        $id = DB::table('problems')->insertGetId([
            'title' => $request->input('title'),
            'time_limit' => $request->input('time'),
            'memory_limit' => $request->input('memory'),
            'judge_cnt' => 0,
            'spj' => 0,
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
            'user_name' => Auth::user()->name,
            'public' => $request->input('show') ? 1 : 0,
            'oj_id' => 0,
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
        $this->problemValidator($request);
        $this->validate($request,[
            'id' => 'required'
        ]);
        $id = $request->input('id');
        $pro = DB::table('admin_problems')->where('problem_id', $id)->first();
        if($pro == null || (!$pro->public && $this->isStudent())) abort(422);
        DB::table('problems')->where('id', $id)->update([
            'title' => $request->input('title'),
            'time_limit' => $request->input('time'),
            'memory_limit' => $request->input('memory'),
            'content' => $request->input('content'),
            'author' => $request->input('author'),
            'source' => $request->input('source'),
        ]);
        DB::table('admin_problems')->where('problem_id', $id)->update([
            'title' => $request->input('title'),
            'public' => $request->input('show') ? 1 : 0,
        ]);
        DB::table('problem_md')->where('id', $id)->update([
            'content' => $request->input('md')
        ]);
        if($pro->oj_id) {
            DB::table('oj_problems')->where('id', $pro->oj_id)->update([
                'title' => $request->input('title')
            ]);
        }
        return response()->json(['result' => $id]);
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

    public function delFromOj($proId)
    {

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
        $admin_pro = DB::table('admin_problems')->where(['problem_id' => $id])->first();
        if (is_null($admin_pro)) {
            return response()->json(['failed' => '题目不存在']);
        }
        if ($admin_pro->user_name != Auth::user()->name && !$admin_pro->public
            && (Auth::user()->conrtol & config('soj.admin.student'))
        ) {
            return response()->json(['failed' => '您没有获取权限']);
        }
        $pro = DB::table('problems')->where('id', $id)->first();
        $md = DB::table('problem_md')->where('id', $id)->first();
        $pro->md = $md->content;
        $pro->public = $admin_pro->public;
        return response()->json(['pro' => $pro]);
    }

    public function getLabelArray()
    {
        $label = DB::table('soj')->select('content')
            ->where('name', 'label')->first()->content;
        return json_decode(preg_replace('# |\n|\r#', '', $label), true);
    }

    public function saveLabel($l)
    {
        return DB::table('soj')->where('name', 'label')->update(['content' => json_encode($l)]);
    }

    public function addLabel(Request $request)
    {
        $this->validate($request,[
            'index' => 'required',
            'name' => 'required|min:1|max:25'
        ]);
        $label = $this->getLabelArray();
        $index = $request->input('index');
        if(!array_key_exists($index, $label)) {
            abort(422);
        }
        $max = 0;
        if($index == 0) {
            foreach ($label as $l) {
                $max = max($max, $l['id']);
            }
            $label[] = ['name' => $request->input('name'), 'id' => $max + 1000];
        } else {
            if(array_key_exists('son',$label[$index])) {
                foreach ($label[$index]['son'] as $s) {
                    $max = max($max, $s['id']);
                }
                $label[$index]['son'][] = ['name' => $request->input('name'), 'id' => $max + 1];
            } else {
                $label[$index]['son'] = [];
                $label[$index]['son'][0] = ['name' => $request->input('name'), 'id' => $max + 1];
            }
        }
        $this->saveLabel($label);
        return response()->json('success');
    }

    public function changeLabel(Request $request)
    {
        $this->validate($request,[
            'index' => 'required',
            'son' => 'required',
            'name' => 'required|min:1|max:25'
        ]);
        $label = $this->getLabelArray();
        $son = $request->input('son');
        $index = $request->input('index');
        if(!array_key_exists($index, $label)) {
            abort(422);
        }
        if($son != -1) {
            if(array_key_exists($son, $label[$index]['son'])) {
                $label[$index]['son'][$son]['name'] = $request->input('name');
            } else  abort(422);
        } else {
            $label[$index]['name'] = $request->input('name');
        }
        $this->saveLabel($label);
        return response()->json('success');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class ProblemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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

    public function addProblemPage()
    {
        return view('admin.addproblem');
    }

    protected function validateProblem($request)
    {
        $this->validate($request, [
            'title' => 'required|max:50',
            'time_limit' => 'required|max:99999',
            'memory_limit' => 'required|max:524288',
            'spj' => 'required',
            'content' => 'required|max:65535',
            'input' => 'required|max:65535',
            'output' => 'required|max:65535',
            'sample_input' => 'required|max:65535',
            'sample_output' => 'required|max:65535',
            'author' => 'max:50',
            'source' => 'max:50',
        ]);
    }

    protected function ProblemContent($request)
    {
        return [
            'title' => $request->input('title'),
            'time_limit' => $request->input('time_limit'),
            'memory_limit' => $request->input('memory_limit'),
            'spj' => $request->input('spj'),
            'judge_cnt' => 0,
            'content' => $request->input('content'),
            'input' => $request->input('input'),
            'output' => $request->input('output'),
            'sample_input' => $request->input('sample_input'),
            'sample_output' => $request->input('sample_output'),
            'hint' => $request->input('hint'),
            'author' => $request->input('author'),
            'source' => $request->input('source'),
        ];
    }

    public function addProblem(Request $request)
    {
        $this->validateProblem($request);

        $id = DB::table('problems')->insertGetId($this->ProblemContent($request));
        return redirect("changedata/$id")->with('success','题目创建成功');
    }

    public function updateProblem(Request $request)
    {
        $this->validateProblem($request);
        $id = $request->input('id');
        if(DB::table('problems')
            ->where('id', $id)
            ->update($this->ProblemContent($request))) {
            return redirect("changedata/$id")->with('success','题目更新成功');
        }
        return redirect()->back()->withErrors('题目更新失败');
    }

    public function showProblem()
    {

    }

    public function updateProblemPage(Request $request, $id)
    {
        $pro = DB::table('problems')->where('id', $id)->get();
        if($pro->isEmpty()) {
            return;
        }
        return view('admin.updateproblem', ['pro' => $pro[0]]);
    }

    public function changeDataPage($id)
    {
        $exists = DB::table('problems')->where('id',$id)->first();
        if (is_null($exists)) {
            return view('admin.changedata')->withErrors('Problem id not exists');
        }
        return view('admin.changedata', ['id' => $id]);
    }

    public function changeData(Request $request)
    {
        $infile = $request->file('input_file');
        $outfile = $request->file('output_file');
        $cnt = count($infile);
        if($cnt == 0 || is_null($infile) || is_null($outfile)) {
            return redirect()->back()->with('failed',"请选择输入输出文件");
        }
        $proid = $request->input('id');
        foreach ($infile as $i => $f) {
            if (!array_key_exists($i, $outfile) && !array_key_exists($i,$infile)) {
                DB::table('problems')->update(['judge_cnt' => $i+1]);
                return redirect()->back()->with('warning', '成功传输'.$i.'组测试文件,但收到'.$cnt.'组测试');
            }
            if (!array_key_exists($i,$infile)) {
                return redirect()->back()->with('failed',"第 ".($i+1)." 个输入文件为空但输出文件不为空");
            }
            if($infile[$i]->isValid()) {
                $x = $infile[$i]->getClientOriginalExtension();
                if($x != 'txt' && $x != 'in') {
                    return redirect()->back()->with('failed',"第 ".($i+1)." 个输入文件后缀为 $x 应为txt或in结尾");
                }
                $infile[$i]->storeAs('data', $proid.'/pro'.$proid.'_test'.($i+1).'.in');
            } else {
                return redirect()->back()->with('failed',"第 ".($i+1)." 个输入文件上传失败");
            }
            if (!array_key_exists($i, $outfile)) {
                return redirect()->back()->with('failed',"第 ".($i+1)." 个输出文件为空但输入文件不为空");
            }
            if($outfile[$i]->isValid()) {
                $x = $outfile[$i]->getClientOriginalExtension();
                if($x != 'txt' && $x != 'out') {
                    return redirect()->back()->with('failed',"第 ".($i+1)." 个输出文件后缀为 $x 应为txt或out结尾");
                }
                $outfile[$i]->storeAs('data', $proid.'/pro'.$proid.'_test'.($i+1).'.out');
            } else {
                return redirect()->back()->with('failed',"第 ".($i+1)." 个输出文件上传失败");
            }
        }
        DB::table('problems')->update(['judge_cnt' => $cnt]);
        return redirect()->back()->with('success', '成功传输'.$cnt.'组测试文件');
    }

    public function insertToRedis()
    {
        Redis::flushall();
        $pros = DB::table('oj_problems')->select(['id', 'title', 'accepted', 'submitted'])->get();
        Redis::pipeline(function ($pipe) use($pros) {
            foreach ($pros as $pro) {
                $pipe->ZADD('ojpros', $pro->id, json_encode($pro, JSON_UNESCAPED_UNICODE));
            }
        });
    }
}

<?php

namespace App\Http\Base;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

trait OjProblemsTrait{
    public function getOjProblems($type = null, $search = null)
    {
        if($type && $type >= 1 && $type <= 3 && $search) {
            $typeValue = ['', 'title', 'source', 'author'];
            if($type == 1) {
                return DB::table('oj_problems')->select(['id', 'title', 'accepted', 'submitted'])
                    ->where($typeValue[$type], 'like', '%'.$search.'%')->paginate(100);
            } else {
                return DB::table('oj_problems')
                    ->select(['oj_problems.id', 'oj_problems.title', 'oj_problems.accepted', 'oj_problems.submitted',
                        'problems.author', 'problems.source'])
                    ->join('problems', 'problems.id', '=', 'oj_problems.problem_id')
                    ->where('problems.'.$typeValue[$type], 'like', '%'.$search.'%')
                    ->paginate(100);
            }
        } else {
//            $problems = DB::table('oj_problems')->select(['id', 'title', 'accepted', 'submitted'])
//                ->paginate(100);
            $perPage = 100;
            $page = Paginator::resolveCurrentPage('page');
            $total = Redis::ZCARD('ojpros');
            $tpage = ($page - 1) * $perPage;
            $res = Redis::ZRANGE('ojpros', $tpage , $tpage + $perPage - 1);
            foreach ($res as &$re) {
                $re = json_decode($re);
            }
            $results = $total ? collect($res) : collect();
            $options = [
                'path' => Paginator::resolveCurrentPath(),
                'pageName' => 'page',
            ];
            return new LengthAwarePaginator($results, $total, $perPage, $page, $options);
        }
    }

    public function ToProblems($id) {
        $ojpro = DB::table('oj_problems')->where('id', $id)->first();
        if(is_null($ojpro)) return null;
        $pro = DB::table('problems')->where('id', $ojpro->problem_id)->first();
        return (object)array_merge((array)$pro, (array)$ojpro);
    }
}

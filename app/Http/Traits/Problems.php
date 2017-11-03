<?php

namespace App\Http\Traits;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

trait Problems{
    public function getProblem($id) {
        return DB::table('problems')->where('id', $id)->first();
    }
}

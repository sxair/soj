@extends('layouts.app')
@section('content')
    <nav class="s-subbar">
        <div class="s-subcon">
            <ul class="s-subnav">
                <li><a href="#" class="s-active">Problems</a></li>
                <li><a href="#">Status</a></li>
                <li><a href="#">Ranks</a></li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-md-8" id="problems">
                <el-card>
                    <Problems :problems="problems"></Problems>
                </el-card>
            </div>
        </div>
    </div>
@endsection
@push('js')
<script>
    var pro = new Vue({
        el : '#problems',
        data:{
            problems:[]
        }
    });
</script>
@endpush
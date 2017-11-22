@extends('layouts.app')
@section('content')
    <nav class="s-subbar">
        <div class="s-subcon">
            <ul class="s-subnav">
                <li><a href="{{ url('problems') }}">Problems</a></li>
                <li><a href="{{ url('status') }}">Status</a></li>
                <li><a href="{{ url('ranks') }}">Ranks</a></li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <el-col :md="19">
            <problem :pro="object"></problem>
        </el-col>
        <el-col :md="5">

        </el-col>
    </div>
@endsection
@push('js')
<script>
window.app.object = {!! json_encode($pro) !!};
</script>
@endpush
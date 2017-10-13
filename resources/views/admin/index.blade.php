@extends('layouts.admin')
@section('content')
    <el-row :gutter="20">
        <el-col :sm="5">
            <nav-menu></nav-menu>
        </el-col>
        <el-col :sm="18">
            <router-view></router-view>
        </el-col>
    </el-row>
@endsection
@push('js')
<script>

</script>
@endpush
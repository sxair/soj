@extends('layouts.app')
@section('content')
    <nav class="s-subbar">
        <div class="s-subcon">
            <ul class="s-subnav">
                <li><a href="javascript:void(0);" class="s-active">Problems</a></li>
                <li><a href="{{ url('status') }}">Status</a></li>
                <li><a href="{{ url('ranks') }}">Ranks</a></li>
            </ul>
        </div>
    </nav>
    <problems-model></problems-model>
@endsection
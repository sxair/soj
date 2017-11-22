@extends('layouts.app')
@section('content')
<div class="text-center col-md-10 col-md-offset-1 bg">
    <h1>{{ $user->name }}</h1>
    <p>
        <i>school:</i>{{ $user->school }}&nbsp&nbsp&nbsp
        <i>registered on:</i>{{ date('Y-m-d',strtotime($user->created_at)) }}
    </p>
    <div>
        {{ $user->motto==''?'This fellow left nothing here.':$user->motto }}
    </div>
    <table class="text-left" style="margin: auto;width: 300px">
        <tr>
            <td>Problems Submitted</td>
            <td>{{ $user->submitted }}</td>
        </tr>
        <tr>
            <td>Problems Solved</td>
            <td>{{ $user->accepted }}</td>
        </tr>
    </table>
    <hr>
    @foreach($solveds as $solved)
        <a href="#">{{ $solved->problem_id }}</a>
        <small>{{ $solved->accepted }}/{{ $solved->submitted }}</small>
    @endforeach
</div>
@endsection
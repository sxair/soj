@extends('layouts.app')
@section('content')
    <div class="container">
        <ul class="col-md-12 list-inline">
            <li class="onclick"><a href="{{ url('problems') }}">Problems</a></li>
            <li><a href="{{ url('status') }}">Status</a></li>
            <li><a href="{{ url('rank') }}">Rank</a></li>
        </ul>
        <div class="row">
            <div class="bg col-md-10 col-md-offset-1">
                <table class="table table-hover" style="margin-bottom: -5px">
                    <tr>
                        <th width="10%">name</th>
                        <th width="70%">motto</th>
                        <th style="text-align: center">Accepted/Submitted</th>
                    </tr>
                    @foreach($ranks as $rank)
                        <tr>
                            <td>{{ $rank->id }}</td>
                            <td>{{ $rank->motto }}</td>
                            <td style="text-align: center">
                                @if($rank->submitted)
                                    <?php printf("%.2f", ($rank->accepted/$rank->submitted)*100) ?>%
                                @else
                                    0.00%
                                @endif
                                    ({{ $rank->accepted }}/{{ $rank->submitted }})
                            </td>
                        </tr>
                    @endforeach
                </table>
                {{ $ranks->links() }}
            </div>
        </div>
    </div>
@endsection
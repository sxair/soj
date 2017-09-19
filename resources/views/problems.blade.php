@extends('layouts.app')
@section('content')
    <div class="container">
        <ul class="col-md-12 list-inline">
            <li class="onclick"><a href="{{ url('problems') }}">Problems</a></li>
            <li><a href="{{ url('status') }}">Status</a></li>
            <li><a href="{{ url('rank') }}">Rank</a></li>
        </ul>
        <div class="row">
            <div class="bg col-md-9" style="padding-top: 13px">
                <form action="{{ url('problems') }}" class="form-inline" style="padding-bottom: 3px">
                    <input type="text" class="form-control" style="margin-bottom: 2px" name="search" value="{{ $search }}"/>
                    <select class="form-control" name="type" style="margin-bottom: 2px" id="type">
                        <option value="1">title</option>
                        <option value="2">source</option>
                        <option value="3">author</option>
                    </select>
                    <button class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
                </form>
                @if($problems->hasPages())
                    <div style="margin: -13px 0;">
                        @if($type && $search)
                            {{ $problems->appends(['type' => $type, 'search' => $search])->links() }}
                        @else
                            {{ $problems->links() }}
                        @endif
                    </div>
                @endif
                <table class="table table-hover" style="margin-bottom: -5px;margin-top: 3px">
                    <tr>
                        @if($type > 1 && $search)
                            <th width="10%">id</th>
                            <th>title</th>
                            <th>author</th>
                            <th>source</th>
                            <th style="text-align: center">Accepted/Submitted</th>
                        @else
                            <th width="10%">id</th>
                            <th width="70%">title</th>
                            <th style="text-align: center">Accepted/Submitted</th>
                        @endif
                    </tr>
                    @foreach($problems as $pro)
                        <tr>
                            <td>{{ $pro->id }}</td>
                            <td><a href="{{ url('problem',[$pro->id]) }}">{{ $pro->title }}</a></td>
                            @if($type > 1 && $search)
                                <td>{{ $pro->author }}</td>
                                <td>{{ $pro->source }}</td>
                            @endif
                            <td style="text-align: center">
                                @if($pro->submitted)
                                    <?php printf("%.2f", ($pro->accepted / $pro->submitted) * 100) ?>%
                                @else
                                    0.00%
                                @endif
                                    ({{ $pro->accepted }}/{{ $pro->submitted }})
                            </td>
                        </tr>
                    @endforeach
                </table>
                @if($type && $search)
                    {{ $problems->appends(['type' => $type, 'search' => $search])->links() }}
                @else
                    {{ $problems->links() }}
                @endif
            </div>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">分类</div>
                    <div class="panel-body">
                    </div>
                </div>
            </div>
        </div>

    </div>
    @push('js')
        <script>
            $(function () {
                var type = "{{ $type }}";
                if(type >= 1 && type <= 3) {
                    $('#type').val(type);
                }
                $('[data-toggle="popover"]').popover();
            });
        </script>
    @endpush
@endsection
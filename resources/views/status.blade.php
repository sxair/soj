@extends('layouts.app')
@section('content')
    <div class="container">
        <ul class="col-md-10 list-inline">
            <li class="onclick"><a href="{{ url('problems') }}">Problems</a></li>
            <li><a href="{{ url('status') }}">Status</a></li>
            <li><a href="{{ url('rank') }}">Rank</a></li>
        </ul>
        <div class="row">
            <div class="bg col-md-12">
                <div style="margin:7px 7px">
                    <form action="{{ url('status') }}" class="form-inline">
                        <label>Author</label>
                        <input type="text" class="form-control" name="user_name" maxlength="50" style="width: 120px"
                               value="{{ Request::input('user_name') }}">
                        &nbsp;
                        <label>pro_id</label>
                        <input type="text" class="form-control" name="problem_id" maxlength="4" style="width: 80px"
                               value="{{ Request::input('problem_id') }}"/>
                        &nbsp;
                        <label>status</label>
                        {{ status_select() }}
                        &nbsp;
                        <label>language</label>
                        <select class="form-control" name="lang" id="lang">
                            <option value="0">All</option>
                            {{ lang_option() }}
                        </select>
                        &nbsp;
                        <button class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
                    </form>
                </div>
                <table class="table table-hover table-center" style="margin-bottom: -5px">
                    <tr>
                        <th>id</th>
                        <th>user</th>
                        <th>pro.id</th>
                        <th>status</th>
                        <th>language</th>
                        <th>code len</th>
                        <th>time</th>
                        <th>memory</th>
                        <th>submit time</th>
                    </tr>
                    @foreach($status as $sta)
                        <tr>
                            <td>{{ $sta->id }}</td>
                            <td><a href="{{ url('userinfo', $sta->user_id) }}">{{ $sta->user_name }}</a></td>
                            <td><a href="{{ url('problem',[$sta->problem_id]) }}">{{ $sta->problem_id }}</a></td>
                            <td style="text-align: center">{!! status_html($sta->status) !!}</td>
                            <td>{{ lang_html($sta->lang) }}</td>
                            @if(Auth::id() == $sta->user_id)
                                <td><a href="{{ url('showcode',$sta->id) }}">{{ $sta->code_len }}</a></td>
                            @else
                                <td>{{ $sta->code_len }}</td>
                            @endif
                            <td>{{ $sta->time }}</td>
                            <td>{{ $sta->memory }}</td>
                            <td>{{ $sta->created_at }}</td>
                        </tr>
                    @endforeach
                </table>
                {{ $status->appends(Request::input())->links() }}
            </div>
        </div>
    </div>
    @push('js')
    <script>
        var lang = "{{ Request::input('lang') }}";
        if (lang) {
            $('#lang').val(lang);
        }
        var status = "{{ Request::input('status') }}";
        if (status) {
            $('#status').val(status);
        }
    </script>
    @endpush
@endsection
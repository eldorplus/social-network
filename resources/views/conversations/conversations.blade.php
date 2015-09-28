@extends('template')

@section('content')
<div class="jumbotron">
    <div class="container">
        @foreach($conversations as $conversation)

                <div class="panel panel-default">
                    <div class="panel-heading">
                            From:<a href="/messages/{!! $conversation['id'] !!}"> {!! $conversation['title'] !!} </a>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            @if( ! empty($conversation['user_name']))
                                <div class="col-xs-2">
                                    <a href="/user/{!! $conversation['user_id'] !!}" >{!! $conversation['user_name'] !!}</a>
                                </div>

                                <div class="col-xs-8">
                                    <a href="/messages/{!! $conversation['id'] !!}"> {!! $conversation['message_body'] !!}</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

        @endforeach
    </div>
</div>
@endsection
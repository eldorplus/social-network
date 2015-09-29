@extends('template')

@section('content')
        <h5>{!! $conversation_name !!}</h5>
    <div class="jumbotron conversation" id="conversation">
        <div class="container">
            @foreach($messages->reverse() as $message)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        From: <a href="/user/{!! $message['author_id'] !!}">{!! $message['author_name'] !!} {!! $message['author_surname'] !!}</a>
                    </div>
                    <div class="panel-body">
                        {!! $message['body'] !!}
                    </div>
                </div>
            @endforeach
        </div>
    </div>

        <script src="/js/conversation-scrolled-bottom.js"></script>
@endsection
@section('send_message')
    <div class="send-message-form">
        @include('conversations.write')
    </div>
@endsection
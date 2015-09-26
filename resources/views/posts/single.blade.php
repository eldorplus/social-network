@extends('template')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <a href="/user/{!! $post->author_id !!}">
                {!! App\User::find($post->author_id)->name !!} {!! App\User::find($post->author_id)->surname !!}
            </a>
        </div>
        <div class="panel-body">
            <p>{!! $post->body !!}</p>
        </div>
        <div class="panel-footer">
            <p><a href="/post/{!! $post->id !!}">{!! $post->created_at !!}</a></p>
        </div>
    </div>

@endsection
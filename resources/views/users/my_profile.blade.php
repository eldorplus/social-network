@extends('template')

@section('content')
    <h1>{!! $name !!} {!! $surname !!}</h1>
    <button>Settings</button>
    <hr/>
    @include('users.my_friends')
    @include('posts.all')
@stop
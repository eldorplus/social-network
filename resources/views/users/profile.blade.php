@extends('template')

@section('content')
    <h1>{!! $name !!} {!! $surname !!}</h1>
    <hr/>
    @include('posts.all')
@stop
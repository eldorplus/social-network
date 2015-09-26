@extends('template')

@section('content')
    @if (Auth::check())
    @include('posts.write')
    @endif
    @include('posts.all')

@endsection
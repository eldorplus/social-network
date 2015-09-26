@extends('template')

@section('content')
    @if (Auth::check())
        @include('posts.write')
        @include('posts.all')
    @else
        @include('pages.welcome')
    @endif


@endsection
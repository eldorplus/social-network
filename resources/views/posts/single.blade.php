@extends('template')


@section('content')
    @include('posts.post_template')
@endsection

@section('scripts')
    <script src="/js/vote-button-click.js"></script>
    <script src="/js/comments.js"></script>
    <script>
        $('.collapse').collapse({toggle: true});
    </script>
@endsection
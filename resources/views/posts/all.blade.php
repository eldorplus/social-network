
    <h1>All posts:</h1>
    <hr/>
    @foreach($posts->reverse() as $post)
        @include('posts.post_template')
        <script src="/js/vote-button-click.js"></script>
    @endforeach

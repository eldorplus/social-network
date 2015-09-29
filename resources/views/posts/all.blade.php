
    <h1>All posts:</h1>
    <hr/>
    @foreach($posts as $post)
        @include('posts.post_template')
    @endforeach

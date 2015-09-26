
    <h1>All posts:</h1>
    <hr/>
    @foreach($posts as $post)
        <div class="col-sm-offset-1 col-sm-10">
            <h2>{!! $post->title !!}</h2>
            <p>{!! $post->body !!}</p>
            <p>By : {!! App\User::find($post->author_id)->email !!}</p>
        </div>
    @endforeach

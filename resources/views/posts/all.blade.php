
    <h1>All posts:</h1>
    <hr/>
    @foreach($posts as $post)
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
                @if($post->created_at!=$post->updated_at)
                    <p>Updated at: {!! $post->updated_at !!}</p>
                @endif
                @can('update-post',$post)
                    <a href="/post/{!! $post->id !!}/edit">Edit</a>
                    <a href="/post/{!! $post->id !!}/destroy">Remove</a>
                @endcan

            </div>
        </div>
    @endforeach

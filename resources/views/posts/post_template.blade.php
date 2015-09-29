<div class="panel panel-default">
    <div class="panel-heading">
        <a href="/user/{!! $post->author_id !!}">
            {!! App\User::find($post->author_id)->name !!} {!! App\User::find($post->author_id)->surname !!}
        </a>
        @can('update-post',$post)
            <div class="btn-group" role="group" aria-label="..." style="float: right;">
                <button type="button" class="btn btn-default btn-edit" data-token="{!! csrf_token() !!}" data-method="POST"       data-target="/post/{!! $post->id !!}/edit" title="Edit"><span class="glyphicon glyphicon-edit"></span></button>
                <button type="button" class="btn btn-default btn-delete" data-token="{!! csrf_token() !!}" data-method="DELETE"     data-target="/post/{!! $post->id !!}/destroy" title="Delete"><span class="glyphicon glyphicon-remove"></span></button>
            </div>
        @endcan
    </div>
    <div class="panel-body">
        <p>{!! $post->body !!}</p>
    </div>
    <div class="panel-footer" style="width: 100%">

        <a href="/post/{!! $post->id !!}">{!! $post->created_at !!}</a>
        @if($post->created_at!=$post->updated_at)
            Updated at: {!! $post->updated_at !!}
        @endif
        <div class="btn-group" role="group" aria-label="..." style="float: right;">
            <button type="button" class="btn btn-default target-button vote-button" data-token="{!! csrf_token() !!}" data-method="POST"       data-target="/post/{!! $post->id !!}/upvote" @if($post->author_id==Auth::id()) disabled @endif>
                <span class="glyphicon glyphicon-arrow-up">
                    @if($post->votes()->type('upvote')->get()->count()>0)
                        {!! $post->votes()->type('upvote')->get()->count() !!}
                    @endif
                </span>
            </button>
            <button type="button" class="btn btn-default target-button vote-button" data-token="{!! csrf_token() !!}" data-method="DELETE"     data-target="{!! url('/post/'.$post->id.'/downvote') !!}" @if($post->author_id==Auth::id()) disabled @endif>
                <span class="glyphicon glyphicon-arrow-down">
                    @if($post->votes()->type('downvote')->get()->count()>0)
                       {!!$post->votes()->type('downvote')->get()->count() !!}
                    @endif
                </span>
            </button>
        </div>
    </div>
</div>

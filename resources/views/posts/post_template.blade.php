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
            <button id="{!! $post->id !!}-upvote" type="button" class="btn btn-default target-button vote-button upvote" data-token="{!! csrf_token() !!}" data-type="upvote"           data-identification='{!! $post->id !!}' data-target="/post/{!! $post->id !!}/upvote" @if($post->author_id==Auth::id() || $post->votes()->type('upvote')->voted()->get()->count()>0) disabled="disabled" @endif>
                <span class="glyphicon glyphicon-arrow-up">
                        {!! $post->votes()->type('upvote')->get()->count() !!}
                </span>
            </button>
            <button id="{!! $post->id !!}-downvote" type="button" class="btn btn-default target-button vote-button downvote" data-token="{!! csrf_token() !!}" data-type="downvote"     data-identification='{!! $post->id !!}' data-target="{!! url('/post/'.$post->id.'/downvote') !!}" @if($post->author_id==Auth::id() || $post->votes()->type('downvote')->voted()->get()->count()>0) disabled="disabled" @endif>
                <span class="glyphicon glyphicon-arrow-down">
                       {!!$post->votes()->type('downvote')->get()->count() !!}
                </span>
            </button>
        </div>
    </div>
</div>

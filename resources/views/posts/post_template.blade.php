<div class="panel panel-default post-container" id="{!! $post->id !!}-container">
    <div class="panel-heading">
        <a href="/user/{!! $post->author_id !!}">
            {!! App\User::find($post->author_id)->name !!} {!! App\User::find($post->author_id)->surname !!}
        </a>
        @can('update-post',$post)
            <div class="btn-group" role="group" aria-label="..." style="float: right;">
                <button type="button" class="btn btn-default btn-edit" data-token="{!! csrf_token() !!}"     data-method="/post/{!! $post->id !!}/edit" title="Edit" data-identification="{!! $post->id !!}">
                    <span class="glyphicon glyphicon-edit"></span>
                </button>
                <button href="#" class="btn btn-default btn-delete"  data-method="/post/{!! $post->id !!}/destroy" data-toggle="modal" data-target="#alertModal" data-identification="{!! $post->id !!}">
                    <span class="glyphicon glyphicon-remove"></span>
                </button>
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
            <button class="btn btn-default btn-info" data-toggle="collapse" data-target="#{!! $post->id !!}-comments">
                <span class="glyphicon glyphicon-menu-hamburger" id="{!! $post->id !!}-comment-button">
                    {!! $post->comments()->get()->count() !!}
                </span>
            </button>
            <button id="{!! $post->id !!}-upvote" type="button" class="btn btn-default target-button vote-button upvote" data-token="{!! csrf_token() !!}" data-type="upvote"           data-identification='{!! $post->id !!}' data-method="/post/{!! $post->id !!}/upvote" @if($post->author_id==Auth::id() || $post->votes()->type('upvote')->voted()->get()->count()>0) disabled="disabled" @endif>
                <span class="glyphicon glyphicon-arrow-up">
                        {!! $post->votes()->type('upvote')->get()->count() !!}
                </span>
            </button>
            <button id="{!! $post->id !!}-downvote" type="button" class="btn btn-default target-button vote-button downvote" data-token="{!! csrf_token() !!}" data-type="downvote"     data-identification='{!! $post->id !!}' data-method="{!! url('/post/'.$post->id.'/downvote') !!}" @if($post->author_id==Auth::id() || $post->votes()->type('downvote')->voted()->get()->count()>0) disabled="disabled" @endif>
                <span class="glyphicon glyphicon-arrow-down">
                       {!!$post->votes()->type('downvote')->get()->count() !!}
                </span>
            </button>
        </div>
    </div>
</div>
<div id="{!! $post->id !!}-comments" class="collapse comments-wrapper">
    <div class="comments-container" id="{!! $post->id !!}-comments-container">
        @foreach($post->comments()->get()->reverse() as $comment)
            @include('posts.comment')
        @endforeach
    </div>
    <div class="addComment">
        {!! Form::open(['url'=>'/post/'.$post->id.'/comments/add', 'class'=>'comment-form','id'=>$post->id.'-comment-form','data-identification'=>$post->id]) !!}
                {!! Form::text('body',null,['class'=>'form-control comment-input','required'=>'required' ,'autocomplete'=>"off",'id'=>$post->id.'-input']) !!}
        {!! Form::submit('Add Comment',['class'=>'btn btn-primary', 'style'=>"position: absolute; left: -9999px; width: 1px; height: 1px;",'tabindex'=>'-1']) !!}
        {!! Form::close() !!}
    </div>
</div>

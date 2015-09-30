<div class="row comment">
    <div class="col-xs-1" class="comment-profile-picture">
        <span align="center" class="glyphicon glyphicon-user"></span>
    </div>
    <div class="col-xs-11">
        <div class="row">
            <a href="/user/{!! $comment->author_id !!}">
                {!! App\User::find($comment->author_id)->name !!} {!! App\User::find($comment->author_id)->surname  !!}
            </a>:
            {!! $comment->body !!}
        </div>
        <div class="row">
            {!! $comment->updated_at !!}
        </div>
    </div>
</div>
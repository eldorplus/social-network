<div class="panel panel-default">
    <div class="panel-heading">Friends:</div>
    <div class="panel-body">
        @foreach(Auth::user()->friends as $friend)
            <div class="col-sm-3 col-xs-12 friend-profile-miniature">
                <div class="friend-profile-miniature--name">
                    <h4><a href="/user/{!! $friend->id !!}">{!! $friend->name!!} {!! $friend->surname !!}</a></h4>
                </div>
                <div class="friend-profile-miniature--email">
                    <pre>{!! $friend->email !!}</pre>
                </div>
            </div>
        @endforeach
    </div>
</div>
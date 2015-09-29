<div class="panel panel-default">
    <div class="panel-heading">Friends:</div>
    <div class="panel-body">
        @foreach(App\User::find($id)->friends as $friend)
            <div class="col-sm-4 col-xs-12">
                <div class="col-xs-12 friend-profile-miniature">
                    <div class="friend-profile-miniature--name">
                        <h4><a href="/user/{!! $friend->id !!}">{!! $friend->name!!} {!! $friend->surname !!}</a></h4>
                    </div>
                    <div class="friend-profile-miniature--email">
                        <pre>{!! $friend->email !!}</pre>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
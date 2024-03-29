<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">LARAVEL5 social</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                @if(Auth::check())
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            Messages <span class="badge">
                                {!! App\User::find(Auth::id())->notifications()->unread()->type('message')->count() or ''!!}
                            </span>
                        </a>
                        <div class="dropdown-menu notifications-dropdown">
                            <ul class="notifications-list">
                                @foreach(Auth::user()->notifications()->type('message')->get()->reverse() as $notification)
                                    <li id="messages-li">
                                        <div class="notification {{ $notification->type }}-notification @if(!$notification->isRead()) notification-unread @endif">
                                            <p class="subject">{!!  App\Conversation::find($notification->getObject()->id)->title !!}</p>
                                            <p class="body">{{ $notification->body }}</p>

                                            @if($notification->hasValidObject())
                                                <a href="/notifications/{{ $notification->id }}/received">View</a>
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="notifications-footer">
                                <a href="/messages">
                                    See all
                                </a>
                            </div>
                        </div>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle"  data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            Notifications <span class="badge" id="notifications-count">
                              {!! App\User::find(Auth::id())->notifications()->unread()->not_type('message')->count() > 0 ? App\User::find(Auth::id())->notifications()->unread()->count()  : ''!!}
                            </span>
                        </a>
                        <div class="dropdown-menu notifications-dropdown">
                            <ul class="notifications-list">
                            @foreach(Auth::user()->notifications()->not_type('message')->get()->reverse() as $notification)
                                <li id="notifications-li">
                                <div class="notification {{ $notification->type }}-notification @if(!$notification->isRead()) notification-unread @endif">
                                <p class="subject">{{ $notification->subject }}</p>
                                <p class="body">{{ $notification->body }}</p>
                                    @if($notification->hasValidObject())
                                        <a href="/notifications/{{ $notification->id }}/received">View</a>
                                    @endif
                                </div>
                               </li>
                            @endforeach
                            </ul>
                            <div class="notifications-footer">
                                <a href="#" id="notificationsMarkViewed">
                                    Mark all as viewed
                                </a>
                            </div>
                        </div>
                    </li>
                @endif

            <li><a href="/contact">Contact</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            @if (Auth::check())
                <li><a href="/user">Hi {!! Auth::user()->name !!}!</a></li>
                <li><a href=" {!! url('/auth/logout') !!}">Logout</a></li>
            @else
                <li><a href=" {!! url('/auth/register') !!}">Register</a></li>
                <li><a href=" {!! url('/auth/login') !!}">Login</a></li>
            @endif
        </ul>
    </div><!--/.nav-collapse -->
</div>
</nav>
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
                                {!! $new_messagesNotifications_count !!}
                            </span>
                        </a>
                        <ul class="dropdown-menu notifications-dropdown">
                            @foreach($messagesNotifications as $notification)
                                <li>
                                    <div class="notification {{ $notification->type }}">
                                        <p class="subject">{{ $notification->subject }}</p>
                                        <p class="body">{{ $notification->body }}</p>

                                        @if($notification->hasValidObject())
                                            <a href="/notifications/{{ $notification->id }}/received">View</a>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            Notifications <span class="badge">
                                {!! $new_notifications_count !!}
                            </span>
                        </a>
                        <ul class="dropdown-menu notifications-dropdown">
                            @foreach($notifications as $notification)
                               <li>
                                <div class="notification {{ $notification->type }}">
                                <p class="subject">{{ $notification->subject }}</p>
                                <p class="body">{{ $notification->body }}</p>

                                @if($notification->hasValidObject())
                                <a href="/messages/{{ $notification->getObject()->id }}">View</a>
                                @endif
                                </div>
                               </li>
                            @endforeach
                        </ul>
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
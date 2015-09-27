@extends('template')

@section('content')
    <h1>{!! $name !!} {!! $surname !!}</h1>

    @if(Auth::user()->isFriend($id))
        @include('users.profile_button.friend')
    @elseif(Auth::user()->invitationSend($id))
       @include('users.profile_button.invitation_send')
    @elseif(Auth::user()->invitationReceived($id))
        @include('users.profile_button.invitation_received')
    @else
        @include('users.profile_button.invite')
    @endif

    <hr/>
    @include('users.friends')
    @include('posts.all')
@stop
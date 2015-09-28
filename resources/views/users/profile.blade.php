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
    {!! Form::open(['url'=>'user/'.$id.'/message']) !!}
    {!! Form::submit("Write message.",['class'=>'col-sm-2 col-xs-8']) !!}
    {!! Form::close() !!}
    <hr/>
    @include('users.friends')
    @include('posts.all')
    <script src="/js/random-color-profiles.js"></script>
@stop
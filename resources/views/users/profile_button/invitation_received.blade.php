
{!! Form::open(['url'=>'user/'.$id.'/accept']) !!}
{!! Form::submit("You've been invited!",['class'=>'user-profile-friend-button--invitationReceived col-sm-2 col-xs-8']) !!}
{!! Form::close() !!}
@extends('template')
@section('content')
    {!!  Form::model($post,[$post->id]) !!}

    <div class="form-group">
        {!! Form::textarea('body',null,['class'=>'form-control','rows'=>'2']) !!}
    </div>
    <div class="form-group">
        {!! Form::submit('Update',['class'=>'btn btn-primary form-control']) !!}
    </div>

    {!! Form::close() !!}
@endsection
@extends('template')

@section('content')
    <div class="col-sm-offset-4 col-sm-4">
        {!! Form::open(['url'=>'user']) !!}
        <div class="form-group">
            {!! Form::label('name', 'Name :') !!}
            {!! Form::text('name',null,['class'=>'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('email', 'Email :') !!}
            {!! Form::email('email',null,['class'=>'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('password', 'Password :') !!}
            {!! Form::password('body',null,['class'=>'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::submit('Add Post',['class'=>'btn btn-primary form-control']) !!}
        </div>
        {!! Form::close() !!}
    </div>
@stop
@extends('template')

@section('content')
    <h1>Write a new article</h1>
    <hr/>
    <div class="col-sm-offset-4 col-sm-4">
        {!! Form::open(['url'=>'posts']) !!}
        <div class="form-group">
            {!! Form::label('body', 'Body :') !!}
            {!! Form::textarea('body',null,['class'=>'form-control','required'=>'required']) !!}
        </div>
        <div class="form-group">
            {!! Form::submit('Add Post',['class'=>'btn btn-primary form-control']) !!}
        </div>
        {!! Form::close() !!}
    </div>
@stop

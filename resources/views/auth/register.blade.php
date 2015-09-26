@extends('template')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Register</div>
                    <div class="panel-body">

                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach

                                </ul>
                            </div>

                        @endif

                        {!! Form::open(["class"=>'form-horizontal','role'=>'form','method'=>'POST','url'=>'auth/register']) !!}
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                    {!! Form::label('name', 'Name :',['class'=>'col-md-4']) !!}
                                    {!! Form::text('name',null,['class'=>'form-control']) !!}
                            </div>
                            <div class="form-group">
                                    {!! Form::label('email', 'Email :',['class'=>'col-md-4']) !!}
                                    {!! Form::email('email',null,['class'=>'form-control']) !!}
                            </div>
                            <div class="form-group">
                                    {!! Form::label('password', 'Password :',['class'=>'col-md-4']) !!}
                                    {!! Form::password('password',null,['class'=>'form-control']) !!}
                            </div>
                            <div class="form-group">
                                    {!! Form::label('password_confirmation', 'Confirm password :',['class'=>'col-md-4']) !!}
                                    {!! Form::password('password_confirmation',null,['class'=>'form-control']) !!}
                            </div>
                            <div class="form-group">
                                    {!! Form::submit('Register',['class'=>'btn btn-primary form-control']) !!}
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
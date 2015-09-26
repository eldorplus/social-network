@extends('template')

@section('content')

    <div class="container-fluid">
        <div class="row">

            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Login</div>
                    <div class="panel-body">

                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>Whoops! </strong> There were some problems with your input. <br> <br>
                                <ul>

                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }} </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {!! Form::open(['class'=>'form-horizontal','role'=>'form','method'=>'POST','url'=>'auth/login']) !!}
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                {!! Form::label('email','Email address :',['class'=>'col-md-offset-1 col-md-4']) !!}
                                <div class="col-md-6">
                                    {!! Form::email('email',null,['class'=>'col-md-6 form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('password','Password :',['class'=>'col-md-offset-1 col-md-4']) !!}
                                <div class="col-md-6">
                                    {!! Form::password('password',null,['class'=>'col-md-6 form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-5">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember"> Remember Me
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-4 col-md-offset-1">
                                    <button type="submit" class="btn btn-primary" style="margin-right: 15px;">
                                        Login
                                    </button>
                                </div>
                            </div>
                       {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
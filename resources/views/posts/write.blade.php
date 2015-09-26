
<div class="row">
    {!! Form::open(['url'=>'/']) !!}
    <div class="form-group">
        {!! Form::textarea('body',null,['class'=>'form-control','rows'=>'2']) !!}
    </div>
    <div class="form-group">
        {!! Form::submit('Add Post',['class'=>'btn btn-primary form-control']) !!}
    </div>
    {!! Form::close() !!}
</div>
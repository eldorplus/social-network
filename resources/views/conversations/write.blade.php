

<div class="row">
    <h5>Write:</h5>
    {!! Form::open(['url'=>'/messages/'.$id]) !!}
    <div class="form-group">
        {!! Form::textarea('body',null,['class'=>'form-control','rows'=>'2']) !!}
    </div>
    <div class="form-group" style="margin-bottom: 0;">
        {!! Form::submit('Send',['class'=>'btn btn-primary form-control']) !!}
    </div>
    {!! Form::close() !!}
</div>
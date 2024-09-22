<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'Name') !!}
    <p>{!! Form::text('name', null, ['class' => 'form-control']) !!}</p>
</div>

<!-- Email Field -->
<div class="col-sm-12">
    {!! Form::label('email', 'Email') !!}
    <p>{!! Form::email('email', null, ['class' => 'form-control']) !!}</p>
</div>

<!-- Password Field -->
<div class="col-sm-12">
    {!! Form::label('password', 'Password') !!}
    <p>{!! Form::password('password', ['class' => 'form-control']) !!}</p>
</div>

<!-- Confirmation Password Field -->
<div class="col-sm-12">
    {!! Form::label('password', 'Password Confirmation') !!}
    <p>{!! Form::password('password_confirmation', ['class' => 'form-control']) !!}</p>
</div>

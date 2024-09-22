<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $phase->name }}</p>
</div>

<!-- Details Field -->
<div class="col-sm-12">
    {!! Form::label('details', 'Details:') !!}
    <p>{{ $phase->details }}</p>
</div>

<!-- Amounts Field -->
<div class="col-sm-12">
    {!! Form::label('amounts', 'Amounts:') !!}
    <p>{{ $phase->amounts }}</p>
</div>


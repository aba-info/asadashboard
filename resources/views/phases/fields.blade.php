<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', !empty($phase) ? $phase[0] : null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>
<!-- Completion Field -->
<div class="form-group col-sm-12 wip">
    {!! Form::label('completion', 'completion:') !!}
    {!! Form::select('completion', [
    '0' => '0%',
    '15' => '15%',
    '30' => '30%',
    '45' => '45%',
    '60' => '60%',
    '75' => '75%',
    '90' => '90%',
    '100' => '100%',
    ],  !empty($phase) && is_array($phase) && !empty($phase[25]) ? $phase[25] : '0', ['class' => 'form-control']) !!}
</div>

<!-- Details Field to avoid db validation -->
{!! Form::hidden('details', "validate", ['class' => 'form-control']) !!}

<!-- Amounts Field  to avoid db validation -->
{!! Form::hidden('amounts', "validate", ['class' => 'form-control']) !!}

{!! Form::hidden('project', request('project')) !!}

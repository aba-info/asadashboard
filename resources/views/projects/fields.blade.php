<!-- Name Field -->
<div class="form-group col-sm-12">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', $project[0], ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>
<!-- Completion Field -->
<div class="form-group col-sm-12">
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
    ], !empty($project[1]) ? $project[1] : '0', ['class' => 'form-control']) !!}
</div>
<!-- Payment Field -->
<div class="form-group col-sm-12">
    {!! Form::label('payment', 'payment:') !!}
    {!! Form::select('payment', [
    'Pending' => 'Pending',
    'Paid' => 'Paid',
    'Overdue' => 'Overdue',
    'Not Applicable' => 'Not Applicable',
    ], !empty($project[2]) ? $project[2] : 'Pending', ['class' => 'form-control']) !!}
</div>
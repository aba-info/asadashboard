<!-- User Id Field -->
<div class="col-sm-12">
    {!! Form::label('user_id', 'User Id:') !!}
    <p>{{ $users[$timesheet->user_id] }}</p>
</div>

<!-- Project Id Field -->
<div class="col-sm-12">
    {!! Form::label('project_id', 'Project Id:') !!}
    <p>{{ $timesheet->project_id }}</p>
</div>

<!-- Phase Id Field -->
<div class="col-sm-12">
    {!! Form::label('phase_id', 'Phase Id:') !!}
    <p>{{ $timesheet->phase_id }}</p>
</div>

<!-- Details Field -->
<div class="col-sm-12">
    {!! Form::label('details', 'Details:') !!}
    <p>{{ $timesheet->details }}</p>
</div>

<!-- Time Spent Field -->
<div class="col-sm-12">
    {!! Form::label('time_spent', 'Time Spent:') !!}
    <p>{{ $timesheet->time_spent_hours }}:{{ $timesheet->time_spent_minutes }}</p>

</div>


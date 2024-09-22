<!-- User Id Field -->
<!-- Random change to test CI implementation -->
<div class="col-sm-12">
    {!! Form::label('user_id', 'User:') !!}
    <p>{!! Form::select('user_id', $users, isset($timesheet) ? null : auth()->user()->id, ['class' => 'form-control']) !!}</p>
</div>

<!-- Project Id Field -->
<div class="col-sm-12">
    {!! Form::label('project_id', 'Project:') !!}
    <p>{!! Form::text('project_search', isset($timesheet) ? $timesheet->project_id : null, [
        'class' => 'form-control',
        'id' => 'project-autocomplete',
        'placeholder' => 'Search for a project',
    ]) !!}</p>
    {!! Form::hidden('project_id', isset($timesheet) ? $timesheet->project_id : null, ['id' => 'project-id']) !!}
    {!! Form::hidden('project_ids', implode(',', $projects), ['id' => 'project-ids']) !!}
</div>

<!-- Phase Id Field -->
<div class="col-sm-12">
    {!! Form::label('phase_id', 'Phase:') !!}
    <select id="phase_id" name="phase_id" class="form-control">
        @if(!isset($timesheet))
            <option>First select a project</option>            
        @endif
        @foreach ($phases as $phase)
          <option value="{{ $phase }}" {{ isset($timesheet) && strtolower(trim($timesheet->phase_id)) === strtolower(trim($phase)) ? 'selected' : '' }}>{{ $phase }}</option>
        @endforeach
      </select>
      <a href="{{ route('phases.create') }}" data-url="{{ route('phases.create') }}" class="create__phase" target="_blank"
        rel="noopener noreferrer">Create a new Phase</a> <br> <small>after creating a new phase, please refresh this
        page.</small>
    <br>
    <br>
</div>

<!-- Details Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('details', 'Details:') !!}
    {!! Form::textarea('details', null, ['class' => 'form-control']) !!}
</div>

<!-- Created At Field -->
<div class="form-group col-sm-12">
    {!! Form::label('start_date', 'Start Date:') !!}
    {!! Form::date(
        'start_date',
        isset($timesheet) ? $timesheet->start_date : ($lastUsedStartDate ?: now()->toDateString()),
        ['class' => 'form-control'],
    ) !!}

</div>

<!-- Time Spent Field -->
<div class="form-group col-sm-6">
    {!! Form::label('time_spent_hours', 'Time Spent Hours:') !!}
    <select name="time_spent_hours" id="time_spent_hours" class="form-control">
        @for ($hour = 0; $hour <= 8; $hour++)
            <option value="{{ $hour }}"
                {{ isset($timesheet) && $hour == $timesheet->time_spent_hours ? 'selected' : '' }}>
                {{ $hour }}
            </option>
        @endfor
    </select>
</div>

<div class="form-group col-sm-6">
    {!! Form::label('time_spent_minutes', 'Time Spent Minutes:') !!}
    <select name="time_spent_minutes" id="time_spent_minutes" class="form-control">
        @php
            $minutesArray = [0, 15, 30, 45];
        @endphp
        @foreach ($minutesArray as $minute)
            <option value="{{ $minute }}"
                {{ isset($timesheet) && $minute == $timesheet->time_spent_minutes ? 'selected' : '' }}>
                {{ $minute }}
            </option>
        @endforeach
    </select>
</div>

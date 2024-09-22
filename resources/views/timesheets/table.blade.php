@php
    use App\Helpers\TimesheetsHelper;
    //TODO: unify this function
    $totalHours = 0;
    $totalMinutes = 0;
@endphp
<div class="table-responsive">
    <table class="table" id="timesheets-table">
        <thead>
            <tr>
                <th>User Id</th>
                <th>Project</th>
                <th>Phase</th>
                <th>Details</th>
                <th>Task Start Date</th>
                <th>Time Spent</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($timesheets as $timesheet)
                <tr>
                    <td>{{ $users[$timesheet->user_id] }}</td>
                    <td>{{ $timesheet->project_id }}</td>
                    <td>{{ $timesheet->phase_id }}</td>
                    <td>{{ $timesheet->details }}</td>
                    <td>{{ $timesheet->getFormattedStartDateAttribute()  }}</td>
                    <td>{{ $timesheet->time }}</td>
                    <td width="120">
                        {!! Form::open(['route' => ['timesheets.destroy', $timesheet->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('timesheets.show', [$timesheet->id]) }}" class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('timesheets.edit', [$timesheet->id]) }}" class='btn btn-default btn-xs'>
                                <i class="far fa-edit"></i>
                            </a>
                            {!! Form::button('<i class="far fa-trash-alt"></i>', [
                                'type' => 'submit',
                                'class' => 'btn btn-danger btn-xs',
                                'onclick' => "return confirm('Are you sure?')",
                            ]) !!}
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
                @php
                    // Calculate total hours and minutes
                    $totalHours += $timesheet->time_spent_hours;
                    $totalMinutes += $timesheet->time_spent_minutes;
                @endphp
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5">Total:</th>
                <th>{{ TimesheetsHelper::calculateTime($totalHours, $totalMinutes) }}</th>
                <th colspan="3"></th>
            </tr>
        </tfoot>
    </table>
</div>

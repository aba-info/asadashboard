<!DOCTYPE html>
<html>

<head>
    <title>Timesheets Export</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1>Timesheets Export</h1>
    @php
        //TODO: unify this function
        $totalHours = 0;
        $totalMinutes = 0;
    @endphp

    <table>
        <thead>
            <tr>
                <th>User Id</th>
                <th>Project</th>
                <th>Phase</th>
                <th>Details</th>
                <th>Task Start Date</th>
                <th>Time Spent</th>
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
                @php
                    use App\Helpers\TimesheetsHelper;
                @endphp
                <th>{{ TimesheetsHelper::calculateTime($totalHours, $totalMinutes) }}</th>
                <th colspan="3"></th>
            </tr>
        </tfoot>
    </table>
</body>

</html>

<div class="table-responsive">
    <table class="table" id="timesheets-table">
        <thead>
            <tr class="projects__header">
                <th>Project Name</th>
                <th>Completion</th>
                <th>Payment</th>
                <th>Total time Spent</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($groupedTimesheets as $group => $phases)
            <?php
            $hours = 0;
            $minutes = 0;
            
            foreach ($phases as $phase) {
                foreach ($phase as $timesheet) {
                        $hours += $timesheet->time_spent_hours;
                        $minutes += $timesheet->time_spent_minutes;
                }
            }         

            $project = TimesheetsHelper::projectByName($projects, $group);

            ?>
            <tr class="projects__timesheets__header">
                <td>{{ $group }}</td>
                <td>{{ !empty($project[1]) ? $project[1] : '0' }}%</td>
                <td>{{ !empty($project[2]) ? $project[2] : '' }}</td>
                <td>
                    <p>{{ TimesheetsHelper::calculateTime($hours, $minutes) }}</p>
                </td>
                <td width="120">
                    {!! Form::open(['route' => ['timesheets.destroy', $group], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="#" class='btn btn-default btn-xs action-show-project' data-project="<?php echo $group; ?>">
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('projects.create') }}?project=<?php echo  $group; ?>" class='btn btn-default btn-xs'>
                            <i class="far fa-edit"></i>
                        </a>
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
            @foreach($phases as $phase => $timesheets)
            <tr class="projects__phase projects__phase__header" data-project="<?php echo $group; ?>">
                <td>Phase name</td>
                <td>User</td>
                <td>Time Spent</td>
                <td>Completion</td>
                <td>Action</td>
            </tr>
                <?php $i = 0; ?>
                @foreach($timesheets as $timesheet)
                <tr class="projects__phase" data-project="<?php echo $group; ?>">
                    <td>
                        <?php if($i == 0) { ?>
                            Phase: {{ $phase }}
                        <?php } ?>
                    </td>
                    <td>{{ $users[$timesheet->user_id] }}</td>
                    <td>{{ $timesheet->time_spent_hours }}:{{ $timesheet->time_spent_minutes }}</td>
                    <td><?php 
                    echo !empty($phasesCompletions[$group][$phase]) ? $phasesCompletions[$group][$phase] : 0;
                     ?>%</td>                    
                    <td>
                        <a href="{{ route('phases.edit', ['phase' => 0]) }}?project=<?php echo  urlencode($group); ?>&phase=<?php echo  urlencode($phase); ?>" class='btn btn-default btn-xs'>
                            <i class="far fa-edit"></i>
                        </a>
                    </td>
                    <?php $i++; ?>
                    @endforeach
                </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>
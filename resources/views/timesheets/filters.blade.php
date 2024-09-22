<div class="card">
    <div class="card-header">
        <h3 class="card-title"><strong>Filters</strong></h3>
    </div>
    <div class="card-body p-0">
        <form action="{{ route('timesheets.index') }}" method="GET" id="timesheets-filter">
            <div class="card-body">
                <div class="row">
                    <!-- Filter by Project -->
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="project_search">Filter by Project:</label>
                            {!! Form::text('project_search', request('project_search') != null ? request('project_search') : null, ['class' => 'form-control', 'id' => 'project-autocomplete', 'placeholder' => 'Search for a project']) !!}
                            {!! Form::hidden('project-id', request('project_search') != null ? request('project_search') : null, ['id' => 'project-id']) !!}
                            {!! Form::hidden('project_ids', implode(',', $projects), ['id' => 'project-ids']) !!}
                        </div>
                    </div>

                    <!-- Filter by Project -->
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="phase_id">Filter by Phase:</label>
                            <select name="phase_id" id="phase_id" class="form-control">
                                <option value="">All phases</option>
                                <?php
                                $selectedPhaseId = !empty($_GET['phase_id']) ? trim($_GET['phase_id']) : null;
                                $phases = !empty($phases) ? $phases : $phasesNames;

                                foreach ($phases as $value) {
                                    $cleanedValue = strtolower(preg_replace('/\s+/', '', $value));
                                    $cleanedSelectedValue = strtolower(preg_replace('/\s+/', '', $selectedPhaseId));
                                    $selected = $cleanedValue === $cleanedSelectedValue ? 'selected' : '';

                                    echo "<option value=\"$value\" $selected>$value</option>";
                                }
                                ?>
                            </select>
                            <div class="wip">
                                <select name="phases_temp" id="phases_temp" class="form-control">
                                    <option value="">All phases</option>
                                    <?php
                                    $selectedPhaseId = !empty($_GET['phase_id']) ? trim($_GET['phase_id']) : null;
                                    $phases = !empty($phases) ? $phases : $phasesNames;

                                    foreach ($phases as $value) {
                                        $cleanedValue = strtolower(preg_replace('/\s+/', '', $value));
                                        $cleanedSelectedValue = strtolower(preg_replace('/\s+/', '', $selectedPhaseId));
                                        $selected = $cleanedValue === $cleanedSelectedValue ? 'selected' : '';

                                        echo "<option value=\"$value\" $selected>$value</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="wip"><a href="{{ route('phases.create') }}" data-url="{{ route('phases.create') }}" class="create__phase" target="_blank" rel="noopener noreferrer">Create a new Phase</a> <br> <small>after creating a new phase, please refresh this page.</small></div>
                        </div>
                    </div>

                    <!-- Filter by User -->
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="user">Filter by User:</label>
                            <select name="user" class="form-control">
                                <option value="all">All Users</option>
                                @foreach($users as $userId => $userName)
                                <option value="{{ $userId }}" {{ request('user', auth()->user()->id) == $userId ? 'selected' : '' }}>{{ $userName }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Filter by Details -->
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="details">Filter by Details:</label>
                            <input type="text" name="details" class="form-control" value="{{ request('details') }}">
                        </div>
                    </div>

                    <!-- Filter by Date Range (Start Date) -->
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="start_date">Start Date:</label>
                            <input type="date" name="start_date" class="form-control" value="{{ !empty(request('start_date')) ? request('start_date') : now()->subMonths(1)->format('Y-m-d') }}">
                        </div>
                    </div>

                    <!-- Filter by Date Range (End Date) -->
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="end_date">End Date:</label>
                            <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button for Filtering -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Apply Filters</button>
                <a href="{{ route('timesheets.index') }}" class="btn btn-secondary">Clear Filters</a>
            </div>
        </form>
    </div>
</div>
<div class="table-responsive">
    <table class="table" id="projects-table">
        <thead>
        <tr>
            <th>Name</th>
        </tr>
        </thead>
        <tbody>
        @foreach($projects as $project)
            @if($project!="PROJECTS")
            <tr>
                <td>{{ $project }}</td>
                <td width="120">
                   
                </td>
            </tr>
            @endif
        @endforeach
        </tbody>
    </table>
</div>

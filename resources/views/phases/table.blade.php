<div class="table-responsive">
    <table class="table" id="phases-table">
        <thead>
        <tr>
            <th>Name</th>
        <th>Details</th>
        <th>Amounts</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($phases as $phase)
            <tr>
                <td>{{ $phase->name }}</td>
            <td>{{ $phase->details }}</td>
            <td>{{ $phase->amounts }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['phases.destroy', $phase->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('phases.show', [$phase->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('phases.edit', [$phase->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-edit"></i>
                        </a>
                        {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

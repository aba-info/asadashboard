@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-12">
            <section class="content-header">
                <h1>
                    User
                </h1>
                <small>Leave password empty in case you don't need to change it.</small>
            </section>
        </div>
    </div>
</div>
<div class="content px-3">
    @include('adminlte-templates::common.errors')
    <div class="card">
        {!! Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'patch']) !!}
        <div class="card-body">
            <div class="row">
                @include('users.fields')
            </div>
        </div>
        <div class="card-footer">
            <!-- Submit Field -->
            <div class="form-group col-sm-12">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{!! route('users.index') !!}" class="btn btn-default">Cancel</a>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection
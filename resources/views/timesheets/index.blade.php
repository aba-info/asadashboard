@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Timesheets</h1>
            </div>
            <div class="col-sm-6 content-header-actions">
                <a class="btn btn-primary float-right" href="{{ route('timesheets.create') }}">
                    Add New
                </a>
                @php
                $currentQueryParams = request()->query();

                @endphp

                <a class="btn btn-secondary float-right" href="{{ route('export.timesheets.csv', $currentQueryParams ) }}">
                    Export to CSV
                </a>
                <a class="btn btn-secondary float-right" href="{{ route('export.timesheets.pdf', $currentQueryParams ) }}">
                    Export to PDF
                </a>
            </div>
        </div>
    </div>
</section>

<div class="content px-3">

    @include('flash::message')

    <div class="clearfix"></div>

    @include('timesheets.filters')

    <div class="card">
        <div class="card-body p-0">

            @include('timesheets.table')

            <div class="card-footer clearfix">
                <div class="float-right">

                </div>
            </div>
        </div>

    </div>
</div>

@endsection
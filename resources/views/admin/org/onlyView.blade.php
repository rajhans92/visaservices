@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.org.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($users) > 0 ? 'datatable' : '' }}">
                <thead>
                    <tr>

                        <th>Id</th>
                        <th>@lang('global.exam-category.fields.name')</th>
                    </tr>
                </thead>

                <tbody>
                    @if (count($users) > 0)
                        @foreach ($users as $data)
                            <tr >

                                <td>{{$data->id}}</td>
                                <td>{{ $data->first_name }} {{ $data->last_name }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="2">@lang('global.app_no_entries_in_table')</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop

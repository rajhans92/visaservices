@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.language.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($language) > 0 ? 'datatable' : '' }}">
                <thead>
                    <tr>

                        <th>Id</th>
                        <th>@lang('global.language.fields.name')</th>
                    </tr>
                </thead>

                <tbody>
                    @if (count($language) > 0)
                        @foreach ($language as $data)
                            <tr >

                                <td>{{$data->id}}</td>
                                <td>{{ $data->title }}</td>
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

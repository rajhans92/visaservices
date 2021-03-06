@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.exam-schedule.title')</h3>
    @can('exam_schedule_create')
    <p>
        <a href="{{ route('admin.exam-schedule.create') }}" class="btn btn-success">@lang('global.app_add_new')</a>

    </p>
    @endcan



    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($exam_schedule) > 0 ? 'datatable' : '' }} @can('exam_schedule_delete') dt-select @endcan">
                <thead>
                    <tr>
                        @can('exam_schedule_delete')
                            <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        @endcan
                        <th>@lang('global.exam-schedule.fields.display')</th>
                        <th>@lang('global.exam-schedule.fields.name')</th>
                        <th>@lang('global.exam-schedule.fields.date')</th>
                        <th>@lang('global.exam-schedule.fields.result_date')</th>
                        <th>@lang('global.exam-schedule.fields.limit')</th>
                        <th>@lang('global.exam-schedule.fields.sponsored')</th>
                        <th>@lang('global.exam-schedule.fields.status')</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>

                <tbody>
                    @if (count($exam_schedule) > 0)
                        @foreach ($exam_schedule as $exam)
                            <tr data-entry-id="{{ $exam->id }}">
                                @can('exam_schedule_delete')
                                    <td></td>
                                @endcan

                                <td>{{ $exam->exam_display_name }}</td>
                                <td>{{ $exam->exam_name }}</td>
                                <td>{{ date('d/m/Y',strtotime( $exam->start_date)) }} to {{date('d/m/Y',strtotime( $exam->end_date))}}</td>
                                <td>{{ date('d/m/Y',strtotime($exam->result_date)) }}</td>
                                <td>{{ $exam->user_limit }}</td>
                                <td>{{ $exam->first_name }} {{ $exam->last_name && $exam->last_name != null ? $exam->last_name : "" }}</td>
                                <td>{{ $exam->status }}</td>
                                <td>
                                    @can('exam_schedule_view')
                                    <a href="{{ route('admin.exam-schedule.show',[$exam->id]) }}" class="btn btn-xs btn-primary">@lang('global.app_view')</a>
                                    @endcan
                                    @if(strtotime(date("Y-m-d h:i:s")) < strtotime($exam->start_date))
                                        @can('exam_schedule_edit')
                                          @if(strtolower($exam->status) != "active")
                                            <a href="{{ route('admin.exam-schedule.edit',[$exam->id]) }}" class="btn btn-xs btn-info">@lang('global.app_edit')</a>
                                          @endif
                                        {!! Form::open(array(
                                            'style' => 'display: inline-block;',
                                            'method' => 'POST',
                                            'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."')",
                                            'route' => 'admin.exam-schedule.update_status')) !!}
                                        {!! Form::hidden('exam_schedule_id',$exam->id  ) !!}
                                        {!! Form::hidden('status',(strtolower($exam->status) == "active" ? 1 : 2)  ) !!}
                                        {!! Form::submit(strtolower($exam->status) == "active" ? "Inactived" : "Activated", array('class' => strtolower($exam->status) == "active" ? "btn btn-xs btn-warning" : "btn btn-xs btn-success")) !!}
                                        {!! Form::close() !!}

                                        @endcan
                                        @if(strtolower($exam->status) != "active")
                                          @can('exam_schedule_delete')
                                          {!! Form::open(array(
                                              'style' => 'display: inline-block;',
                                              'method' => 'DELETE',
                                              'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."')",
                                              'route' => ['admin.exam-schedule.destroy', $exam->id])) !!}
                                          {!! Form::submit(trans('global.app_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                          {!! Form::close() !!}
                                          @endcan
                                        @endif
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="9">@lang('global.app_no_entries_in_table')</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop

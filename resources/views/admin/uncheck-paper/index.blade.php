@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.uncheck-paper.submit_Paper_title')</h3>

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
                        <th>@lang('global.uncheck-paper.fields.display')</th>
                        <th>@lang('global.uncheck-paper.fields.name')</th>
                        <th>@lang('global.uncheck-paper.fields.date')</th>
                        <th>@lang('global.uncheck-paper.fields.result_date')</th>
                        <th>@lang('global.uncheck-paper.fields.paper')</th>
                        <th>@lang('global.uncheck-paper.fields.student_count')</th>
                        <th>@lang('global.uncheck-paper.fields.sponsored')</th>
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
                                <td>{{ $exam->total_paper_checked }}</td>
                                <td>{{ $exam->total_paper_count}}</td>
                                <td>{{ $exam->first_name }} {{ $exam->last_name && $exam->last_name != null ? $exam->last_name : "" }}</td>
                                <td>
                                    @can('exam_schedule_view')
                                    <a href="{{ route('admin.uncheck-paper.show',[$exam->id]) }}" class="btn btn-xs btn-primary">Manual Check</a><br>
                                    @endcan
                                    @can('uncheck_paper_checked')
                                        {!! Form::open(array(
                                            'style' => 'display: inline-block;',
                                            'method' => 'POST',
                                            'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                            'route' => 'admin.uncheck-paper.autocheck_paper')) !!}
                                        {!! Form::hidden('exam_schedule_id', $exam->id  ) !!}
                                        {!! Form::hidden('exam_id', $exam->exam_id  ) !!}
                                        {!! Form::submit("Autocheck", array('class' => "btn btn-xs btn-success")) !!}
                                        {!! Form::close() !!}
                                        <br>
                                    @endcan
                                    @can('uncheck_paper_checked')
                                    @if($exam->total_paper_checked == $exam->total_paper_count)
                                        {!! Form::open(array(
                                            'style' => 'display: inline-block;',
                                            'method' => 'POST',
                                            'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                            'route' => 'admin.uncheck-paper.move_to_result')) !!}
                                        {!! Form::hidden('is_result', 1) !!}
                                        {!! Form::hidden('exam_schedule_id', $exam->id  ) !!}
                                        {!! Form::submit("Move To Result", array('class' => "btn btn-xs btn-warning")) !!}
                                        {!! Form::close() !!}
                                    @endif
                                    @endcan
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

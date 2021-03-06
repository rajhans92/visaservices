@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.exam-result.title')</h3>

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
                        <th>@lang('global.exam-result.fields.display')</th>
                        <th>@lang('global.exam-result.fields.name')</th>
                        <th>@lang('global.exam-result.fields.result_date')</th>
                        <th>@lang('global.exam-result.fields.winner')</th>
                        <th>@lang('global.exam-result.fields.prize')</th>
                        <th>@lang('global.exam-result.fields.student_count')</th>
                        <th>@lang('global.exam-result.fields.sponsored')</th>
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
                                <td>{{ date('d/m/Y',strtotime($exam->result_date)) }}</td>
                                <td>10</td>
                                <td>100</td>
                                <td>{{ $total_paper_count[$exam->id]}}</td>
                                <td>{{ $exam->first_name }} {{ $exam->last_name && $exam->last_name != null ? $exam->last_name : "" }}</td>
                                <td>
                                    @can('exam_result_view')
                                    <a href="{{ route('admin.exam-result.show',[$exam->id]) }}" class="btn btn-xs btn-primary">@lang('global.app_view') Papers</a>
                                    <a href="{{ url('/admin/exam-result/winner-list/'.$exam->id) }}" class="btn btn-xs btn-primary">View Winners</a>
                                    @endcan
                                    @can('uncheck_paper_checked')
                                        {!! Form::open(array(
                                            'style' => 'display: inline-block;',
                                            'method' => 'POST',
                                            'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                            'route' => 'admin.exam-result.autowinner')) !!}
                                        {!! Form::hidden('exam_schedule_id', $exam->id  ) !!}
                                        {!! Form::hidden('exam_id', $exam->exam_id  ) !!}
                                        {!! Form::submit("Autowinner", array('class' => "btn btn-xs btn-success")) !!}
                                        {!! Form::close() !!}
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

@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.exam-result.winnertitle')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_list') &nbsp;&nbsp;&nbsp;<a href="{{ route('admin.exam-result.index') }}" class="btn btn-info">@lang('global.app_back_to_list')</a>
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($user_exam) > 0 ? 'datatable' : '' }}">
                <thead>
                    <tr>

                        <th>@lang('global.exam-result.fields.rank')</th>
                        <th>@lang('global.exam-result.fields.name')</th>
                        <th>@lang('global.exam-result.fields.wrongquestion')</th>
                        <th>@lang('global.exam-result.fields.question')</th>
                        <th>@lang('global.exam-result.fields.totalQuestion')</th>
                        <th>@lang('global.exam-result.fields.marks')</th>
                        <th>@lang('global.exam-result.fields.totalMarks')</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>

                <tbody>
                    @if (count($user_exam) > 0)
                        @foreach ($user_exam as $user)
                            <tr data-entry-id="{{ $user->id }}">

                                <td>{{$user->rank}}</td>
                                <td>{{ $user->first_name }} {{ $user->last_name && $user->last_name != null ? $user->last_name : "" }}</td>
                                <td>{{$user->wrong_ans}}</td>
                                <td>{{$user->correct_ans}}</td>
                                <td>{{$exam_schedule->total_questions}}</td>
                                <td>{{$user->marks_get}}</td>
                                <td>{{$exam_schedule->total_marks}}</td>
                                <td>

                                    @can('uncheck_paper_view')
                                    <a href="{{ url('admin/exam-result/show-paper/'.$user->exam_schedule_id.'/'.$exam_schedule->exam_id.'/'.$user->user_id) }}" class="btn btn-xs btn-primary">@lang('global.app_view') Questions</a>
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
            <p>&nbsp;</p>

            <a href="{{ route('admin.exam-result.index') }}" class="btn btn-default">@lang('global.app_back_to_list')</a>
        </div>
    </div>
@stop

@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.uncheck-paper.papertitle')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_list') &nbsp;&nbsp;<a href="{{ route('admin.uncheck-paper.index') }}" class="btn btn-info">@lang('global.app_back_to_list')</a>
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($user_exam) > 0 ? 'datatable' : '' }}">
                <thead>
                    <tr>

                        <th>@lang('global.uncheck-paper.fields.name')</th>
                        <th>@lang('global.uncheck-paper.fields.question')</th>
                        <th>Question Attempt</th>
                        <th>@lang('global.uncheck-paper.fields.totalQuestion')</th>
                        <th>@lang('global.uncheck-paper.fields.marks')</th>
                        <th>@lang('global.uncheck-paper.fields.totalMarks')</th>
                        <th>@lang('global.uncheck-paper.fields.isCheck')</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>

                <tbody>
                    @if (count($user_exam) > 0)
                        @foreach ($user_exam as $user)
                            <tr data-entry-id="{{ $user->id }}">

                                <td>{{ $user->first_name }} {{ $user->last_name && $user->last_name != null ? $user->last_name : "" }}</td>
                                <td>{{$user->question_checked}}</td>
                                <td>{{$user->question_attempt}}</td>
                                <td>{{$exam_schedule->total_questions}}</td>
                                <td>{{$user->marks_get}}</td>
                                <td>{{$exam_schedule->total_marks}}</td>
                                <td>{{$user->is_checked == 0 ? "No" : "Yes"}}</td>
                                <td>
                                    @can('uncheck_paper_edit')
                                    @if($user->is_checked == 0)
                                      <a href="{{ url('admin/uncheck-paper/paper/'.$user->exam_schedule_id.'/'.$exam_schedule->exam_id.'/'.$user->user_id) }}" class="btn btn-xs btn-warning">@lang('global.app_review')</a>
                                    @endif
                                    @endcan

                                    @can('uncheck_paper_view')
                                    <a href="{{ url('admin/uncheck-paper/show-paper/'.$user->exam_schedule_id.'/'.$exam_schedule->exam_id.'/'.$user->user_id) }}" class="btn btn-xs btn-primary">@lang('global.app_view')</a>
                                    @endcan

                                    @can('uncheck_paper_checked')
                                    @if($user->question_checked == $user->question_attempt)
                                        {!! Form::open(array(
                                            'style' => 'display: inline-block;',
                                            'method' => 'POST',
                                            'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                            'route' => 'admin.uncheck-paper.is_checked')) !!}
                                        {!! Form::hidden('userExamId',$user->id  ) !!}
                                        {!! Form::hidden('is_checked',(strtolower($user->is_checked) == 0 ? 1 : 0)  ) !!}
                                        {!! Form::hidden('exam_schedule_id', $user->exam_schedule_id  ) !!}
                                        {!! Form::hidden('user_id', $user->user_id) !!}
                                        {!! Form::submit(strtolower($user->is_checked) == 0 ? "Checked" : "Unchecked", array('class' => strtolower($user->is_checked) == 0 ? "btn btn-xs btn-success" : "btn btn-xs btn-danger")) !!}
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
            <p>&nbsp;</p>


        </div>
    </div>
@stop

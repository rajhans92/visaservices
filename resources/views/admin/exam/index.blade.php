@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.exam.title')</h3>
    @can('exam_create')
    <p>
        <a href="{{ route('admin.exam.create') }}" class="btn btn-success">@lang('global.app_add_new')</a>
        <a href="{{ url('/admin/exam-excel/upload') }}" class="btn btn-primary">@lang('global.exam.upload')</a>

    </p>
    @endcan



    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($exams) > 0 ? 'datatable' : '' }} @can('exam_delete') dt-select @endcan">
                <thead>
                    <tr>
                        @can('exam_delete')
                            <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        @endcan
                        <th>@lang('global.exam.fields.name')</th>
                        <th>@lang('global.exam.fields.category')</th>
                        <th>@lang('global.exam.fields.organization')</th>
                        <th>@lang('global.exam.fields.teacher')</th>
                        <th>@lang('global.exam.fields.status')</th>
                        <th>Exam Complete</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>

                <tbody>
                    @if (count($exams) > 0)
                        @foreach ($exams as $exam)
                            <tr data-entry-id="{{ $exam->id }}">
                                @can('exam_delete')
                                    <td></td>
                                @endcan

                                <td>{{ $exam->exam_name }}</td>
                                <td>{{ $exam_category[$exam->exam_category_id] }}</td>
                                <td>{{ array_key_exists($exam->organization_id,$orgObj) ? $orgObj[$exam->organization_id] : $orgObj[0] }}</td>
                                <td>{{ array_key_exists($exam->teacher_id,$teacherObj) ? $teacherObj[$exam->teacher_id] : $teacherObj[0]  }}</td>
                                <td>{{ $exam->exam_status }}</td>
                                <td>
                                  Section :- {!!$exam->examCompleteStatus['exam_section']['status'] ? '<a href="javascript:void(0);" class="btn btn-xs btn-success">Completed</a>' : '<a href="javascript:void(0);" class="btn btn-xs btn-danger">Incompleted</a>'!!}<br>
                                  Question :- {!!$exam->examCompleteStatus['section_question']['status'] ? '<a href="javascript:void(0);" class="btn btn-xs btn-success">Completed</a>' : '<a href="javascript:void(0);" class="btn btn-xs btn-danger">Incompleted</a>'!!}<br>
                                  Question Detail :- {!!$exam->examCompleteStatus['question_detail']['status'] ? '<a href="javascript:void(0);" class="btn btn-xs btn-success">Completed</a>' : '<a href="javascript:void(0);" class="btn btn-xs btn-danger">Incompleted</a>'!!}<br>
                                  Question Option :- {!!$exam->examCompleteStatus['question_option']['status'] ? '<a href="javascript:void(0);" class="btn btn-xs btn-success">Completed</a>' : '<a href="javascript:void(0);" class="btn btn-xs btn-danger">Incompleted</a>'!!}<br>
                                </td>
                                <td>

                                    @if(!$exam->is_schedule)
                                        @if(strtolower($exam->exam_status) != "active")
                                          <a href="{{ route('admin.exam.edit',[$exam->id]) }}" class="btn btn-xs btn-info">Edit Step 1</a>
                                          <a href="{{ route('admin.exam.showInstruction',[$exam->id]) }}" class="btn btn-xs btn-info">Edit Step 2</a>
                                          <a href="{{ route('admin.exam.showSection',[$exam->id]) }}" class="btn btn-xs btn-info">Edit Step 3</a>
                                          <br>
                                        @endif
                                        @can('exam_edit')
                                        {!! Form::open(array(
                                            'style' => 'display: inline-block;',
                                            'method' => 'POST',
                                            'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                            'route' => 'admin.exam.update_status')) !!}
                                        {!! Form::hidden('examId',$exam->id  ) !!}
                                        {!! Form::hidden('exam_status',(strtolower($exam->exam_status) == "active" ? 1 : 2)  ) !!}
                                        {!! Form::submit(strtolower($exam->exam_status) == "active" ? "Inactived" : "Activated", array('class' => strtolower($exam->exam_status) == "active" ? "btn btn-xs btn-warning" : "btn btn-xs btn-success")) !!}
                                        {!! Form::close() !!}

                                        @endcan
                                        @if(strtolower($exam->exam_status) != "active")
                                          @can('exam_delete')
                                          {!! Form::open(array(
                                              'style' => 'display: inline-block;',
                                              'method' => 'DELETE',
                                              'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                              'route' => ['admin.exam.destroy', $exam->id])) !!}
                                          {!! Form::submit(trans('global.app_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                          {!! Form::close() !!}
                                          @endcan
                                        @endif

                                    @endif
                                    @can('exam_view')
                                    <a href="{{ route('admin.exam.show',[$exam->id]) }}" class="btn btn-xs btn-primary">View Exam</a>
                                    @endcan
                                    @if($exam->is_schedule || strtolower($exam->exam_status) == "active")
                                        <a href="{{ route('admin.exam.showSection',[$exam->id]) }}" class="btn btn-xs btn-primary">View Section</a>
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

@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">Exam Section For {{$examDetail->exam_name}}</h3>
    @can('exam_create')
    <p>
      @if($is_active == 1)
        <a href="{{ route('admin.exam.addSection',[$exam_id]) }}" class="btn btn-success">Add Section</a>
      @endif
    </p>
    @endcan



    <div class="panel panel-default">
        <div class="panel-heading">
            Step 3 - Add Section &nbsp; <a href="{{ url('/admin/exam/instructions/'.$exam_id) }}" class="btn btn-default">Back to previous step</a> &nbsp; <a href="{{ route('admin.exam.index') }}" class="btn btn-primary">Back to exam list</a>
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($exam_section) > 0 ? 'datatable' : '' }} @can('exam_delete') dt-select @endcan">
                <thead>
                    <tr>
                        @can('exam_delete')
                            <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        @endcan
                        <th>Section Name</th>
                        <th>Section Duration</th>
                        <th>Total Marks</th>
                        <th>Cutoff</th>
                        <th>Total Questions</th>
                        <th>Is Negative Marking</th>
                        <th>Negative Marking No</th>
                        <th>Exam Complete</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>

                <tbody>
                    @if (count($exam_section) > 0)
                        @foreach ($exam_section as $exam)
                            <tr data-entry-id="{{ $exam->id }}">
                                @can('exam_delete')
                                    <td></td>
                                @endcan

                                <td>{{ $exam->section_name }}</td>
                                <td>{{ $exam->section_duration }}</td>
                                <td>{{ $exam->total_marks }}</td>
                                <td>{{ $exam->cutoff }}</td>
                                <td>{{ $exam->total_questions }}</td>
                                <td>{{ $exam->is_negative_marking == 1 ? "Yes" : "No" }}</td>
                                <td>{{ $exam->negative_marking_no }}</td>
                                <td>
                                  Question :- {!!$exam->examCompleteStatus['section_question']['status'] ? '<a href="javascript:void(0);" class="btn btn-xs btn-success">Completed</a>' : '<a href="javascript:void(0);" class="btn btn-xs btn-danger">Incompleted</a>'!!}<br>
                                  Question Detail :- {!!$exam->examCompleteStatus['question_detail']['status'] ? '<a href="javascript:void(0);" class="btn btn-xs btn-success">Completed</a>' : '<a href="javascript:void(0);" class="btn btn-xs btn-danger">Incompleted</a>'!!}<br>
                                  Question Option :- {!!$exam->examCompleteStatus['question_option']['status'] ? '<a href="javascript:void(0);" class="btn btn-xs btn-success">Completed</a>' : '<a href="javascript:void(0);" class="btn btn-xs btn-danger">Incompleted</a>'!!}<br>
                                </td>
                                <td>
                                    @can('exam_view')
                                    <a href="{{ route('admin.exam.showQuestion',[$exam->exam_id,$exam->id]) }}" class="btn btn-xs btn-primary">Questions</a>
                                    @endcan

                                    @if($is_active == 1)
                                        @can('exam_edit')
                                        <a href="{{ route('admin.exam.editSection',[$exam->exam_id,$exam->id]) }}" class="btn btn-xs btn-info">@lang('global.app_edit')</a>
                                        @endcan

                                        @can('exam_delete')
                                        {!! Form::open(array(
                                            'style' => 'display: inline-block;',
                                            'method' => 'DELETE',
                                            'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                            'route' => ['admin.exam.destroySection', $exam->id])) !!}
                                        {!! Form::submit(trans('global.app_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                        {!! Form::close() !!}
                                        @endcan
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

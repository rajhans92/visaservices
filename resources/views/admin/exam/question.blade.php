@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">Questions For {{$examSection->section_name}}</h3>
    @can('exam_create')
    <p>
      @if($is_active == 1)
        <a href="{{ route('admin.exam.addQuestion',[$exam_id,$section_id]) }}" class="btn btn-success">Add Question</a>
        <a href="{{ route('admin.exam.questionSequence',[$exam_id,$section_id]) }}" class="btn btn-warning">Maintain Sequence</a>
      @endif
    </p>
    @endcan



    <div class="panel panel-default">
        <div class="panel-heading">
            Step 4 - Add Question &nbsp; <a href="{{ url('/admin/exam/section/'.$exam_id) }}" class="btn btn-default">Back to previous step</a> &nbsp; <a href="{{ route('admin.exam.index') }}" class="btn btn-primary">Back to exam list</a>
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($examQuestions) > 0 ? 'datatable' : '' }} @can('exam_delete') dt-select @endcan">
                <thead>
                    <tr>
                        @can('exam_delete')
                            <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        @endcan
                        <th>Question Sequence</th>
                        <th>Question Detail</th>
                        <th>Question Type</th>
                        <th>Question Marks</th>
                        <th>Question Duration</th>
                        <th>Exam Complete</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>

                <tbody>
                    @if (count($examQuestions) > 0)
                        @foreach ($examQuestions as $exam)
                            <tr data-entry-id="{{ $exam->id }}">
                                @can('exam_delete')
                                    <td></td>
                                @endcan

                                <td>{{ $exam->question_sequence }}</td>
                                <td>{!! isset($questionDetail[$exam->id]) ? substr(strip_tags($questionDetail[$exam->id]),0,10) : "" !!} ...</td>
                                <td>{{ array_key_exists($exam->question_type_id,$questionType) ? $questionType[$exam->question_type_id] : $questionType[0] }}</td>
                                <td>{{ $exam->question_marks }}</td>
                                <td>{{ $exam->question_duration }}</td>
                                <td style="width: 201px;">
                                  Question Detail :- {!!$exam->examCompleteStatus['question_detail']['status'] ? '<a href="javascript:void(0);" class="btn btn-xs btn-success">Completed</a>' : '<a href="javascript:void(0);" class="btn btn-xs btn-danger">Incompleted</a>'!!}<br>
                                  @if($exam->question_type_id == 2)
                                    Question Option :- {!!$exam->examCompleteStatus['question_option']['status'] ? '<a href="javascript:void(0);" class="btn btn-xs btn-success">Completed</a>' : '<a href="javascript:void(0);" class="btn btn-xs btn-danger">Incompleted</a>'!!}<br>
                                  @endIf

                                </td>

                                <td>
                                  @if($is_active == 1)
                                    @can('exam_edit')
                                    <a href="{{ route('admin.exam.editQuestion',[$exam_id,$section_id,$exam->id]) }}" class="btn btn-xs btn-info">Edit Question</a>
                                    @if($exam->question_type_id == 2)
                                      <a href="{{ route('admin.exam.editOption',[$exam_id,$section_id,$exam->id]) }}" class="btn btn-xs btn-primary">Edit Options</a>
                                    @endIf
                                    @endcan

                                    @can('exam_delete')
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                        'route' => ['admin.exam.destroyQuestion', $exam->id])) !!}
                                    {!! Form::submit(trans('global.app_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                  @else
                                    <a href="{{ route('admin.exam.viewQuestion',[$exam_id,$section_id,$exam->id]) }}" class="btn btn-xs btn-primary">View</a>
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

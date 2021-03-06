@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.exam.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_view') &nbsp;&nbsp;&nbsp; <a href="{{ route('admin.exam.index') }}" class="btn btn-primary">@lang('global.app_back_to_list')</a>

        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>Exam Logo</th>
                            <td>
                              @if($exam->image_name != "")
                                <img src="{{ env('IMG_URL') }}/img/exam/{{$exam->id}}/{{$exam->image_name }}" onerror="this.src='{{ env('IMG_URL') }}/img/exam-default.jpg'" id="image_name_show" width="100px" height="100px">
                              @else
                                NA
                              @endif

                            </td>
                            <th>Exam File</th>
                            <td>
                              @if($exam->file_name != "")
                                <a href="{{ env('IMG_URL') }}/img/exam/{{$exam->id}}/{{$exam->file_name }}" target="_blank">Click to view Exam file</a>
                              @else
                                NA
                              @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Exam Name</th>
                            <td>{{ $exam->exam_name }}</td>
                            <th>Video Link</th>
                            <td>{{ $exam->video_link }}</td>

                        </tr>
                        <tr>
                            <th>Organization</th>
                            <td>{{ $orgObj[$exam->organization_id] }}</td>
                            <th>Teacher</th>
                            <td>{{ $teacherObj[$exam->teacher_id] }}</td>
                        </tr>
                        <tr>
                            <th>Exam Status</th>
                            <td>{{ $exam->status }}</td>
                            <th>Exam Category</th>
                            <td>{{ $exam->exam_category}}</td>

                        </tr>
                        <tr>
                            <th>Exam Duration</th>
                            <td>{{ $exam->exam_duration }}</td>

                            <th>Total Questions</th>
                            <td>{{ $exam->total_questions }}</td>

                        </tr>
                        <tr>
                            <th>Total Marks</th>
                            <td>{{ $exam->total_marks }}</td>

                            <th>Passing Marks</th>
                            <td>{{ $exam->passing_marks }}</td>

                        </tr>
                        <tr>
                            <th>Is Negative Marking</th>
                            <td>{{ $exam->is_negative_marking ? "Yes" : "No"}}</td>

                            <th>Negative Marking No</th>
                            <td>{{ $exam->negative_marking_no }}</td>
                        </tr>
                        <tr>
                            <th>Questions Type</th>
                            <td>{{ $questionsType[$exam->questions_type] }}</td>

                            <th>Question Submit Type</th>
                            <td>{{ $submitType[$exam->submit_type] }}</td>
                        </tr>
                        <tr>
                            <th >Exam Languages</th>
                            <td colspan="3">
                              {{$examLang}}
                            </td>
                        </tr>
                        @foreach($examInstruction as $key => $val)
                          <tr>
                              <th>Exam instructions ({{$val->title}})</th>
                              <td colspan="3">
                                {!! $val->exam_note !!}
                              </td>
                          </tr>
                        @endforeach
                    </table>
                </div>
            </div><!-- Nav tabs -->
<!-- <ul class="nav nav-tabs" role="tablist">

<li role="presentation" class="active"><a href="#courses" aria-controls="courses" role="tab" data-toggle="tab">Courses</a></li>
</ul> -->

<!-- Tab panes -->
<!-- <div class="tab-content">

<div role="tabpanel" class="tab-pane active" id="courses">

</div>
</div> -->

            <p>&nbsp;</p>

        </div>
    </div>
@stop

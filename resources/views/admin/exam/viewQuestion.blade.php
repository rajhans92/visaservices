@extends('layouts.app')

@section('content')
    <h3 class="page-title">Question</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_view') &nbsp;&nbsp;&nbsp;<a href="{{ route('admin.exam.showQuestion',[$exam_id,$section_id]) }}" class="btn btn-primary">Back</a>

        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>Question Type</th>
                            <td>
                              {{$questionType[$examQuestion->question_type_id]}}
                            </td>
                            <th>Submit Type</th>
                            <td>
                              {{$questionSubmitType[$examQuestion->answer_type_id]}}
                            </td>
                        </tr>
                        <tr>
                            <th>Question Marks</th>
                            <td>{{ $examQuestion->question_marks }}</td>
                            <th>Question Duration</th>
                            <td>{{ $examQuestion->question_duration }}</td>

                        </tr>
                    </table>
                </div>
            </div>
            @if($examDetails != "" && count($examDetails))
              @foreach($examDetails as $key => $val)
                <div class="row">
                    <div class="col-md-12">
                      <details>
                        <summary>Language {{$val->title}}</summary>
                        @if($val->paragraph_detail != "")
                          <p><b>Paragraph :-</b> {!! $val->paragraph_detail !!}</p>
                        @endif
                        @if($val->paragraph_file != "")
                          <p><a target="_blank" href="{{env('IMG_URL').'/img/exam/'.$exam_id.'/'.$section_id.'/'.$question_id.'/'.$val->paragraph_file}}" >View Current File</a></p>
                        @endif
                        @if($val->paragraph_image != "")
                          <p><img src="{{env('IMG_URL').'/img/exam/'.$exam_id.'/'.$section_id.'/'.$question_id.'/'.$val->paragraph_image}}" width="100px" height="100px" onerror="this.src='{{ env('IMG_URL') }}/img/exam-default.jpg'"></p>
                        @endif
                        <br>
                        <p><b>Question Detail :-</b> {!! $val->question_detail !!}</p>
                        @if($val->question_file != "")
                          <p><a target="_blank" href="{{env('IMG_URL').'/img/exam/'.$exam_id.'/'.$section_id.'/'.$question_id.'/'.$val->question_file}}" >View Current File</a></p>
                        @endif
                        @if($val->question_image != "")
                          <p><img src="{{env('IMG_URL').'/img/exam/'.$exam_id.'/'.$section_id.'/'.$question_id.'/'.$val->question_image}}" width="100px" height="100px" onerror="this.src='{{ env('IMG_URL') }}/img/exam-default.jpg'"></p>
                        @endif
                        @if($examQuestion->question_type_id == 2 && $val->options != "" && count($val->options))
                          @foreach($val->options as $optionVal)
                            <p><b>{{$optionVal->option_label}} :-</b> {{$optionVal->option_value}} </p>
                            @if($optionVal->option_image != "")
                              <p><img src="{{env('IMG_URL').'/img/exam/'.$exam_id.'/'.$section_id.'/'.$question_id.'/'.$optionVal->option_image}}" width="100px" height="100px" onerror="this.src='{{ env('IMG_URL') }}/img/exam-default.jpg'"></p>
                            @endif
                            <p><b>Is Option Correct :- </b>{{$optionVal->is_option_correct ? "Yes" : "No"}}</p>
                          @endforeach
                        @endif
                       <p><b> Answer :-</b>
                          {!! $val->answer_detail !!}
                       </p>
                      </details>
                    </div>
                </div>
              @endforeach
            @endif
        </div>
    </div>
@stop

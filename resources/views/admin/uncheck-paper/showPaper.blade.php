@extends('layouts.app')

@section('content')
    <h3 class="page-title">Show Paper</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_view') &nbsp;&nbsp;<a href="{{ route('admin.uncheck-paper.show',[$exam_schedule_id]) }}" class="btn btn-primary">@lang('global.app_back_to_list')</a>
        </div>

        <div class="panel-body">
          <div class="row">
            <div class="col-xs-3 form-group">
              <h4 style="font-size: 15px;"><b>Exam Name :-</b> {{$examDetail->exam_name}}</h4>
              <h4 style="font-size: 15px;"><b>User Name :-</b> {{$user_exam->first_name}} {{$user_exam->last_name}}</h4>
            </div>
            <div class="col-xs-3 form-group">
              <h4 style="font-size: 15px;"><b>Total Marks :-</b> {{$examDetail->total_marks}}</h4>
              <h4 style="font-size: 15px;"><b>Total Question :- </b>{{$examDetail->total_questions}}</h4>
              <h4 style="font-size: 15px;"><b>Attempt Question :- </b>{{$user_exam->attempt_questions}}</h4>
            </div>
            <div class="col-xs-3 form-group">
              <h4 style="font-size: 15px;"><b>Marks Get :-</b> {{$user_exam->marks_get}}</h4>
              <h4 style="font-size: 15px;"><b>Correct Answer :- </b>{{$user_exam->correct_ans}}</h4>
              <h4 style="font-size: 15px;"><b>Wrong Answer :- </b>{{$user_exam->wrong_ans}}</h4>
            </div>
            <div class="col-xs-3 form-group">
              <h4 style="font-size: 15px;"><b>Is Negative Marking:-</b> {{$examDetail->is_negative_marking ? "Yes" : "No"}}</h4>
              <h4 style="font-size: 15px;"><b>Negative Marking No :- </b> ( -{{$examDetail->negative_marking_no}})</h4>
              <h4 style="font-size: 15px;"><b>Passing Marks :- </b> {{$examDetail->passing_marks}}</h4>
            </div>
          </div>
          @if(count($show_papers_section_data))
            <div class="row">
              <div class="col-xs-12 form-group">
                <h3>Section Wise</h3>
                @foreach($show_papers_section_data as $section)
                <div class="row">
                  <div class="col-xs-3 form-group">
                    <h4 style="font-size: 15px;"><b>Section Name :-</b> {{$section['section_name']}}</h4>
                  </div>
                  <div class="col-xs-3 form-group">
                    <h4 style="font-size: 15px;"><b>Total Marks :-</b> {{$section['total_marks']}}</h4>
                    <h4 style="font-size: 15px;"><b>Total Question :- </b>{{$section['total_questions']}}</h4>
                    <h4 style="font-size: 15px;"><b>Attempt Question :- </b>{{$section['attempt_questions']}}</h4>
                  </div>
                  <div class="col-xs-3 form-group">
                    <h4 style="font-size: 15px;"><b>Marks Get :-</b> {{$section['total_marks']}}</h4>
                    <h4 style="font-size: 15px;"><b>Correct Answer :- </b>{{$section['correct_ans']}}</h4>
                    <h4 style="font-size: 15px;"><b>Wrong Answer :- </b>{{$section['wrong_ans']}}</h4>
                  </div>
                  <div class="col-xs-3 form-group">
                    <h4 style="font-size: 15px;"><b>Is Negative Marking:-</b> {{$section['is_negative_marking'] ? "Yes" : "No"}}</h4>
                    <h4 style="font-size: 15px;"><b>Negative Marking No :- </b> ( -{{$section['negative_marking_no']}})</h4>
                    <h4 style="font-size: 15px;"><b>Section Wise Cutoff :- </b> {{$section['cutoff']}}</h4>
                  </div>
                </div>
                @endforeach
              </div>
            </div>
          @endif
          <div class="row">
            <div class="col-xs-12 form-group">
            {!! $htmlString !!}
            </div>
          </div>
        </div>



            <p>&nbsp;</p>


        </div>
    </div>
@stop
@section('javascript')

<script type="text/javascript">

    $(function(){
       $( "#tabs" ).tabs();
     });
 </script>

 @endsection

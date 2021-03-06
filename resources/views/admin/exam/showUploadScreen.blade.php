@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.exam.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.exam.upload')
        </div>

        <div class="panel-body">
            <div class="row">
              <div class="col-xs-4 form-group">
                <a href="{{ asset('/s3/exam-sheet.xlsx') }}" class="btn btn-primary">Download Formatted Sheet</a>
              </div>
              <div class="col-xs-4 form-group">

              </div>
            </div>
        </div>

        <div class="panel-body">
          <form action="{{route('admin.exam.bulk_upload')}}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
              <div class="col-xs-4 form-group">
              </div>
              <div class="col-xs-4 form-group">
                  <label for="file_name">Upload Excel File</label>
                  <input class="form-control" name="file_name" type="file" id="file_name">
                  @if($errors->has('file_name'))
                      <p class="help-block">
                          {{ $errors->first('file_name') }}
                      </p>
                  @endif
              </div>
            </div>
            <div class="row">
              <div class="col-xs-4 form-group">
              </div>
              <div class="col-xs-4 form-group">
                  <input class="form-control btn btn-danger" name="Submit" type="submit">
              </div>
            </div>
            <div class="row">
              <div class="col-xs-12 form-group">
              </div>
              <div class="col-xs-12 form-group">
              </div>
            </div>
            <div class="row">
              <div class="col-xs-12 form-group">
                <b>Note :- Instructions of create exams by using excel sheet. Follow the steps.</b>
              </div>
              <div class="col-xs-12 form-group">
                <ol type="1">
                  <li> Download the excel from mention button ("Upload Formatted Excel").</li>
                  <li> There is two sheet in this excel, first is exam sheet and second is question sheet. All field is required.</li>
                  <li>
                    Exam Field Detail
                      <ol type="A">
                        <li>"exam_no" field should be unique number.</li>
                        <li>"exam_name" field should be unique string because its exam name.</li>
                        <li>"exam_category_id" field should be number and by default value is 0. This field defined exam category. if you dont knowexam category ids <a href="{{url('/admin/list/exam-category')}}" target="_blank">Click Here</a></li>
                        <li>"exam_duration" field should be in number, this field use as exam time duration and it is minute.</li>
                        <li>"is_negative_marking" field should be "0" or "1", "0" use for not negative marking and "1" use for negative marking.</li>
                        <li>"negative_marking_no" is applicable when "is_negative_marking" value is "1" and its number field.</li>
                        <li>"video_link" field should be string.</li>
                        <li>"passing_marks" field should be number.</li>
                        <li>"exam_note" field should be string.</li>
                        <li>"organization_id" field should be number and by default value is 0. This field use for maping with organization. if you dont know your organization id <a href="{{url('/admin/list/org')}}" target="_blank">Click Here</a></li>
                        <li>"teacher_id" field should be number and by default value is 0. This field use for maping with teacher. if you dont know your teacher id <a href="{{url('/admin/list/teacher')}}" target="_blank">Click Here</a></li>
                      </ol>
                  </li>
                  <li>
                    Question Field Detail
                      <ol type="I">
                        <li>"exam_no" field should map  with exam sheet exam_no field. No of same exam_no represent no of question in that exam./li>
                        <li>"question_no" field should be number and present series of question.</li>
                        <li>"question_detail" field should be string.</li>
                        <li>"questiontype_id" field should be 1 or 2. 1 is represent as Subjective type question ans 2 is represent as objective type.</li>
                        <li>"marks" field should be number.</li>
                        <li>"time" field should be number.</li>
                        <li>"explained_answer" field should be text.</li>
                        <li>If you select "questiontype_id" is 1 then you dont need to fill "objective_question_*" but if you select 2 then you should set "objective_question_*". "objective_question_*" have A to F field like (objective_question_a,objective_question_b etc)</li>
                        <li>"objective_answer" set when "questiontype_id" is 2 and its number type. Only this value is acceptable.</li>
                          <ol type="A">
                                <li>1</li>
                                <li>2</li>
                                <li>3</li>
                                <li>4</li>
                                <li>5</li>
                                <li>6</li>
                          </ol>

                      </ol>
                  </li>
                </ol>
              </div>
            </div>
          </form>
        </div>
        <div class="panel-body">
          <div class="row">
            <div class="col-xs-4 form-group">
              <a href="{{ route('admin.exam.index') }}" class="btn btn-default">@lang('global.app_back_to_list')</a>
            </div>
          </div>
        </div>
    </div>
@stop

@section('javascript')

<script type="text/javascript">

$(function(){

});
</script>

@endsection

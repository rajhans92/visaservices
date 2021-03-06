@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.exam.title')</h3>
    {!! Form::model($exam, ['method' => 'PUT', 'route' => ['admin.exam.update', $exam->id] , 'files'=>true]) !!}
    <div class="panel panel-default">
        <div class="panel-heading">
            Step 1 - Edit Exam
        </div>
        <div class="panel-body">
          <input type="hidden" name = "eaxm_id" value="{{$exam->id}}">
            <div class="row">
                <div class="col-xs-4 form-group">
                    {!! Form::label('exam_name', 'Exam Name*', ['class' => 'control-label']) !!}
                    {!! Form::text('exam_name', old('exam_name'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('exam_name'))
                        <p class="help-block">
                            {{ $errors->first('exam_name') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-4 form-group">
                    {!! Form::label('language', 'Exam language*', ['class' => 'control-label']) !!}
                    <select class="form-control selectpicker multipleSelect" required multiple name="language[]" value="" data-live-search="true" >
                      @foreach($languages as $val)
                        <option value="{{$val->id}}" {{ in_array($val->id, $examLanguage) ? 'selected' : '' }}>{{$val->title}}</option>
                      @endforeach
                    </select>
                    @if($errors->has('language'))
                        <p class="help-block">
                            {{ $errors->first('language') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-4 form-group">
                      {!! Form::label('exam_category_id', 'Exam Category*', ['class' => 'control-label']) !!}
                      {!! Form::select('exam_category_id', $exam_category, old('exam_category_id') ? old('exam_category_id') : $exam->exam_category_id,['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                      <p class="help-block"></p>
                      @if($errors->has('exam_category_id'))
                          <p class="help-block">
                              {{ $errors->first('exam_category_id') }}
                          </p>
                      @endif
                  </div>
            </div>
            <div class="row">
              <div class="col-xs-4 form-group">
                    {!! Form::label('organization_id', 'Organization*', ['class' => 'control-label']) !!}
                    {!! Form::select('organization_id', $orgObj,old('organization_id') ? old('organization_id') : $exam->organization_id,['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('organization_id'))
                        <p class="help-block">
                            {{ $errors->first('organization_id') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-4 form-group">
                      {!! Form::label('teacher_id', 'Teacher*', ['class' => 'control-label']) !!}
                      {!! Form::select('teacher_id', $teacherObj, old('teacher_id') ? old('teacher_id') : $exam->teacher_id,['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                      <p class="help-block"></p>
                      @if($errors->has('teacher_id'))
                          <p class="help-block">
                              {{ $errors->first('teacher_id') }}
                          </p>
                      @endif
                  </div>
                  <div class="col-xs-4 form-group">
                      {!! Form::label('exam_duration', 'Exam Duration (In minutes)*', ['class' => 'control-label']) !!}
                      {!! Form::number('exam_duration', old('exam_duration'), ['class' => 'form-control', 'placeholder' => '']) !!}
                      <p class="help-block"></p>
                      @if($errors->has('exam_duration'))
                          <p class="help-block">
                              {{ $errors->first('exam_duration') }}
                          </p>
                      @endif
                  </div>
            </div>
            <div class="row">
                <div class="col-xs-4 form-group">
                    {!! Form::label('total_marks', 'Total Marks*', ['class' => 'control-label']) !!}
                    {!! Form::number('total_marks', old('total_marks'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('total_marks'))
                        <p class="help-block">
                            {{ $errors->first('total_marks') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-4 form-group">
                    {!! Form::label('passing_marks', 'Passing Marks*', ['class' => 'control-label']) !!}
                    {!! Form::number('passing_marks', old('passing_marks'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('passing_marks'))
                        <p class="help-block">
                            {{ $errors->first('passing_marks') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-4 form-group">
                    {!! Form::label('total_questions', 'Total Questions*', ['class' => 'control-label']) !!}
                    {!! Form::number('total_questions', old('total_questions'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('total_questions'))
                        <p class="help-block">
                            {{ $errors->first('total_questions') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
              <div class="col-xs-4 form-group">
                  {!! Form::label('video_link', 'Video Link*', ['class' => 'control-label']) !!}
                  {!! Form::text('video_link', old('video_link'), ['class' => 'form-control','placeholder' => '', 'required' => '']) !!}
                  <p class="help-block"></p>
                  @if($errors->has('video_link'))
                      <p class="help-block">
                          {{ $errors->first('video_link') }}
                      </p>
                  @endif
              </div>
                <div class="col-xs-4 form-group">
                  {!! Form::label('is_negative_marking', 'Negative Marking *', ['class' => 'control-label']) !!}
                  {!! Form::select('is_negative_marking', [0=>"No",1=>"Yes"],old('is_negative_marking') ? old('is_negative_marking') : $exam->is_negative_marking,['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                  <p class="help-block"></p>
                  @if($errors->has('is_negative_marking'))
                      <p class="help-block">
                          {{ $errors->first('is_negative_marking') }}
                      </p>
                  @endif
                </div>
                <div class="col-xs-4 form-group">
                  <?php
                    $data = ['class' => 'form-control', 'id'=>'negative_marking_no','placeholder' => '','disabled' => '', 'required' => '','step' => '0.01'];
                    if(isset($exam->is_negative_marking) && $exam->is_negative_marking == 1 || old('is_negative_marking')){
                      unset($data['disabled']);
                    }
                  ?>
                    {!! Form::label('negative_marking_no', 'Negative Marking No', ['class' => 'control-label']) !!}
                    {!! Form::number('negative_marking_no', $exam->is_negative_marking == 0 ? '' : old('negative_marking_no'), $data) !!}
                    <p class="help-block"></p>
                    @if($errors->has('negative_marking_no'))
                        <p class="help-block">
                            {{ $errors->first('negative_marking_no') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4 form-group">
                  {!! Form::label('questions_type', 'Questions Type*', ['class' => 'control-label']) !!}
                  {!! Form::select('questions_type', $questionType,old('questions_type') ? old('questions_type') : $exam->questions_type,['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                  <p class="help-block"></p>
                  @if($errors->has('questions_type'))
                      <p class="help-block">
                          {{ $errors->first('questions_type') }}
                      </p>
                  @endif
                </div>
                <div class="col-xs-4 form-group">
                  {!! Form::label('submit_type', 'Submit Type *', ['class' => 'control-label']) !!}
                  {!! Form::select('submit_type', $submitType,old('submit_type') ? old('submit_type') : $exam->submit_type,['class' => 'form-control', 'placeholder' => '','required' => '']) !!}
                  <p class="help-block"></p>
                  @if($errors->has('submit_type'))
                      <p class="help-block">
                          {{ $errors->first('submit_type') }}
                      </p>
                  @endif
                </div>
            </div>
            <div class="row">

              <div class="col-xs-4 form-group">
                <div class="row">
                  <div class="col-xs-12 form-group">
                    {!! Form::label('file_name','File')!!}
                    <div class="input-group date">
                      <input type="hidden"  name="file_delete" id="file_delete" value="0" />
                        <input type="file" class='form-control file_name' size="1" name="file_name" accept=".pdf" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-remove" id="file_remove" style="{{$exam->file_name != "" ? 'display:inline-block':'display:none'}};">
                            </span>
                            <span class="glyphicon glyphicon-upload" id="file_upload" style="{{$exam->file_name != "" ? 'display:none':'display:inline-block'}};">
                            </span>
                        </span>
                    </div>
                    <p class="help-block file_name_error">
                    </p>
                  </div>
                  <div class="col-xs-12 form-group">
                    @if($exam->file_name != "")
                      <a href="{{ env('IMG_URL') }}/img/exam/{{$exam->id}}/{{$exam->file_name }}" id="file_name_show" target="_blank">Click to view current file</a>
                    @endif
                  </div>
                </div>
              </div>
              <div class="col-xs-4 form-group">
                <div class="row">
                  <div class="col-xs-12 form-group">
                    {!! Form::label('image_name','Image')!!}
                    <div class="input-group date">
                        <input type="hidden"  name="image_delete" id="image_delete" value="0" />
                          <input type="file" class='form-control image_name' size="1" name="image_name" accept="image/jpg,image/png,image/jpeg,image/gif" />
                          <span class="input-group-addon">
                              <span class="glyphicon glyphicon-remove" id="image_remove" style="{{$exam->image_name != "" ? 'display:inline-block':'display:none'}};">
                              </span>
                              <span class="glyphicon glyphicon-upload" id="image_upload" style="{{$exam->image_name != "" ? 'display:none':'display:inline-block'}}">
                              </span>
                          </span>
                      </div>
                    <p class="help-block image_name_error">
                    </p>
                  </div>
                  <div class="col-xs-12 form-group">
                    @if($exam->image_name != "")
                      <img src="{{ env('IMG_URL') }}/img/exam/{{$exam->id}}/{{$exam->image_name }}" onerror="this.src='{{ env('IMG_URL') }}/img/exam-default.jpg'" id="image_name_show" width="100px" height="100px">
                    @else
                      <img src="" id="image_name_show"  style="display: none;"  width="100px" height="100px">
                    @endif
                  </div>
                </div>
              </div>
            </div>
        </div>

    </div>

    {!! Form::submit(trans('global.app_save_next'), ['class' => 'btn btn-danger']) !!}
    <a href="{{ route('admin.exam.index') }}" class="btn btn-primary">Cancel</a>

    {!! Form::close() !!}

@stop
@section('javascript')

<script type="text/javascript">

$(function(){
  $('.multipleSelect').selectpicker();
    $("#is_negative_marking").change(function(){
      if($(this).val() == 1){
        $( "#negative_marking_no" ).prop( "disabled", false );
      }else{
        $( "#negative_marking_no" ).val("");
        $( "#negative_marking_no" ).prop( "disabled", true );
      }
    });
    $("#organization_id").change(function(){
        var id = $(this).val();

        if(id.length != 0){
          $.ajax({
            url: "/admin/teacher/list/"+id,
            type: "GET",
            success: function(result){
              var data = JSON.parse(result);
              var option = "<option value='0'>NA</option>";
              for (var i in data) {
                option += "<option value='"+data[i]['id']+"'>"+data[i]['first_name']+" "+data[i]['last_name']+"</option>";
              }
              $("#teacher_id").html(option);
            }
          });
       }
    });
    function readURL(input,id) {
       if (input.files && input.files[0]) {
           var reader = new FileReader();
           reader.onload = function (e) {
               $(id).attr('src', e.target.result);
                $(id).show();
           }
           reader.readAsDataURL(input.files[0]);
       }
     }
     $("#image_upload").click(function(){
        $(".image_name").trigger('click');
     });
     $("#file_upload").click(function(){
        $(".file_name").trigger('click');
     });
     $("#image_remove").click(function(){
       var result = confirm("Want to delete?");
       if(result){
         $("#image_name_show").attr('src', "");
         $("#image_name_show").hide();
         $(".image_name").val('');
         $("#image_remove").hide();
         $("#image_upload").show();
         $("#image_delete").val(1);
       }
     });
     $("#file_remove").click(function(){
       var result = confirm("Want to delete?");
       if(result){
         $("#file_name_show").attr('href', "");
         $("#file_name_show").hide();
         $(".file_name").val('');

         $(".file_name").val('');
         $("#file_remove").hide();
         $("#file_upload").show();
         $("#file_delete").val(1);
       }
     });

     $(document).on("change",".image_name",function(){
         $(".image_name_error").html("");
         $("#image_remove").hide();
         $("#image_upload").show();
         if(!this.value || this.value.length == 0){
           $("#image_name_show").attr('src', "");
           $("#image_name_show").hide();
           return false;
         }
         var ext = this.value.match(/\.(.+)$/)[1];
         switch (ext.toLowerCase()) {
             case 'jpg':
             case 'jpeg':
             case 'png':
             case 'gif':
                 break;
             default:
                 this.value = '';
                 $(".image_name_error").html('This is not an allowed file type only jpg, png, jpeg and gif image type allow.');
                 return false;
         }
         var fileSize = this.files[0];
         var sizeInMb = fileSize.size/1024;
         var sizeLimit= 1024*1;
         if (sizeInMb > sizeLimit) {
           this.value = '';
           $(".image_name_error").html('File size must be less than 1mb.');
           return false;
         }
         readURL(this,"#image_name_show");
         $("#image_remove").show();
         $("#image_upload").hide();
     });
     $(document).on("change",".file_name",function(){
         $(".file_name_error").html("");
         $("#file_remove").hide();
         $("#file_upload").show();
         if(!this.value || this.value.length == 0){
           return false;
         }
         var ext = this.value.match(/\.(.+)$/)[1];
         switch (ext.toLowerCase()) {
             case 'pdf':
                 break;
             default:
                 this.value = '';
                 $(".file_name_error").html('This is not an allowed file type only pdf type allow.');
                 return false;
         }
         var fileSize = this.files[0];
         var sizeInMb = fileSize.size/1024;
         var sizeLimit= 1024*1;
         if (sizeInMb > sizeLimit) {
           this.value = '';
           $(".file_name_error").html('File size must be less than 1mb.');
           return false;
         }
         $("#file_remove").show();
         $("#file_upload").hide();
     });
});
</script>

@endsection

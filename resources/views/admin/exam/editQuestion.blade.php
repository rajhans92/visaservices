@extends('layouts.app')

@section('content')
    <h3 class="page-title">Edit Question</h3>
    <form action="{{route('admin.exam.updateQuestion',[$exam_id,$section_id,$question_id])}}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}

      <div class="panel panel-default">
        <div class="panel-heading">
        </div>

        <div class="panel-body">
          <div class="row">
            <input type="hidden" name="section_id" value="{{$section_id}}">
            <input type="hidden" name="exam_id" value="{{$exam_id}}">
            <input type="hidden" name="question_id" value="{{$question_id}}">
            @if($questionReadOnly)
              <div class="col-xs-3 form-group">
                {!! Form::label('questions_type', 'Questions Type', ['class' => 'control-label']) !!}
                <p>{{$questionType[$examQuestion->question_type_id]}}</p>
                <input type="hidden" name="questions_type" value="{{$examQuestion->question_type_id}}"/>
              </div>
            @else
              <div class="col-xs-3 form-group">
                  {!! Form::label('questions_type', 'Questions Type*', ['class' => 'control-label']) !!}
                  {!! Form::select('questions_type', $questionType, old('questions_type')?old('questions_type'):$examQuestion->question_type_id ,['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                  <p class="help-block"></p>
                  @if($errors->has('questions_type'))
                      <p class="help-block">
                          {{ $errors->first('questions_type') }}
                      </p>
                  @endif
              </div>
            @endif
            @if($questionReadOnly)
              <div class="col-xs-3 form-group">
                {!! Form::label('submit_type', 'Submit Type ', ['class' => 'control-label']) !!}
                <p>{{$submitType[$examQuestion->answer_type_id]}}</p>
                <input type="hidden" name="submit_type" value="{{$examQuestion->answer_type_id}}"/>
              </div>
            @else
              <div class="col-xs-3 form-group">
                {!! Form::label('submit_type', 'Submit Type *', ['class' => 'control-label']) !!}
                {!! Form::select('submit_type', $submitType,old('submit_type') ? old('submit_type') : $examQuestion->answer_type_id,['class' => 'form-control', 'required' => '', 'placeholder' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('submit_type'))
                    <p class="help-block">
                        {{ $errors->first('submit_type') }}
                    </p>
                @endif
              </div>
            @endif
              <div class="col-xs-3 form-group">
                  {!! Form::label('question_marks', 'Question Marks *', ['class' => 'control-label']) !!}
                  {!! Form::number('question_marks', old('question_marks') ? old('question_marks') : $examQuestion->question_marks, ['class' => 'form-control', 'required' => '','placeholder' => '']) !!}
                  <p class="help-block"></p>
                  @if($errors->has('question_marks'))
                      <p class="help-block">
                          {{ $errors->first('question_marks') }}
                      </p>
                  @endif
              </div>
              <div class="col-xs-3 form-group">
                  {!! Form::label('question_duration', 'Question Duration', ['class' => 'control-label']) !!}
                  {!! Form::number('question_duration', old('question_duration') ? old('question_duration') : $examQuestion->question_duration, ['class' => 'form-control', 'placeholder' => '']) !!}
                  <p class="help-block"></p>
                  @if($errors->has('question_duration'))
                      <p class="help-block">
                          {{ $errors->first('question_duration') }}
                      </p>
                  @endif
              </div>
          </div>

          @foreach($examLanguage as $key => $val)
              <div class="row">
                <div class="col-xs-12 form-group">
                  <label for="paragraph_detail_1" class="control-label">Language ({{ $val->title }})</label>
                </div>
              </div>
              <div class="row">
                <?php
                  $question_detail = "";
                  if(isset($examDetails[$val->language_id]) && isset($examDetails[$val->language_id]['question_detail'])){
                    $question_detail = $examDetails[$val->language_id]['question_detail'];
                  }

                  $para_detail = "";
                  if(isset($examDetails[$val->language_id]) && isset($examDetails[$val->language_id]['paragraph_detail'])){
                    $para_detail = $examDetails[$val->language_id]['paragraph_detail'];
                  }

                  $ans_detail = "";
                  if(isset($examDetails[$val->language_id]) && isset($examDetails[$val->language_id]['answer_detail'])){
                    $ans_detail = $examDetails[$val->language_id]['answer_detail'];
                  }
                ?>
                <div class="col-xs-4 form-group">
                  {!! Form::label('paragraph_detail_'.$val->language_id, 'Paragraph Detail', ['class' => 'control-label']) !!}
                  {!! Form::textarea('paragraph_detail_'.$val->language_id, old('paragraph_detail_'.$val->language_id) ? old('paragraph_detail_'.$val->language_id) : $para_detail, ['class' => 'form-control', 'placeholder' => '']) !!}
                  <p class="help-block"></p>
                  @if($errors->has('paragraph_detail_'.$val->language_id))
                      <p class="help-block">
                          {{ $errors->first('paragraph_detail_'.$val->language_id) }}
                      </p>
                  @endif
                </div>
                <div class="col-xs-4 form-group">
                  {!! Form::label('question_detail_'.$val->language_id, 'Question Detail *', ['class' => 'control-label']) !!}
                  {!! Form::textarea('question_detail_'.$val->language_id, old('question_detail_'.$val->language_id) ? old('question_detail_'.$val->language_id) : $question_detail , ['class' => 'form-control', 'placeholder' => '']) !!}
                  <p class="help-block"></p>
                  @if($errors->has('question_detail_'.$val->language_id))
                      <p class="help-block">
                          {{ $errors->first('question_detail_'.$val->language_id) }}
                      </p>
                  @endif
                </div>
                <div class="col-xs-4 form-group">
                  {!! Form::label('answer_detail_'.$val->language_id, 'Answer Detail *', ['class' => 'control-label']) !!}
                  {!! Form::textarea('answer_detail_'.$val->language_id, old('answer_detail_'.$val->language_id) ? old('answer_detail_'.$val->language_id) : $ans_detail , ['class' => 'form-control', 'placeholder' => '']) !!}
                  <p class="help-block"></p>
                  @if($errors->has('answer_detail_'.$val->language_id))
                      <p class="help-block">
                          {{ $errors->first('answer_detail_'.$val->language_id) }}
                      </p>
                  @endif
                </div>
              </div>
              <div class="row">
                <div class="col-xs-3 form-group">
                  <div class="row">
                    <div class="col-xs-12 form-group">
                      {!! Form::label('paragraph_file_'.$val->language_id,'Paragraph File')!!}
                      <div class="input-group date">
                        <input type="hidden"  name="paragraph_file_{{$val->language_id}}_delete" id="paragraph_file_{{$val->language_id}}_delete" value="0" />
                        <input type="file" class='form-control file_name' size="1" set-id="{{$val->language_id}}" id="paragraph_file_{{$val->language_id}}_input" name="paragraph_file_{{$val->language_id}}" accept=".pdf" />
                          <span class="input-group-addon">
                              <span class="glyphicon glyphicon-remove file_remove" set-id="{{$val->language_id}}" set-name="paragraph_file_{{$val->language_id}}" id="paragraph_file_{{$val->language_id}}_remove" style="{{isset($examDetails[$val->language_id]) && isset($examDetails[$val->language_id]['paragraph_file']) && $examDetails[$val->language_id]['paragraph_file'] != "" ? 'display:inline-block':'display:none'}};">
                              </span>
                              <span class="glyphicon glyphicon-upload file_upload" set-id="{{$val->language_id}}" set-name="paragraph_file_{{$val->language_id}}" id="paragraph_file_{{$val->language_id}}_upload" style="{{isset($examDetails[$val->language_id]) && isset($examDetails[$val->language_id]['paragraph_file']) && $examDetails[$val->language_id]['paragraph_file'] != "" ? 'display:none':'display:inline-block'}};">
                              </span>
                          </span>
                      </div>
                      <p class="help-block paragraph_file_{{$val->language_id}}">
                      </p>
                    </div>
                    <div class="col-xs-12 form-group">
                      @if(isset($examDetails[$val->language_id]) && isset($examDetails[$val->language_id]['paragraph_file']) && $examDetails[$val->language_id]['paragraph_file'] != "")
                        <a target="_blank" href="{{env('IMG_URL').'/img/exam/'.$exam_id.'/'.$section_id.'/'.$question_id.'/'.$examDetails[$val->language_id]['paragraph_file']}}" id="paragraph_file_{{$val->language_id}}">View Current File</a>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="col-xs-3 form-group">
                  <div class="row">
                    <div class="col-xs-12 form-group">
                      {!! Form::label('paragraph_image_'.$val->language_id,'Paragraph Image')!!}
                      <div class="input-group date">
                        <input type="hidden"  name="paragraph_image_{{$val->language_id}}_delete" id="paragraph_image_{{$val->language_id}}_delete" value="0" />
                        <input type="file" class='form-control image_name' size="1" id="paragraph_image_{{$val->language_id}}_input" set-id="{{$val->language_id}}" name="paragraph_image_{{$val->language_id}}" accept="image/jpg,image/png,image/jpeg,image/gif" />
                          <span class="input-group-addon">
                              <span class="glyphicon glyphicon-remove image_remove" set-id="{{$val->language_id}}" set-name="paragraph_image_{{$val->language_id}}" id="paragraph_image_{{$val->language_id}}_remove" style="{{isset($examDetails[$val->language_id]) && isset($examDetails[$val->language_id]['paragraph_image']) && $examDetails[$val->language_id]['paragraph_image'] != "" ? 'display:inline-block':'display:none'}};">
                              </span>
                              <span class="glyphicon glyphicon-upload image_upload" set-name="paragraph_image_{{$val->language_id}}" id="paragraph_image_{{$val->language_id}}_upload" style="{{isset($examDetails[$val->language_id]) && isset($examDetails[$val->language_id]['paragraph_image']) && $examDetails[$val->language_id]['paragraph_image'] != "" ? 'display:none':'display:inline-block'}};">
                              </span>
                          </span>
                      </div>
                      <p class="help-block paragraph_image_{{$val->language_id}}">
                      </p>
                    </div>
                    <div class="col-xs-12 form-group">
                      @if(isset($examDetails[$val->language_id]) && isset($examDetails[$val->language_id]['paragraph_image']) && $examDetails[$val->language_id]['paragraph_image'] != "")
                        <img src="{{env('IMG_URL').'/img/exam/'.$exam_id.'/'.$section_id.'/'.$question_id.'/'.$examDetails[$val->language_id]['paragraph_image']}}" id="paragraph_image_{{$val->language_id}}" width="100px" height="100px" onerror="this.src='{{ env('IMG_URL') }}/img/exam-default.jpg'">
                      @else
                        <img src="" id="paragraph_image_{{$val->language_id}}" style="display: none;" class="avatar-xlarge uk-border-circle shadow"  width="100px" height="100px"/>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="col-xs-3 form-group">
                  <div class="row">
                    <div class="col-xs-12 form-group">
                      {!! Form::label('question_file_'.$val->language_id,'Question File')!!}
                      <div class="input-group date">
                          <input type="hidden"  name="question_file_{{$val->language_id}}_delete" id="question_file_{{$val->language_id}}_delete" value="0" />
                          <input type="file" class='form-control file_name' id="question_file_{{$val->language_id}}_input" size="1" name="question_file_{{$val->language_id}}" accept=".pdf" />
                          <span class="input-group-addon">
                              <span class="glyphicon glyphicon-remove file_remove" set-id="{{$val->language_id}}" set-name="question_file_{{$val->language_id}}" id="question_file_{{$val->language_id}}_remove" style="{{isset($examDetails[$val->language_id]) && isset($examDetails[$val->language_id]['question_file']) && $examDetails[$val->language_id]['question_file'] != "" ? 'display:inline-block':'display:none'}};">
                              </span>
                              <span class="glyphicon glyphicon-upload file_upload" set-id="{{$val->language_id}}" set-name="question_file_{{$val->language_id}}" id="question_file_{{$val->language_id}}_upload" style="{{isset($examDetails[$val->language_id]) && isset($examDetails[$val->language_id]['question_file']) && $examDetails[$val->language_id]['question_file'] != "" ? 'display:none':'display:inline-block'}};">
                              </span>
                          </span>
                      </div>
                      <p class="help-block question_file_{{$val->language_id}}">
                      </p>
                    </div>
                    <div class="col-xs-12 form-group">
                      @if(isset($examDetails[$val->language_id]) && isset($examDetails[$val->language_id]['question_file']) && $examDetails[$val->language_id]['question_file'] != "")
                        <a target="_blank" href="{{env('IMG_URL').'/img/exam/'.$exam_id.'/'.$section_id.'/'.$question_id.'/'.$examDetails[$val->language_id]['question_file']}}" id="question_file_{{$val->language_id}}">View Current File</a>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="col-xs-3 form-group">
                  <div class="row">
                    <div class="col-xs-12 form-group">
                      {!! Form::label('question_image_'.$val->language_id,'Question Image')!!}
                      <div class="input-group date">
                          <input type="hidden"  name="question_image_{{$val->language_id}}_delete" id="question_image_{{$val->language_id}}_delete" value="0" />
                          <input type="file" class='form-control image_name' id="question_image_{{$val->language_id}}_input" size="1" set-id="{{$val->language_id}}" name="question_image_{{$val->language_id}}" accept="image/jpg,image/png,image/jpeg,image/gif" />
                          <span class="input-group-addon">
                              <span class="glyphicon glyphicon-remove image_remove" set-id="{{$val->language_id}}" set-name="question_image_{{$val->language_id}}" id="question_image_{{$val->language_id}}_remove" style="{{isset($examDetails[$val->language_id]) && isset($examDetails[$val->language_id]['question_image']) && $examDetails[$val->language_id]['question_image'] != "" ? 'display:inline-block':'display:none'}};">
                              </span>
                              <span class="glyphicon glyphicon-upload image_upload" set-id="{{$val->language_id}}" set-name="question_image_{{$val->language_id}}" id="question_image_{{$val->language_id}}_upload" style="{{isset($examDetails[$val->language_id]) && isset($examDetails[$val->language_id]['question_image']) && $examDetails[$val->language_id]['question_image'] != "" ? 'display:none':'display:inline-block'}};">
                              </span>
                          </span>
                      </div>
                      <p class="help-block question_image_{{$val->language_id}}">
                      </p>
                    </div>
                    <div class="col-xs-12 form-group">
                      @if(isset($examDetails[$val->language_id]) && isset($examDetails[$val->language_id]['question_image']) && $examDetails[$val->language_id]['question_image'] != "")
                        <img src="{{env('IMG_URL').'/img/exam/'.$exam_id.'/'.$section_id.'/'.$question_id.'/'.$examDetails[$val->language_id]['question_image']}}"  id="question_image_{{$val->language_id}}" onerror="this.src='{{ env('IMG_URL') }}/img/exam-default.jpg'" width="100px" height="100px">
                      @else
                        <img src="" id="question_image_{{$val->language_id}}" style="display: none;" class="avatar-xlarge uk-border-circle shadow"  width="100px" height="100px"/>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
          @endforeach
        </div>
      </div>

      {!! Form::submit("Save & Next", ['class' => 'btn btn-danger']) !!}
        <a href="{{ route('admin.exam.showQuestion',[$exam_id,$section_id]) }}" class="btn btn-primary">Cancel</a>
  </form>

      @stop
      @section('javascript')

      <script type="text/javascript">

      $(function(){
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
         $(".image_upload").click(function(){
             let idName = $(this).attr("set-name");

            $("#"+idName+"_input").trigger('click');
         });
         $(".image_remove").click(function(){
           let idName = $(this).attr("set-name");

           var result = confirm("Want to delete?");
           if(result){
             $("#"+idName).attr('src', "");
             $("#"+idName).hide();
             $("#"+idName+"_input").val('');
             $("#"+idName+"_remove").hide();
             $("#"+idName+"_upload").show();
             $("#"+idName+"_delete").val(1);

           }
         });

         $(".file_upload").click(function(){
             let idName = $(this).attr("set-name");

            $("#"+idName+"_input").trigger('click');
         });
         $(".file_remove").click(function(){
           let idName = $(this).attr("set-name");

           var result = confirm("Want to delete?");
           if(result){
             $("#"+idName).attr('src', "");
             $("#"+idName).hide();
             $("#"+idName+"_input").val('');
             $("#"+idName+"_remove").hide();
             $("#"+idName+"_upload").show();
             $("#"+idName+"_delete").val(1);
           }
         });

         $(document).on("change",".image_name",function(){
             let id = $(this).attr("set-id");
             let idName = $(this).attr("name");
             $("."+idName).html("");
             $("#"+idName+"_remove").hide();
             $("#"+idName+"_upload").show();
             if(!this.value || this.value.length == 0){
               $("#"+idName).attr('src', "");
               $("#"+idName).hide();
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
                     $("."+idName).html('This is not an allowed file type only jpg, png, jpeg and gif image type allow.');
                     return false;
             }
             var fileSize = this.files[0];
             var sizeInMb = fileSize.size/1024;
             var sizeLimit= 1024*1;
             if (sizeInMb > sizeLimit) {
               this.value = '';
               $("."+idName).html('File size must be less than 1mb.');
               return false;
             }
             readURL(this,"#"+idName);
             $("#"+idName+"_remove").show();
             $("#"+idName+"_upload").hide();
         });
         $(document).on("change",".file_name",function(){
             let id = $(this).attr("set-id");
             let idName = $(this).attr("name");
             $("."+idName).html("");
             $("#"+idName+"_remove").hide();
             $("#"+idName+"_upload").show();
             if(!this.value || this.value.length == 0){
               $("#"+idName).attr('src', "");
               $("#"+idName).hide();
               return false;
             }
             var ext = this.value.match(/\.(.+)$/)[1];
             switch (ext.toLowerCase()) {
                 case 'pdf':
                     break;
                 default:
                     this.value = '';
                     $("."+idName).html('This is not an allowed file type only pdf type allow.');
                     return false;
             }
             var fileSize = this.files[0];
             var sizeInMb = fileSize.size/1024;
             var sizeLimit= 1024*1;
             if (sizeInMb > sizeLimit) {
               this.value = '';
               $("."+idName).html('File size must be less than 1mb.');
               return false;
             }
             $("#"+idName+"_remove").show();
             $("#"+idName+"_upload").hide();
         });

      });
      </script>

      @endsection

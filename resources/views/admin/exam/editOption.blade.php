@extends('layouts.app')

@section('content')
    <h3 class="page-title">Edit Options</h3>
    <form action="{{route('admin.exam.saveOption',[$exam_id,$section_id,$question_id])}}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}

      <div class="panel panel-default">
        <div class="panel-heading">
        </div>
        <?php $count=1;?>
        <div class="panel-body">
          @if(count($examData))
          <div id="maindiv">
              @foreach($examData as $keyExam => $valData)
                  <div id="div{{$count}}">
                    <div class="row">
                        <div class="col-xs-12 form-group">
                          <label for="option_label" class="control-label"><span class="label_count">{{$count}}</span>. Option Label ({{$optionLabel[$valData['option_label_id']]}})</label>
                          <input type="hidden" name="option_label{{$count}}" id="option_label_{{$count}}" value="{{$valData['option_label_id']}}">
                        </div>
                        <div class="col-xs-12 form-group">
                            @foreach($examLanguage as $key => $val)
                                <input type="hidden" id="{{$key}}_{{$count}}" value="{{isset($valData[$key]) ? $valData[$key]['id'] : ''}}"/>
                                <div class="col-xs-3 form-group">
                                  <label for="option_value{{$count}}" class="control-label">Option Value {{$val}}</label>
                                  <input class="form-control" placeholder="" value="{{isset($valData[$key]) ? $valData[$key]['option_value'] : ''}}" name="option_value{{$count}}" type="text" id="option_value_{{$key}}_{{$count}}">
                                  <p class="help-block error_value_{{$key}}_{{$count}}">

                                  </p>
                                </div>
                            @endforeach
                            @foreach($examLanguage as $key => $val)
                                <div class="col-xs-2 form-group">
                                  <div class="row">
                                    <div class="col-xs-12 form-group">
                                        <label for="option_image{{$count}}" class="control-label">Option Image {{$val}}</label>
                                        <div class="input-group date">
                                            <input type="hidden" id="option_image{{$key}}_{{$count}}_delete" value="0"/>
                                            <input class="form-control fileUpload" placeholder="" name="option_image{{$count}}" data-id="{{$key}}_{{$count}}" type="file" accept="image/jpg,image/png,image/jpeg,image/gif" id="option_image{{$key}}_{{$count}}">

                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-remove image_remove" set-name="option_image{{$key}}_{{$count}}" id="option_image{{$key}}_{{$count}}_remove" style="{{isset($valData[$key]) && $valData[$key]['option_image'] != "" ? 'display:inline-block':'display:none'}};">
                                                </span>
                                                <span class="glyphicon glyphicon-upload image_upload" set-name="option_image{{$key}}_{{$count}}" id="option_image{{$key}}_{{$count}}_upload" style="{{isset($valData[$key]) && $valData[$key]['option_image'] != "" ? 'display:none':'display:inline-block'}};">
                                                </span>
                                            </span>
                                        </div>
                                        <p class="help-block option_image{{$key}}_{{$count}}">
                                        </p>
                                    </div>
                                    <div class="col-xs-12 form-group">
                                      @if(isset($valData[$key]) && $valData[$key]['option_image'] != "")
                                        <img src="{{env('IMG_URL').'/img/exam/'.$exam_id.'/'.$section_id.'/'.$question_id.'/'.$valData[$key]['option_image']}}" onerror="this.src='{{env('IMG_URL')}}/img/exam-default.jpg'"  alt="" id="option_image{{$key}}_{{$count}}_show" class="avatar-xlarge uk-border-circle shadow" height="100px" width="100px">
                                      @else
                                        <img src=""  alt="" id="option_image{{$key}}_{{$count}}_show" class="avatar-xlarge uk-border-circle shadow" height="100px" width="100px">
                                      @endif
                                    </div>
                                  </div>
                                </div>
                            @endforeach
                            <div class="col-xs-2 form-group">
                              <div class="row">
                                <div class="col-xs-12 form-group">
                                  <label for="is_option_correct{{$count}}" class="control-label">Is Option Correct</label>
                                  <select class="form-control" name="is_option_correct{{$count}}" id="is_option_correct_{{$count}}">
                                    <option value="0" {{$valData['is_option_correct'] == 0 ? "selected":""}}>
                                      No
                                    </option>
                                    <option value="1" {{$valData['is_option_correct'] == 1 ? "selected":""}}>
                                      Yes
                                    </option>
                                  </select>
                                </div>
                                <div class="col-xs-12 form-group">
                                  <input type="button" class="btn btn-danger save" id="save{{$count}}" data-set="{{$count}}" data-check="2" value="Update" style=" float: right;">
                                </div>
                              </div>
                            </div>
                        </div>
                    </div>
                  <hr>
                </div>
                <?php $count++;?>
              @endforeach
            </div>
          @else
            <div id="maindiv">
              <div id="div{{$count}}">
                <div class="row">
                    <div class="col-xs-12 form-group">
                      <label for="option_label" class="control-label"><span class="label_count">{{$count}}</span>. Option Label ({{$optionLabel[$count]}})</label>
                      <input type="hidden" name="option_label{{$count}}" id="option_label_{{$count}}" value="{{$count}}">
                    </div>
                    <div class="col-xs-12 form-group">
                      @foreach($examLanguage as $key => $val)
                        <input type="hidden" id="{{$key}}_{{$count}}" value=""/>
                        <div class="col-xs-3 form-group">
                          <label for="option_value{{$count}}" class="control-label">Option Value {{$val}}</label>
                          <input class="form-control" placeholder="" name="option_value{{$count}}" type="text" id="option_value_{{$key}}_{{$count}}">
                          <p class="help-block error_value_{{$key}}_{{$count}}">

                          </p>
                        </div>
                      @endforeach
                      @foreach($examLanguage as $key => $val)
                        <div class="col-xs-2 form-group">
                          <div class="row">
                            <div class="col-xs-12 form-group">
                              <label for="option_image{{$count}}" class="control-label">Option Image {{$val}}</label>

                              <div class="input-group date">
                                  <input type="hidden" id="option_image{{$key}}_{{$count}}_delete" value="0"/>
                                  <input class="form-control fileUpload" placeholder="" name="option_image{{$count}}" data-id="{{$key}}_{{$count}}" type="file" accept="image/jpg,image/png,image/jpeg,image/gif" id="option_image{{$key}}_{{$count}}">

                                  <span class="input-group-addon">
                                      <span class="glyphicon glyphicon-remove image_remove" set-name="option_image{{$key}}_{{$count}}" id="option_image{{$key}}_{{$count}}_remove" style="display:none;">
                                      </span>
                                      <span class="glyphicon glyphicon-upload image_upload" set-name="option_image{{$key}}_{{$count}}" id="option_image{{$key}}_{{$count}}_upload" style="display:inline-block;">
                                      </span>
                                  </span>
                              </div>
                              <p class="help-block option_image{{$key}}_{{$count}}">
                              </p>
                            </div>
                            <div class="col-xs-12 form-group">
                              <img src=""  alt="" id="option_image{{$key}}_{{$count}}_show" class="avatar-xlarge uk-border-circle shadow" height="100px" width="100px">
                            </div>
                          </div>
                        </div>
                      @endforeach
                      <div class="col-xs-2 form-group">
                        <div class="row">
                          <div class="col-xs-12 form-group">
                            <label for="is_option_correct{{$count}}" class="control-label">Is Option Correct</label>
                            <select class="form-control" name="is_option_correct{{$count}}" id="is_option_correct_{{$count}}">
                              <option value="0">
                                No
                              </option>
                              <option value="1">
                                Yes
                              </option>
                            </select>
                          </div>
                          <div class="col-xs-12 form-group">
                            <input type="button" class="btn btn-danger save" id="save{{$count}}" data-set="{{$count}}" data-check="1" value="Save" style=" float: right;">
                          </div>
                        </div>
                      </div>
                  </div>
                </div>
              <hr>
            </div>
            <?php $count++;?>
          </div>
          @endif
        <div class="row">
          <div class="col-xs-12 form-group">
            <input type="button" class="btn btn-warning" id="addOption" value="Add Option">
            <input type="button" class="btn btn-info" id="deleteOption" style="display:{{$count > 2 ? 'inline-block':'none'}};" value="Delete last Option">
            <a href="{{ route('admin.exam.showQuestion',[$exam_id,$section_id]) }}" class="btn btn-default">Back</a>
          </div>
        </div>
      </div>
  </form>

      @stop
      @section('javascript')

      <script type="text/javascript">

      $(function(){
          var count = "{{$count}}";
          var exam_id = "{{$exam_id}}";
          var section_id = "{{$section_id}}";
          var question_id = "{{$question_id}}";

          var examLanguage =  <?php echo json_encode($examLanguage); ?>;
          var optionLabel =  <?php echo json_encode($optionLabel); ?>;

          $("#addOption").click(function(){
            let setid = count - 1;
            if($("#save"+setid).attr('data-check') != 2){
              var result = confirm("You have unsave option");
              return false;
            }
            if(count > 9){
              var result = confirm("Option limit exceeded!");
              return false;
            }
            if(count >= 2){
              $("#deleteOption").show();
            }

            let html = '<div id="div'+count+'"> <div class="row"> <div class="col-xs-12 form-group"> <label for="option_label" class="control-label"><span class="label_count">'+count+'</span>. Option Label ('+optionLabel[count]+')</label> <input type="hidden" name="option_label'+count+'" id="option_label_'+count+'" value="'+count+'"> </div> <div class="col-xs-12 form-group">';

            let valueHtml ='';
            let imgHtml ='';
            for (var key in examLanguage) {
              valueHtml += '<input type="hidden" id="'+key+'_'+count+'" value=""/> <div class="col-xs-3 form-group"> <label for="option_value'+key+'_'+count+'" class="control-label">Option Value '+examLanguage[key]+'</label> <input class="form-control" placeholder="" name="option_value'+key+'_'+count+'" type="text" id="option_value_'+key+'_'+count+'"><p class="help-block error_value_'+key+'_'+count+'"> </p></div>';

              imgHtml += '<div class="col-xs-2 form-group"> <div class="row"> <div class="col-xs-12 form-group"> <label for="option_image'+count+'" class="control-label">Option Image {{$val}}</label><div class="input-group date"><input type="hidden" id="option_image'+key+'_'+count+'_delete" value="0"/><input class="form-control fileUpload" placeholder="" name="option_image'+count+'" data-id="'+key+'_'+count+'" type="file" accept="image/jpg,image/png,image/jpeg,image/gif" id="option_image'+key+'_'+count+'"> <span class="input-group-addon"> <span class="glyphicon glyphicon-remove image_remove" set-name="option_image'+key+'_'+count+'" id="option_image'+key+'_'+count+'_remove" style="display:none;"> </span> <span class="glyphicon glyphicon-upload image_upload" set-name="option_image'+key+'_'+count+'" id="option_image'+key+'_'+count+'_upload" style="display:inline-block;"> </span> </span> </div><p class="help-block option_image'+key+'_'+count+'"> </p></div> <div class="col-xs-12 form-group"> <img src=""  alt="" id="option_image'+key+'_'+count+'_show" class="avatar-xlarge uk-border-circle shadow" height="100px" width="100px"> </div> </div> </div>';

            }

            html += valueHtml+imgHtml +'<div class="col-xs-2 form-group"> <div class="row"> <div class="col-xs-12 form-group"> <label for="is_option_correct'+count+'" class="control-label">Is Option Correct</label> <select class="form-control" name="is_option_correct'+count+'" id="is_option_correct_'+count+'"> <option value="0"> No </option> <option value="1"> Yes </option> </select> </div> <div class="col-xs-12 form-group"> <input type="button" class="btn btn-danger save" id="save'+count+'" data-set="'+count+'" data-check="1" value="Save" style=" float: right;"> </div> </div> </div> </div> </div> <hr> </div>';

            $("#maindiv").append(html);
            setupcount();

            count++;
          });

          $(document).on("click","#deleteOption",function(){
            let setid = count-1;
            if(setid < 2){
              return false;
            }
            if(setid <= 2){
              $("#deleteOption").hide();
            }
            --count;
            let dataSet = [];
              if(setid.length != 0){
                for (var key in examLanguage) {
                  let id = $("#"+key+"_"+setid).val();
                  if(id.length != 0){
                    dataSet.push(id);
                  }
                }
                if(dataSet.length != 0){
                  var result = confirm("Want to delete?");
                  if (result) {
                    $.ajax({
                      url: "/admin/exam/question/option/edit/"+exam_id+"/"+section_id+"/"+question_id,
                      data:{"_token": "{{ csrf_token() }}","idSet":dataSet, "check":2},
                      type: "POST",
                      success: function(result){
                        var data = JSON.parse(result);
                        if(!data.error){
                          $("#div"+setid).remove();
                          setupcount()
                        }
                      }
                   });
                  }
                }else{
                  $("#div"+setid).remove();
                  setupcount()
                }

              }
          });
          function setupcount(){
            let tempCount = 1;
            $(".label_count").each(function() {
                $(this).text(tempCount++);
            });

          }
          $(document).on("click",".save",function(){
              let setid = $(this).attr("data-set");
              let setCheck = $(this).attr("data-check");
              let dataSet = {};

              if(setid.length != 0 && setCheck.length != 0){
                var form = new FormData();
                form.append("_token", "{{ csrf_token() }}");
                for (var key in examLanguage) {
                    let id = $("#"+key+"_"+setid).val();
                    var file = $("#option_image"+key+"_"+setid)[0].files[0];
                    if (file) {
                        form.append('option_image_'+key, file);
                    }
                    form.append("option_id_"+key,id);
                    if($("#option_label_"+setid).val().length <= 0 || $("#option_value_"+key+"_"+setid).val().length <= 0 || $("#is_option_correct_"+setid).val().length <= 0){
                      $(".error_value_"+key+"_"+setid).html("Empty Field is not acceptable!")
                      return false;
                    }
                    form.append("option_label_"+key,$("#option_label_"+setid).val());
                    form.append("option_value_"+key,$("#option_value_"+key+"_"+setid).val());
                    form.append("is_option_correct_"+key,$("#is_option_correct_"+setid).val());

                    form.append("option_img_delete_"+key,$("#option_image"+key+"_"+setid+"_delete").val());
                }

                if(setCheck == 1){
                  form.append("check",0);
                  if(dataSet.length != 0){
                    var result = confirm("Want to save?");
                    if (result) {
                      $(this).val("Loading...");
                      var that = $(this);
                      $.ajax({
                        url: "/admin/exam/question/option/edit/"+exam_id+"/"+section_id+"/"+question_id,
                        data:form,
                        type: "POST",
                        contentType: false,
                        processData: false,
                        success: function(result){
                          var data = JSON.parse(result);
                          if(!data.error){
                            that.val("Update");
                            for (var key in data.data) {
                              $("#"+key+"_"+setid).val(data.data[key]);
                            }
                            that.attr('data-check',2);
                          }else{
                            that.val("Save");
                            $(".error_label_"+setid).html(data.msg)
                          }
                        }
                     });
                    }
                  }
                }else if(setCheck == 2){
                  form.append("check",1);
                  if(dataSet.length != 0){
                    var result = confirm("Want to Update?");
                    if (result) {
                      $(this).val("Loading...");
                      var that = $(this);
                      $.ajax({
                        url: "/admin/exam/question/option/edit/"+exam_id+"/"+section_id+"/"+question_id,
                        data:form,
                        type: "POST",
                        contentType: false,
                        processData: false,
                        success: function(result){
                          that.val("Update");
                          var data = JSON.parse(result);
                          if(data.error){
                            $(".error_label_"+setid).html(data.msg)
                          }
                        }
                     });
                    }
                  }
                }

                // if(id.length != 0){
                //   var result = confirm("Want to Update?");
                //   if (result) {
                //
                //   }
                // }else{
                //   var result = confirm("Want to save?");
                //   if (result) {
                //
                //   }
                // }
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
           $(document).on('click','.image_upload',function(){
               let idName = $(this).attr("set-name");

              $("#"+idName).trigger('click');
           });
           $(document).on('click','.image_remove',function(){
             let idName = $(this).attr("set-name");

             var result = confirm("Want to delete?");
             if(result){
               $("#"+idName+"_show").attr('src', "");
               $("#"+idName+"_show").hide();
               $("#"+idName).val('');
               $("#"+idName+"_delete").val(1);
               $("#"+idName+"_remove").hide();
               $("#"+idName+"_upload").show();
             }
           });

           $(document).on("change",".fileUpload",function(){
               let className = $(this).attr("id");
               $("."+className).html("");
               $("#"+className+"_remove").hide();
               $("#"+className+"_upload").show();
               if(!this.value || this.value.length == 0){
                 $("#"+className+"_show").attr('src', "");
                 $("#"+className+"_show").hide();
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
                       $("."+className).html('This is not an allowed file type only jpg, png, jpeg and gif image type allow.');
                       return false;
               }
               var fileSize = this.files[0];
               var sizeInMb = fileSize.size/1024;
               var sizeLimit= 1024*1;
               if (sizeInMb > sizeLimit) {
                 this.value = '';
                 $("."+className).html('File size must be less than 1mb.');
                 return false;
               }

               readURL(this,"#"+className+"_show");
               $("#"+className+"_delete").val(0);
               $("#"+className+"_remove").show();
               $("#"+className+"_upload").hide();
           });
      });
      </script>

      @endsection

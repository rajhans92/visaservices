@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.exam-schedule.title')</h3>
    {!! Form::model($exam_schedule, ['method' => 'PUT', 'route' => ['admin.exam-schedule.update', $exam_schedule->id] , 'files'=>true]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_edit')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-4 form-group">
                  <input type="hidden" name="id" value="{{$exam_schedule->id}}"/>
                  {!! Form::label('exam_id', 'Select Exam*', ['class' => 'control-label']) !!}
                  {!! Form::select('exam_id', $examObj,old('exam_id') ,['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                  <p class="help-block"></p>
                  @if($errors->has('exam_id'))
                      <p class="help-block">
                          {{ $errors->first('exam_id') }}
                      </p>
                  @endif
                </div>
                <div class="col-xs-4 form-group">
                    {!! Form::label('exam_display_name', 'Exam Display Name*', ['class' => 'control-label']) !!}
                    {!! Form::text('exam_display_name', old('exam_display_name'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('exam_display_name'))
                        <p class="help-block">
                            {{ $errors->first('exam_display_name') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-4 form-group">
                  {!! Form::label('sponsored_by', 'Sponsored By*', ['class' => 'control-label']) !!}
                  {!! Form::select('sponsored_by', $sponsorObj, old('sponsored_by') ,['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                  <p class="help-block"></p>
                  @if($errors->has('sponsored_by'))
                      <p class="help-block">
                          {{ $errors->first('sponsored_by') }}
                      </p>
                  @endif
                </div>
            </div>
            <div class="row">
              <div class="col-xs-4 form-group">
                  {!! Form::label('start_date', 'Exam Start Date Time*', ['class' => 'control-label']) !!}
                    <div class='input-group date'>
                        <input type='text'  name="start_date" autocomplete="off" value="{{date('d-m-Y h:i a',strtotime($exam_schedule->start_date))}}" class="form-control" id="start_date" required/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                    <p class="help-block"></p>
                    @if($errors->has('start_date'))
                        <p class="help-block">
                            {{ $errors->first('start_date') }}
                        </p>
                    @endif
              </div>
                <div class="col-xs-4 form-group">
                    {!! Form::label('end_date', 'Exam End Date Time*', ['class' => 'control-label']) !!}
                      <div class='input-group date'>
                          <input type='text'  name="end_date" autocomplete="off" class="form-control" value="{{date('d-m-Y h:i a',strtotime($exam_schedule->end_date))}}" id="end_date" required/>
                          <span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                      </div>
                      <p class="help-block"></p>
                      @if($errors->has('end_date'))
                          <p class="help-block">
                              {{ $errors->first('end_date') }}
                          </p>
                      @endif
                </div>
                <div class="col-xs-4 form-group">
                    {!! Form::label('result_date', 'Exam Result Date Time*', ['class' => 'control-label']) !!}
                      <div class='input-group date'>
                          <input type='text'  name="result_date" autocomplete="off" class="form-control" value="{{date('d-m-Y h:i a',strtotime($exam_schedule->result_date))}}" id="result_date" required/>
                          <span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                      </div>
                      <p class="help-block"></p>
                      @if($errors->has('result_date'))
                          <p class="help-block">
                              {{ $errors->first('result_date') }}
                          </p>
                      @endif
                </div>
              </div>
              <div class="row">
                <div class="col-xs-4 form-group">
                    {!! Form::label('no_of_winner', 'No Of Winner*', ['class' => 'control-label']) !!}
                    {!! Form::number('no_of_winner', old('no_of_winner'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('no_of_winner'))
                        <p class="help-block">
                            {{ $errors->first('no_of_winner') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-4 form-group">
                    {!! Form::label('prize_amount', 'Prize Amount*', ['class' => 'control-label']) !!}
                    {!! Form::number('prize_amount', old('prize_amount'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('prize_amount'))
                        <p class="help-block">
                            {{ $errors->first('prize_amount') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-4 form-group">
                    {!! Form::label('user_limit', 'User Limits*', ['class' => 'control-label']) !!}
                    {!! Form::number('user_limit', old('user_limit'),['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('user_limit'))
                        <p class="help-block">
                            {{ $errors->first('user_limit') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                  <div class="col-xs-4 form-group">
                      {!! Form::label('reminder', 'No Of Reminder', ['class' => 'control-label']) !!}
                      {!! Form::number('reminder', old('reminder'),['class' => 'form-control', 'placeholder' => '']) !!}
                      <p class="help-block"></p>
                      @if($errors->has('reminder'))
                          <p class="help-block">
                              {{ $errors->first('reminder') }}
                          </p>
                      @endif
                  </div>
                  <div class="col-xs-4 form-group">
                    <div class="row">
                      <div class="col-xs-12 form-group">
                        {!! Form::label('exam_logo','Exam Logo')!!}
                        <div class="input-group">
                            <input type="hidden"  name="exam_logo_delete" id="exam_logo_delete" value="0" />
                            <input type="file" class='form-control exam_logo' size="1" name="exam_logo" accept="image/jpg,image/png,image/jpeg,image/gif" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-remove" id="exam_logo_remove" style="{{$exam_schedule->exam_logo != "" ? 'display:inline-block':'display:none'}};">
                                </span>
                                <span class="glyphicon glyphicon-upload" id="exam_logo_upload" style="{{$exam_schedule->exam_logo != "" ? 'display:none':'display:inline-block'}};">
                                </span>
                            </span>
                          </div>
                          <p class="help-block exam_logo_error">
                          </p>
                      </div>
                      <div class="col-xs-12 form-group">
                        @if($exam_schedule->exam_logo != "")
                          <img src="{{ env('IMG_URL') }}/img/exam_schedule/{{$exam_schedule->id}}/logo/{{ $exam_schedule->exam_logo }}" onerror="this.src='{{ env('IMG_URL') }}/img/default.png'" id="exam_logo_show" class="avatar-xlarge uk-border-circle shadow"  width="100px" height="100px"/>
                        @else
                          <img src="" id="exam_logo_show" style="display: none;" class="avatar-xlarge uk-border-circle shadow"  width="100px" height="100px"/>
                        @endif
                      </div>
                    </div>
                  </div>
                  <div class="col-xs-4 form-group">
                    <div class="row">
                      <div class="col-xs-12 form-group">
                        {!! Form::label('exam_banner','Exam Banner')!!}
                        <div class="input-group">
                          <input type="hidden"  name="exam_banner_delete" id="exam_banner_delete" value="0" />
                            <input type="file" class='form-control exam_banner' size="1" name="exam_banner" accept="image/jpg,image/png,image/jpeg,image/gif" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-remove" id="exam_banner_remove" style="{{$exam_schedule->exam_banner != "" ? 'display:inline-block':'display:none'}};">
                                </span>
                                <span class="glyphicon glyphicon-upload" id="exam_banner_upload" style="{{$exam_schedule->exam_banner != "" ? 'display:none':'display:inline-block'}};">
                                </span>
                            </span>
                          </div>
                          <p class="help-block exam_banner_error">
                          </p>
                      </div>
                      <div class="col-xs-12 form-group">
                        @if($exam_schedule->exam_banner != "")
                          <img src="{{ env('IMG_URL') }}/img/exam_schedule/{{$exam_schedule->id}}/banner/{{ $exam_schedule->exam_banner }}" onerror="this.src='{{ env('IMG_URL') }}/img/org/banner-default.jpg'" id="exam_banner_show" class="avatar-xlarge uk-border-circle shadow"  width="100px" height="100px"/>
                        @else
                          <img src="" id="exam_banner_show" style="display: none;" class="avatar-xlarge uk-border-circle shadow"  width="100px" height="100px"/>
                        @endif
                      </div>
                    </div>
                  </div>
              </div>
              <div class="row">
                <div class="col-xs-12 form-group">
                  {!! Form::label('exam_detail', 'Exam Details*', ['class' => 'control-label']) !!}
                  {!! Form::textarea('exam_detail', old('exam_detail'),['class' => 'form-control', 'placeholder' => '']) !!}
                  <p class="help-block"></p>
                  @if($errors->has('exam_detail'))
                      <p class="help-block">
                          {{ $errors->first('exam_detail') }}
                      </p>
                  @endif
                </div>
              </div>

        </div>
    </div>

    {!! Form::submit('Update', ['class' => 'btn btn-danger']) !!}
    <a href="{{ route('admin.exam-schedule.index') }}" class="btn btn-default">Cancel</a>
    {!! Form::close() !!}

@stop
@section('javascript')

<script type="text/javascript">

$(function(){
  $('#start_date,#end_date,#result_date').datetimepicker({
      format: 'DD-MM-Y hh:mm',
      useCurrent: false,
      minDate: moment()
  });
  $('#start_date').datetimepicker().on('dp.change', function (e) {
      var incrementDay = moment(new Date(e.date));
      incrementDay.add(1, 'days');
      $('#result_date').val('');
      // $('#end_date').val('');
      $('#end_date').data('DateTimePicker').minDate(incrementDay);
      // $(this).data("DateTimePicker").hide();
  });

  $('#end_date').datetimepicker().on('dp.change', function (e) {
      var decrementDay = moment(new Date(e.date));
      decrementDay.subtract(1, 'days');
      var incrementDay = moment(new Date(e.date));
      incrementDay.add(1, 'days');
      $('#start_date').data('DateTimePicker').maxDate(decrementDay);
      $('#result_date').val('');
      $('#result_date').data('DateTimePicker').minDate(incrementDay);
       // $(this).data("DateTimePicker").hide();
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
  $("#exam_logo_upload").click(function(){
     $(".exam_logo").trigger('click');
  });
  $("#exam_banner_upload").click(function(){
     $(".exam_banner").trigger('click');
  });
  $("#exam_logo_remove").click(function(){
    var result = confirm("Want to delete?");
    if(result){
      $("#exam_logo_show").attr('src', "");
      $("#exam_logo_show").hide();
      $(".exam_logo").val('');
      $("#exam_logo_delete").val(1);
      $("#exam_logo_remove").hide();
      $("#exam_logo_upload").show();
    }
  });
  $("#exam_banner_remove").click(function(){
    var result = confirm("Want to delete?");
    if(result){
      $("#exam_banner_show").attr('src', "");
      $("#exam_banner_show").hide();
      $(".exam_banner").val('');
      $("#exam_banner_delete").val(1);
      $("#exam_banner_remove").hide();
      $("#exam_banner_upload").show();
    }
  });
 $(document).on("change",".exam_banner",function(){
     $(".exam_banner_error").html("");
     $("#exam_banner_remove").hide();
     $("#exam_banner_upload").show();
     if(!this.value || this.value.length == 0){
       $("#exam_banner_show").attr('src', "");
       $("#exam_banner_show").hide();
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
             $(".exam_banner_error").html('This is not an allowed file type only jpg, png, jpeg and gif image type allow.');
             return false;
     }
     var fileSize = this.files[0];
     var sizeInMb = fileSize.size/1024;
     var sizeLimit= 1024*1;
     if (sizeInMb > sizeLimit) {
       this.value = '';
       $(".exam_banner_error").html('File size must be less than 1mb.');
       return false;
     }
     readURL(this,"#exam_banner_show");
     $("#exam_banner_remove").show();
     $("#exam_banner_upload").hide();
 });
 $(document).on("change",".exam_logo",function(){
     $(".exam_logo_error").html("");
     $("#exam_logo_remove").hide();
     $("#exam_logo_upload").show();
     if(!this.value || this.value.length == 0){
       $("#exam_logo_show").attr('src', "");
       $("#exam_logo_show").hide();
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
             $(".exam_logo_error").html('This is not an allowed file type only jpg, png, jpeg and gif image type allow.');
             return false;
     }
     var fileSize = this.files[0];
     var sizeInMb = fileSize.size/1024;
     var sizeLimit= 1024*1;
     if (sizeInMb > sizeLimit) {
       this.value = '';
       $(".exam_logo_error").html('File size must be less than 1mb.');
       return false;
     }
     readURL(this,"#exam_logo_show");
     $("#exam_logo_remove").show();
     $("#exam_logo_upload").hide();
 });
});
</script>

@endsection

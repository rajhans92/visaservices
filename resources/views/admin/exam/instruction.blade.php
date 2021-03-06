@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.exam.title')</h3>
    {!! Form::model($exam_instruction, ['method' => 'POST', 'route' => ['admin.exam.saveInstruction', $exam_id] , 'files'=>true]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            Step 2 - Save Exam Instruction
        </div>

        <div class="panel-body">
          @foreach($exam_instruction as $val)
          <div class="row">
              <div class="col-xs-12 form-group">
                  <input type="hidden" name="lang_{{$val->language_id}}" value="{{$val->language_id}}"/>
                  {!! Form::label('instruction_'.$val->language_id, 'Instruction In '.$val->title, ['class' => 'control-label']) !!}
                  {!! Form::textarea('instruction_'.$val->language_id, old('instruction_'.$val->language_id)?old('instruction_'.$val->language_id):$val->exam_note, ['class' => 'form-control', 'placeholder' => '']) !!}
                  <p class="help-block"></p>
                  @if($errors->has('instruction_'.$val->language_id))
                      <p class="help-block">
                          {{ $errors->first('instruction_'.$val->language_id) }}
                      </p>
                  @endif
              </div>
          </div>
          @endforeach
        </div>

    </div>

    {!! Form::submit(trans('global.app_save_next'), ['class' => 'btn btn-danger']) !!}
    <a href="{{ route('admin.exam.index') }}" class="btn btn-primary">Cancel</a>
    <a href="{{ url('/admin/exam/'.$exam_id.'/edit') }}" class="btn btn-default">Back</a>

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
});
</script>

@endsection

@extends('layouts.app')

@section('content')
    <h3 class="page-title">Edit Section</h3>
    {!! Form::model($exam_section, ['method' => 'PUT', 'route' => ['admin.exam.updateSection', $exam_section->id] , 'files'=>true]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
        </div>

        <div class="panel-body">
            <div class="row">
                <input type="hidden" name="exam_id" value="{{$exam_id}}">
                <div class="col-xs-4 form-group">
                    {!! Form::label('section_name', 'Section Name*', ['class' => 'control-label']) !!}
                    {!! Form::text('section_name', old('section_name'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('section_name'))
                        <p class="help-block">
                            {{ $errors->first('section_name') }}
                        </p>
                    @endif
                </div>
                  <div class="col-xs-4 form-group">
                    {!! Form::label('is_negative_marking', 'Negative Marking *', ['class' => 'control-label']) !!}
                    {!! Form::select('is_negative_marking', [0=>"No",1=>"Yes"],old('is_negative_marking') ? old('is_negative_marking') : $exam_section->is_negative_marking,['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
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
                      if(isset($exam_section->is_negative_marking) && $exam_section->is_negative_marking == 1 || old('is_negative_marking')){
                        unset($data['disabled']);
                      }
                    ?>
                      {!! Form::label('negative_marking_no', 'Negative Marking No', ['class' => 'control-label']) !!}
                      {!! Form::number('negative_marking_no', $exam_section->is_negative_marking == 0 ? '' : old('negative_marking_no'), $data) !!}
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
                    {!! Form::label('total_marks', 'Total Marks*', ['class' => 'control-label']) !!}
                    {!! Form::number('total_marks', old('total_marks'), ['class' => 'form-control', 'required' => '', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('total_marks'))
                        <p class="help-block">
                            {{ $errors->first('total_marks') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-4 form-group">
                    {!! Form::label('cutoff', 'Cutoff', ['class' => 'control-label']) !!}
                    {!! Form::number('cutoff', old('cutoff') ? old('cutoff') : $exam_section->cutoff > 0 ? $exam_section->cutoff : "", ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('cutoff'))
                        <p class="help-block">
                            {{ $errors->first('cutoff') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-4 form-group">
                    {!! Form::label('total_questions', 'Total Questions*', ['class' => 'control-label']) !!}
                    {!! Form::number('total_questions', old('total_questions'), ['class' => 'form-control', 'required' => '','placeholder' => '']) !!}
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
                  {!! Form::label('section_duration', 'Section Duration', ['class' => 'control-label']) !!}
                  {!! Form::number('section_duration', old('section_duration') ? old('section_duration') : $exam_section->section_duration > 0 ? $exam_section->section_duration : "", ['class' => 'form-control', 'placeholder' => '']) !!}
                  <p class="help-block"></p>
                  @if($errors->has('section_duration'))
                      <p class="help-block">
                          {{ $errors->first('section_duration') }}
                      </p>
                  @endif
              </div>
              @if($questionReadOnly)
                <div class="col-xs-4 form-group">
                  {!! Form::label('questions_type', 'Questions Type', ['class' => 'control-label']) !!}
                  <p>{{$questionType[$exam_section->questions_type]}}</p>
                  <input type="hidden" name="questions_type" value="{{$exam_section->questions_type}}"/>
                </div>
              @else
                <div class="col-xs-4 form-group">
                  {!! Form::label('questions_type', 'Questions Type*', ['class' => 'control-label']) !!}
                  {!! Form::select('questions_type', $questionType, old('questions_type') ? old('questions_type') : $exam_section->questions_type,['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                  <p class="help-block"></p>
                  @if($errors->has('questions_type'))
                      <p class="help-block">
                          {{ $errors->first('questions_type') }}
                      </p>
                  @endif
                </div>
              @endif
              @if($submitReadOnly)
                <div class="col-xs-4 form-group">
                  {!! Form::label('submit_type', 'Submit Type', ['class' => 'control-label']) !!}
                  <p>{{$submitType[$exam_section->submit_type]}}</p>
                  <input type="hidden" name="submit_type" value="{{$exam_section->submit_type}}"/>
                </div>
              @else
                <div class="col-xs-4 form-group">
                  {!! Form::label('submit_type', 'Submit Type *', ['class' => 'control-label']) !!}
                  {!! Form::select('submit_type', $submitType,old('submit_type') ? old('submit_type') : $exam_section->submit_type,['class' => 'form-control', 'placeholder' => '','required' => '']) !!}
                  <p class="help-block"></p>
                  @if($errors->has('submit_type'))
                      <p class="help-block">
                          {{ $errors->first('submit_type') }}
                      </p>
                  @endif
                </div>
              @endif

            </div>
        </div>
    </div>

    {!! Form::submit(trans('global.app_save'), ['class' => 'btn btn-danger']) !!}
    <a href="{{ route('admin.exam.showSection',[$exam_id]) }}" class="btn btn-primary">Cancel</a>

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
});
</script>

@endsection

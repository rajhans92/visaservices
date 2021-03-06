@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.student.title')</h3>
    {!! Form::model($user, ['method' => 'PUT', 'route' => ['admin.student.update', $user->id] , 'files'=>true]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_edit') &nbsp;&nbsp;     <a href="{{ route('admin.student.index') }}" class="btn btn-default">@lang('global.app_back_to_list')</a>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-4 form-group">
                    {!! Form::label('first_name', 'First Name*', ['class' => 'control-label']) !!}
                    {!! Form::text('first_name', old('first_name'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('first_name'))
                        <p class="help-block">
                            {{ $errors->first('first_name') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-4 form-group">
                    {!! Form::label('last_name', 'Last Name', ['class' => 'control-label']) !!}
                    {!! Form::text('last_name', old('last_name'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('last_name'))
                        <p class="help-block">
                            {{ $errors->first('last_name') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-4 form-group">
                    {!! Form::label('email', 'Email*', ['class' => 'control-label']) !!}
                    {!! Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('email'))
                        <p class="help-block">
                            {{ $errors->first('email') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4 form-group">
                    {!! Form::label('phone_no', 'Phone No*', ['class' => 'control-label']) !!}
                    {!! Form::number('phone_no', old('phone_no'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('phone_no'))
                        <p class="help-block">
                            {{ $errors->first('phone_no') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-4 form-group">
                    {!! Form::label('alt_phone_no', 'Alternate Phone No', ['class' => 'control-label']) !!}
                    {!! Form::number('alt_phone_no', old('alt_phone_no'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('alt_phone_no'))
                        <p class="help-block">
                            {{ $errors->first('alt_phone_no') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-4 form-group">
                    {!! Form::label('dob', 'Date Of Birth*', ['class' => 'control-label']) !!}
                      <div class='input-group date'>
                          <input type='text'  name="dob" readonly class="form-control" value="{{ old('dob') ? old('dob') : date('d-m-Y',strtotime($user->dob))}}" id="dob" required/>
                          <span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                      </div>
                      <p class="help-block"></p>
                      @if($errors->has('dob'))
                          <p class="help-block">
                              {{ $errors->first('dob') }}
                          </p>
                      @endif
                </div>
              </div>
              <div class="row">
                <div class="col-xs-4 form-group">
                    {!! Form::label('education', 'Education*', ['class' => 'control-label']) !!}
                    {!! Form::text('education', old('education'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('education'))
                        <p class="help-block">
                            {{ $errors->first('education') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-4 form-group">
                      {!! Form::label('organization_id', 'Organization*', ['class' => 'control-label']) !!}
                      {!! Form::select('organization_id', $orgObj,old('organization_id') ? old('organization_id') : $user->organization_id,['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                      <p class="help-block"></p>
                      @if($errors->has('organization_id'))
                          <p class="help-block">
                              {{ $errors->first('organization_id') }}
                          </p>
                      @endif
                  </div>
                  <div class="col-xs-4 form-group">
                        {!! Form::label('teacher_id', 'Teacher*', ['class' => 'control-label']) !!}
                        {!! Form::select('teacher_id', $teacherObj, old('teacher_id') ? old('teacher_id') : $user->teacher_id,['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                        <p class="help-block"></p>
                        @if($errors->has('teacher_id'))
                            <p class="help-block">
                                {{ $errors->first('teacher_id') }}
                            </p>
                        @endif
                    </div>
            </div>
            <div class="row">

              <div class="col-xs-4 form-group">
                {!! Form::label('address', 'Address*', ['class' => 'control-label']) !!}
                {!! Form::text('address', old('address'),['class' => 'form-control', 'placeholder' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('address'))
                    <p class="help-block">
                        {{ $errors->first('address') }}
                    </p>
                @endif
              </div>
              <div class="col-xs-4 form-group">
                  {!! Form::label('profile_pic','Photo')!!}
                  {!! Form::file('profile_pic',['class'=>'form-control'])!!}
              </div>
              <div class="col-xs-6 form-group">
                @if($user->profile_pic != "")
                  {!! Form::label('current_pic','Current Photo')!!}
                  <div>
                    <img src="{{ env('IMG_URL') }}/img/student/profile/{{ $user->profile_pic }}" onerror="this.src='{{ env('IMG_URL') }}/img/default.png'" id="current_pic" width="100" height="100"/>
                  </div>
                @endif
              </div>
              </div>
              <div class="row">
              <div class="col-xs-12 form-group">
                  {!! Form::label('about', 'About*', ['class' => 'control-label']) !!}
                  {!! Form::textarea('about', old('about'),['class' => 'form-control', 'placeholder' => '']) !!}
                  <p class="help-block"></p>
                  @if($errors->has('about'))
                      <p class="help-block">
                          {{ $errors->first('about') }}
                      </p>
                  @endif
              </div>
            </div>

        </div>
    </div>

    {!! Form::submit(trans('global.app_save'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}

@stop
@section('javascript')

<script type="text/javascript">

    $(function(){
      $('#dob').datepicker({
        format: 'dd-mm-yyyy',
        endDate: '-1d',
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

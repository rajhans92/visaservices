@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.org.title')</h3>
    <form action="{{route('admin.org.store')}}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_create')
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
                    {!! Form::label('established_date', 'Established Date*', ['class' => 'control-label']) !!}
                      <div class='input-group date'>
                          <input type='text'  name="established_date" class="form-control" id="established_date" required/>
                          <span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                      </div>
                      <p class="help-block"></p>
                      @if($errors->has('established_date'))
                          <p class="help-block">
                              {{ $errors->first('established_date') }}
                          </p>
                      @endif
                </div>
              </div>
              <div class="row">
                <div class="col-xs-4 form-group">
                    {!! Form::label('specialties', 'Specialties *', ['class' => 'control-label']) !!}
                    {!! Form::text('specialties', old('specialties'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('specialties'))
                        <p class="help-block">
                            {{ $errors->first('specialties') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-4 form-group">
                    {!! Form::label('website', 'Website', ['class' => 'control-label']) !!}
                    {!! Form::text('website', old('website'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('website'))
                        <p class="help-block">
                            {{ $errors->first('website') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-4 form-group">
                    {!! Form::label('password', 'Password*', ['class' => 'control-label']) !!}
                    {!! Form::password('password', ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('password'))
                        <p class="help-block">
                            {{ $errors->first('password') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
              <div class="col-xs-8 form-group">
                <div class="row">
                  <div class="col-xs-6 form-group">
                      {!! Form::label('teacher_strength', 'Strength of Teacher*', ['class' => 'control-label']) !!}
                      {!! Form::text('teacher_strength', old('teacher_strength'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                      <p class="help-block"></p>
                      @if($errors->has('teacher_strength'))
                          <p class="help-block">
                              {{ $errors->first('teacher_strength') }}
                          </p>
                      @endif
                  </div>
                  <div class="col-xs-6 form-group">
                      {!! Form::label('student_strength', 'Strength of Student*', ['class' => 'control-label']) !!}
                      {!! Form::text('student_strength', old('student_strength'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                      <p class="help-block"></p>
                      @if($errors->has('student_strength'))
                          <p class="help-block">
                              {{ $errors->first('student_strength') }}
                          </p>
                      @endif
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-6 form-group">
                      {!! Form::label('profile_pic','Photo')!!}
                      {!! Form::file('profile_pic',['class'=>'form-control'])!!}
                  </div>
                  <div class="col-xs-6 form-group">
                      {!! Form::label('banner','Organization Banner')!!}
                      {!! Form::file('banner',['class'=>'form-control'])!!}
                  </div>
                </div>
              </div>
              <div class="col-xs-4 form-group">
                {!! Form::label('address', 'Organization Address*', ['class' => 'control-label']) !!}
                {!! Form::textarea('address', old('address'),['class' => 'form-control', 'placeholder' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('address'))
                    <p class="help-block">
                        {{ $errors->first('address') }}
                    </p>
                @endif
              </div>
              </div>
            <div class="row">
              <div class="col-xs-12 form-group">
                  {!! Form::label('overview', 'Organization Overview*', ['class' => 'control-label']) !!}
                  {!! Form::textarea('overview', old('overview'),['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                  <p class="help-block"></p>
                  @if($errors->has('overview'))
                      <p class="help-block">
                          {{ $errors->first('overview') }}
                      </p>
                  @endif
              </div>
            </div>

        </div>
    </div>

    {!! Form::submit(trans('global.app_save'), ['class' => 'btn btn-danger']) !!}
</form>
@stop
@section('javascript')

<script type="text/javascript">

    $(function(){
      $('#established_date').datetimepicker({
        format: 'DD-MM-Y'
      });
    });
</script>

@endsection

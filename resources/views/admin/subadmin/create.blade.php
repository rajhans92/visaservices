@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.subadmin.title')</h3>
    <form action="{{route('admin.subadmin.store')}}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_create') &nbsp;&nbsp;     <a href="{{ route('admin.subadmin.index') }}" class="btn btn-default">@lang('global.app_back_to_list')</a>
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
                    {!! Form::label('dob', 'Date of Birth*', ['class' => 'control-label']) !!}
                      <div class='input-group date'>
                          <input type='text'  name="dob" readonly class="form-control" value="{{old('dob')}}" id="dob" >
                          <span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                        </input>
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
                    {!! Form::label('post', 'Post*', ['class' => 'control-label']) !!}
                    {!! Form::text('post', old('post'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('post'))
                        <p class="help-block">
                            {{ $errors->first('post') }}
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
                <div class="col-xs-4 form-group">
                    {!! Form::label('profile_pic','Photo')!!}
                    {!! Form::file('profile_pic',['class'=>'form-control'])!!}
                </div>
            </div>
            <div class="row">
              <div class="col-xs-12 form-group">
                  {!! Form::label('detail', 'About Admin', ['class' => 'control-label']) !!}
                  {!! Form::textarea('detail', old('detail'),['class' => 'form-control', 'placeholder' => '']) !!}
                  <p class="help-block"></p>
                  @if($errors->has('detail'))
                      <p class="help-block">
                          {{ $errors->first('detail') }}
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
      $('#dob').datepicker({
        format: 'dd-mm-yyyy',
        endDate: '-1d',
      });
    });
</script>

@endsection

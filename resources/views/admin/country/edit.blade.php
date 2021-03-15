@extends('admin.layouts.app')

@section('content')
    <h3 class="page-title">Country</h3>

    {!! Form::model($countryData, ['method' => 'PUT', 'route' => ['admin.country.edit',$countryData->id], 'files'=>true]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
          Edit
        </div>

        <div class="panel-body">
          <div class="row">
              <div class="col-xs-6 form-group">
                @if($countryData->country_flag != "")
                  {!! Form::label('country_flag','Left Image')!!}
                  <div>
                    <img src="{{url('images/country/'.$countryData->country_flag) }}" onerror="this.src='{{ url('images/default.png') }}'" id="img_left" width="100" height="100"/>
                  </div>
                @endif
              </div>
            </div>
          <div class="row">
            <div class="col-xs-4 form-group">
              {!! Form::label('country_flag','Image')!!}
              <div class="input-group date">
                  <input type="file" class='form-control file_name' size="1" name="country_flag" {{$countryData->country_flag == "" ? 'required':""}} accept="image/*" />
              </div>
              <p class="help-block file_name_error">
              </p>
            </div>
            <div class="col-xs-4 form-group">
                {!! Form::label('country_name', 'Country Name*', ['class' => 'control-label']) !!}
                {!! Form::text('country_name', old('country_name'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('country_name'))
                    <p class="help-block">
                        {{ $errors->first('country_name') }}
                    </p>
                @endif
            </div>
          </div>

          <div class="row">
            <div class="col-xs-4 form-group">
                {!! Form::label('country_code', 'Country Code*', ['class' => 'control-label']) !!}
                {!! Form::text('country_code', old('country_code'), ['class' => 'form-control', 'placeholder' => '', 'required' => '','maxlength' => 2]) !!}
                <p class="help-block"></p>
                @if($errors->has('country_code'))
                    <p class="help-block">
                        {{ $errors->first('country_code') }}
                    </p>
                @endif
            </div>
            <div class="col-xs-4 form-group">
                {!! Form::label('', 'Select Popular Visa*', ['class' => 'control-label']) !!}
                <select class="form-control selectpicker multipleSelect" required multiple name="country_popular_visa[]" data-live-search="true" >
                  @foreach($countrylist as $val)
                    <option value="{{$val->country_name}}" {{ in_array($val->country_name, $countrySelectedlist) ? 'selected' : '' }}>{{$val->country_name}}</option>
                  @endforeach
                </select>
            </div>
          </div>

        </div>
    </div>

    {!! Form::submit('Update', ['class' => 'btn btn-danger']) !!}
    <a href="{{ route('admin.country.index') }}" class="btn btn-primary">Cancel</a>
    {!! Form::close() !!}
@stop

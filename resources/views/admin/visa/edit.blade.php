@extends('admin.layouts.app')

@section('content')
    <h3 class="page-title">Visa</h3>

    {!! Form::model($visaData, ['method' => 'PUT', 'route' => ['admin.visa.edit',$visaData->id], 'files'=>true]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
          Edit
        </div>

        <div class="panel-body">
          <div class="row">
              <div class="col-xs-6 form-group">
                @if($visaData->visa_landing_img != "")
                  {!! Form::label('visa_landing_img','Image')!!}
                  <div>
                    <img src="{{url('images/visa/'.$visaData->visa_landing_img) }}" onerror="this.src='{{ url('images/default.png') }}'" id="img_left" width="100" height="100"/>
                  </div>
                @endif
              </div>
            </div>
          <div class="row">
            <div class="col-xs-4 form-group">
              {!! Form::label('visa_landing_img','Image')!!}
              <div class="input-group date">
                  <input type="file" class='form-control file_name' size="1" name="visa_landing_img" accept="image/*" />
              </div>
              <p class="help-block file_name_error">
              </p>
            </div>
            <div class="col-xs-4 form-group">
              {!! Form::label('country_name', 'Select Country*', ['class' => 'control-label']) !!}
              <select class="form-control selectpicker" required name="country_name" value="" >
                  <option value="{{$visaData->country_name}}" selected>{{$visaData->country_name}}</option>
                @foreach($countryData as $key => $val)
                  <option value="{{$val->country_name}}">{{$val->country_name}}</option>
                @endforeach
              </select>
              <p class="help-block"></p>
              @if($errors->has('country_name'))
                  <p class="help-block">
                      {{ $errors->first('country_name') }}
                  </p>
              @endif
            </div>
            <div class="col-xs-4 form-group">
                {!! Form::label('visa_url', 'Page URL*', ['class' => 'control-label']) !!}
                {!! Form::text('visa_url', old('visa_url'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('visa_url'))
                    <p class="help-block">
                        {{ $errors->first('visa_url') }}
                    </p>
                @endif
            </div>

          </div>

          <div class="row">
            <div class="col-xs-4 form-group">
                {!! Form::label('visa_heading', 'Visa Page Heading*', ['class' => 'control-label']) !!}
                {!! Form::text('visa_heading', old('visa_heading'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('visa_heading'))
                    <p class="help-block">
                        {{ $errors->first('visa_heading') }}
                    </p>
                @endif
            </div>
            <div class="col-xs-4 form-group">
                {!! Form::label('visa_content_1', 'Visa Page Content 1*', ['class' => 'control-label']) !!}
                {!! Form::text('visa_content_1', old('visa_content_1'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('visa_content_1'))
                    <p class="help-block">
                        {{ $errors->first('visa_content_1') }}
                    </p>
                @endif
            </div>
            <div class="col-xs-4 form-group">
                {!! Form::label('visa_content_2', 'Visa Page Content 2*', ['class' => 'control-label']) !!}
                {!! Form::text('visa_content_2', old('visa_content_2'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('visa_content_2'))
                    <p class="help-block">
                        {{ $errors->first('visa_content_2') }}
                    </p>
                @endif
            </div>
          </div>

          <div class="row">
            <div class="col-xs-4 form-group">
                {!! Form::label('visa_main_button', 'Visa Apply Button*', ['class' => 'control-label']) !!}
                {!! Form::text('visa_main_button', old('visa_main_button'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('visa_main_button'))
                    <p class="help-block">
                        {{ $errors->first('visa_main_button') }}
                    </p>
                @endif
            </div>
            <div class="col-xs-4 form-group">
                {!! Form::label('visa_faqs', 'Visa Faq Heading*', ['class' => 'control-label']) !!}
                {!! Form::text('visa_faqs', old('visa_faqs'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('visa_faqs'))
                    <p class="help-block">
                        {{ $errors->first('visa_faqs') }}
                    </p>
                @endif
            </div>
            <div class="col-xs-4 form-group">
                {!! Form::label('visa_nationality_title', 'Visa Nationality Title*', ['class' => 'control-label']) !!}
                {!! Form::text('visa_nationality_title', old('visa_nationality_title'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('visa_nationality_title'))
                    <p class="help-block">
                        {{ $errors->first('visa_nationality_title') }}
                    </p>
                @endif
            </div>
          </div>

          <div class="row">
            <div class="col-xs-4 form-group">
              {!! Form::label('visa_type_title', 'Visa Type Title*', ['class' => 'control-label']) !!}
              {!! Form::text('visa_type_title', old('visa_type_title'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
              <p class="help-block"></p>
              @if($errors->has('visa_type_title'))
              <p class="help-block">
                {{ $errors->first('visa_type_title') }}
              </p>
              @endif
            </div>
            <div class="col-xs-4 form-group">
              {!! Form::label('visa_popular_title', 'Visa Popular Title*', ['class' => 'control-label']) !!}
              {!! Form::text('visa_popular_title', old('visa_popular_title'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
              <p class="help-block"></p>
              @if($errors->has('visa_popular_title'))
              <p class="help-block">
                {{ $errors->first('visa_popular_title') }}
              </p>
              @endif
            </div>
          </div>
          <div class="row">
            <div class="col-xs-4 form-group">
              {!! Form::label('reuired_doc', 'Required Documents*', ['class' => 'control-label']) !!}
              <div class="checkbox">
                <label><input type="checkbox" name="isPassportDocRequired" {{$visaData->isPassportDocRequired == 1 ? "checked" :""}} value="1">Passport Document</label>
              </div>
              <div class="checkbox">
                <label><input type="checkbox" name="isApplicantPhotoRequired" {{$visaData->isApplicantPhotoRequired == 1 ? "checked" :""}} value="1">Applicat Photo</label>
              </div>
              <div class="checkbox">
                <label><input type="checkbox" name="isOtherDocRequired" {{$visaData->isOtherDocRequired == 1 ? "checked" :""}} value="1">Other Document</label>
              </div>
            </div>
            <div class="col-xs-4 form-group">
              {!! Form::label('payment_method', 'Payment Method*', ['class' => 'control-label']) !!}
              <select class="form-control selectpicker" required name="payment_method" value="" >
                  <option value="">Select</option>
                  <option value="0" {{$visaData->payment_method == 0 ? "selected" : ""}}>Contact Us</option>
                  <option value="1" {{$visaData->payment_method == 1 ? "selected" : ""}}>Online Payment</option>
              </select>
            </div>
          </div>
        </div>
    </div>

    {!! Form::submit('update', ['class' => 'btn btn-danger']) !!}
    <a href="{{ route('admin.visa.index') }}" class="btn btn-primary">Cancel</a>
    {!! Form::close() !!}
@stop

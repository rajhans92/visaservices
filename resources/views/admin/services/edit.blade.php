@extends('admin.layouts.app')

@section('content')
    <h3 class="page-title">Services</h3>

    {!! Form::model($servicesData, ['method' => 'PUT', 'route' => ['admin.services.edit',$servicesData->id], 'files'=>true]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
          Edit
        </div>

        <div class="panel-body">
          <div class="row">
              <div class="col-xs-6 form-group">
                @if($servicesData->services_landing_img != "")
                  {!! Form::label('services_landing_img','Image')!!}
                  <div>
                    <img src="{{url('images/services/'.$servicesData->services_landing_img) }}" onerror="this.src='{{ url('images/default.png') }}'" id="img_left" width="100" height="100"/>
                  </div>
                @endif
              </div>
            </div>
          <div class="row">
            <div class="col-xs-4 form-group">
              {!! Form::label('services_landing_img','Image')!!}
              <div class="input-group date">
                  <input type="file" class='form-control file_name' size="1" name="services_landing_img" accept="image/*" />
              </div>
              <p class="help-block file_name_error">
              </p>
            </div>
            <div class="col-xs-4 form-group">
              {!! Form::label('services_name', 'Services Name*', ['class' => 'control-label']) !!}
              {!! Form::text('services_name', old('services_name'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
              <p class="help-block"></p>
              @if($errors->has('services_name'))
                  <p class="help-block">
                      {{ $errors->first('services_name') }}
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
                {!! Form::label('services_heading', 'Services Page Heading*', ['class' => 'control-label']) !!}
                {!! Form::text('services_heading', old('services_heading'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('services_heading'))
                    <p class="help-block">
                        {{ $errors->first('services_heading') }}
                    </p>
                @endif
            </div>
            <div class="col-xs-4 form-group">
              {!! Form::label('services_type_title', 'Services Type Title*', ['class' => 'control-label']) !!}
              {!! Form::text('services_type_title', old('services_type_title'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
              <p class="help-block"></p>
              @if($errors->has('services_type_title'))
              <p class="help-block">
                {{ $errors->first('services_type_title') }}
              </p>
              @endif
            </div>
            <div class="col-xs-4 form-group">
              {!! Form::label('services_popular_title', 'Services Popular Title*', ['class' => 'control-label']) !!}
              {!! Form::text('services_popular_title', old('services_popular_title'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
              <p class="help-block"></p>
              @if($errors->has('services_popular_title'))
              <p class="help-block">
                {{ $errors->first('services_popular_title') }}
              </p>
              @endif
            </div>
          </div>

          <div class="row">
            <div class="col-xs-4 form-group">
                {!! Form::label('services_main_button', 'Services Apply Button*', ['class' => 'control-label']) !!}
                {!! Form::text('services_main_button', old('services_main_button'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('services_main_button'))
                    <p class="help-block">
                        {{ $errors->first('services_main_button') }}
                    </p>
                @endif
            </div>
            <div class="col-xs-4 form-group">
                {!! Form::label('services_faqs', 'Services Faq Heading*', ['class' => 'control-label']) !!}
                {!! Form::text('services_faqs', old('services_faqs'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('services_faqs'))
                    <p class="help-block">
                        {{ $errors->first('services_faqs') }}
                    </p>
                @endif
            </div>
            <div class="col-xs-4 form-group">
                {!! Form::label('services_nationality_title', 'Services Nationality Title*', ['class' => 'control-label']) !!}
                {!! Form::text('services_nationality_title', old('services_nationality_title'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('services_nationality_title'))
                    <p class="help-block">
                        {{ $errors->first('services_nationality_title') }}
                    </p>
                @endif
            </div>
          </div>
          <div class="row">
            <div class="col-xs-4 form-group">
                {!! Form::label('meta_title', 'Meta Title*', ['class' => 'control-label']) !!}
                {!! Form::text('meta_title', old('meta_title'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('meta_title'))
                    <p class="help-block">
                        {{ $errors->first('meta_title') }}
                    </p>
                @endif
            </div>
            <div class="col-xs-4 form-group">
                {!! Form::label('meta_description', 'Meta Description*', ['class' => 'control-label']) !!}
                {!! Form::text('meta_description', old('meta_description'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('meta_description'))
                    <p class="help-block">
                        {{ $errors->first('meta_description') }}
                    </p>
                @endif
            </div>
            <div class="col-xs-4 form-group">
                {!! Form::label('meta_keywords', 'Meta Keywords', ['class' => 'control-label']) !!}
                {!! Form::text('meta_keywords', old('meta_keywords'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('meta_keywords'))
                    <p class="help-block">
                        {{ $errors->first('meta_keywords') }}
                    </p>
                @endif
            </div>
          </div>

          <div class="row">
            <div class="col-xs-4 form-group">
                {!! Form::label('standard_time_duration', 'Standard Time Duration*', ['class' => 'control-label']) !!}
                {!! Form::text('standard_time_duration', old('standard_time_duration'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('standard_time_duration'))
                    <p class="help-block">
                        {{ $errors->first('standard_time_duration') }}
                    </p>
                @endif
            </div>
            <div class="col-xs-4 form-group">
                {!! Form::label('rush_time_duration', 'Rush Time Duration*', ['class' => 'control-label']) !!}
                {!! Form::text('rush_time_duration', old('rush_time_duration'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('rush_time_duration'))
                    <p class="help-block">
                        {{ $errors->first('rush_time_duration') }}
                    </p>
                @endif
            </div>
            <div class="col-xs-4 form-group">
                {!! Form::label('express_time_duration', 'Express Time Duration*', ['class' => 'control-label']) !!}
                {!! Form::text('express_time_duration', old('express_time_duration'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('express_time_duration'))
                    <p class="help-block">
                        {{ $errors->first('express_time_duration') }}
                    </p>
                @endif
            </div>
          </div>

          <div class="row">
            <div class="col-xs-4 form-group">
                {!! Form::label('whatsapp_number', 'Whatsapp Number*', ['class' => 'control-label']) !!}
                {!! Form::text('whatsapp_number', old('whatsapp_number'), ['class' => 'form-control',"maxlength"=>14, 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('whatsapp_number'))
                    <p class="help-block">
                        {{ $errors->first('whatsapp_number') }}
                    </p>
                @endif
            </div>
            <div class="col-xs-4 form-group">
                {!! Form::label('whatsapp_text', 'Whatsapp Text*', ['class' => 'control-label']) !!}
                {!! Form::text('whatsapp_text', old('whatsapp_text'), ['class' => 'form-control',"maxlength"=>250, 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('whatsapp_text'))
                    <p class="help-block">
                        {{ $errors->first('whatsapp_text') }}
                    </p>
                @endif
            </div>
            <div class="col-xs-4 form-group">
                {!! Form::label('whatsapp_status', 'Show Whatsapp No.*', ['class' => 'control-label']) !!}
                <select name="whatsapp_status" class="form-control whatsapp_status">
                   <option value="0" {{$servicesData->whatsapp_status == 0 ? "selected":""}}>No</option>
                   <option value="1" {{$servicesData->whatsapp_status == 1 ? "selected":""}}>Yes</option>
                </select>
                <p class="help-block"></p>
                @if($errors->has('whatsapp_status'))
                    <p class="help-block">
                        {{ $errors->first('whatsapp_status') }}
                    </p>
                @endif
            </div>
          </div>

          <div class="row">
            <div class="col-xs-4 form-group">
                {!! Form::label('call_number', 'Support Number*', ['class' => 'control-label']) !!}
                {!! Form::text('call_number', old('call_number'), ['class' => 'form-control','maxlength'=>'14', 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('call_number'))
                    <p class="help-block">
                        {{ $errors->first('call_number') }}
                    </p>
                @endif
            </div>
            <div class="col-xs-4 form-group">
                {!! Form::label('call_status', 'Show Support No.*', ['class' => 'control-label']) !!}
                <select name="call_status" class="form-control whatsapp_status">
                   <option value="0" {{$servicesData->call_status == 0 ? "selected":""}}>No</option>
                   <option value="1" {{$servicesData->call_status == 1 ? "selected":""}}>Yes</option>
                </select>
                <p class="help-block"></p>
                @if($errors->has('call_status'))
                    <p class="help-block">
                        {{ $errors->first('call_status') }}
                    </p>
                @endif
            </div>
            <div class="col-xs-4 form-group">
              {!! Form::label('reuired_doc', 'Required Documents*', ['class' => 'control-label']) !!}
              <div class="checkbox">
                <label><input type="checkbox" name="isPassportDocRequired" {{$servicesData->isPassportDocRequired == 1 ? "checked" :""}} value="1">Passport Document</label>
              </div>
              <div class="checkbox">
                <label><input type="checkbox" name="isApplicantPhotoRequired" {{$servicesData->isApplicantPhotoRequired == 1 ? "checked" :""}} value="1">Applicat Photo</label>
              </div>
              <div class="checkbox">
                <label><input type="checkbox" name="isOtherDocRequired" {{$servicesData->isOtherDocRequired == 1 ? "checked" :""}} value="1">Other Document</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-4 form-group">
              {!! Form::label('payment_method', 'Payment Method*', ['class' => 'control-label']) !!}
              <select class="form-control selectpicker" required name="payment_method" value="" >
                  <option value="">Select</option>
                  <option value="0" {{$servicesData->payment_method == 0 ? "selected" : ""}}>Contact Us</option>
                  <option value="1" {{$servicesData->payment_method == 1 ? "selected" : ""}}>Online Payment</option>
              </select>
            </div>
            <div class="col-xs-4 form-group">
              {!! Form::label('is_price_show', 'Is Price Show*', ['class' => 'control-label']) !!}
              <select class="form-control selectpicker" required name="is_price_show" value="" >
                  <option value="" >Select</option>
                  <option value="1" {{$servicesData->is_price_show == 1 ? "selected" : ""}}>Yes</option>
                  <option value="0" {{$servicesData->is_price_show == 0 ? "selected" : ""}}>No</option>
              </select>
            </div>
            <div class="col-xs-4 form-group">
              {!! Form::label('is_govt_apply', 'Is Govt Apply*', ['class' => 'control-label']) !!}
              <select class="form-control selectpicker" required name="is_govt_apply" value="" >
                  <option value="" >Select</option>
                  <option value="0" {{$servicesData->is_govt_apply == 0 ? "selected" : ""}}>No</option>
                  <option value="1" {{$servicesData->is_govt_apply == 1 ? "selected" : ""}}>Yes</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-6 form-group">
                {!! Form::label('services_content_1', 'Services Page Content 1*', ['class' => 'control-label']) !!}
                {!! Form::textarea('services_content_1', old('services_content_1'), ['class' => 'form-control tinymceEditor', 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('services_content_1'))
                    <p class="help-block">
                        {{ $errors->first('services_content_1') }}
                    </p>
                @endif
            </div>
            <div class="col-xs-6 form-group">
                {!! Form::label('services_content_2', 'Services Page Content 2*', ['class' => 'control-label']) !!}
                {!! Form::textarea('services_content_2', old('services_content_2'), ['class' => 'form-control tinymceEditor', 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('services_content_2'))
                    <p class="help-block">
                        {{ $errors->first('services_content_2') }}
                    </p>
                @endif
            </div>
          </div>
        </div>
    </div>

    {!! Form::submit('update', ['class' => 'btn btn-danger']) !!}
    <a href="{{ route('admin.services.index') }}" class="btn btn-primary">Cancel</a>
    {!! Form::close() !!}
@stop

@extends('admin.layouts.app')

@section('content')
    <h3 class="page-title">Blog</h3>

    {!! Form::model($blogData, ['method' => 'POST', 'route' => ['admin.blog.create'], 'files'=>true]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
          Create
        </div>

        <div class="panel-body">

          <div class="row">
            <div class="col-xs-4 form-group">
              {!! Form::label('blog_category_id', 'Blog Category Name*', ['class' => 'control-label']) !!}
              <select class="form-control selectpicker" required name="blog_category_id" value="" >
                  <option value="" >Select</option>
                  @foreach($categoryList as $val)
                    <option value="{{$val->id}}">{{$val->name}}</option>
                  @endforeach
              </select>
            </div>
            <div class="col-xs-4 form-group">
              {!! Form::label('blog_name', 'Blog Name*', ['class' => 'control-label']) !!}
              {!! Form::text('blog_name', old('blog_name'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
              <p class="help-block"></p>
              @if($errors->has('blog_name'))
                  <p class="help-block">
                      {{ $errors->first('blog_name') }}
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
                {!! Form::label('blog_heading', 'Blog Page Heading*', ['class' => 'control-label']) !!}
                {!! Form::text('blog_heading', old('blog_heading'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('blog_heading'))
                    <p class="help-block">
                        {{ $errors->first('blog_heading') }}
                    </p>
                @endif
            </div>

            <div class="col-xs-4 form-group">
              {!! Form::label('landing_img','Image')!!}
              <div class="input-group date">
                  <input type="file" class='form-control file_name' size="1" name="landing_img" required accept="image/*" />
              </div>
              <p class="help-block file_name_error">
              </p>
            </div>

            <div class="col-xs-4 form-group">
              {!! Form::label('main_button_url', 'Apply Button Url*', ['class' => 'control-label']) !!}
              <select class="form-control selectpicker" required name="main_button_url" value="" >
                  <option value="" >Select</option>
                  @foreach($routeList as $val)
                    <option value="{{$val->visa_url}}">{{$val->visa_url}}</option>
                  @endforeach
              </select>
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
                   <option value="0">No</option>
                   <option value="1">Yes</option>
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
                   <option value="0">No</option>
                   <option value="1">Yes</option>
                </select>
                <p class="help-block"></p>
                @if($errors->has('call_status'))
                    <p class="help-block">
                        {{ $errors->first('call_status') }}
                    </p>
                @endif
            </div>
          </div>
          <div class="row">
            <div class="col-xs-6 form-group">
                {!! Form::label('content_1', 'Page Content 1*', ['class' => 'control-label']) !!}
                {!! Form::textarea('content_1', old('content_1'), ['class' => 'form-control', 'placeholder' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('content_1'))
                    <p class="help-block">
                        {{ $errors->first('content_1') }}
                    </p>
                @endif
            </div>
            <div class="col-xs-6 form-group">
                {!! Form::label('content_2', 'Page Content 2*', ['class' => 'control-label']) !!}
                {!! Form::textarea('content_2', old('content_2'), ['class' => 'form-control', 'placeholder' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('content_2'))
                    <p class="help-block">
                        {{ $errors->first('content_2') }}
                    </p>
                @endif
            </div>
          </div>

        </div>
    </div>

    {!! Form::submit('Add', ['class' => 'btn btn-danger']) !!}
    <a href="{{ route('admin.blog.index') }}" class="btn btn-primary">Cancel</a>
    {!! Form::close() !!}
@stop

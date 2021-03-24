@extends('admin.layouts.app')

@section('content')
    <h3 class="page-title">Home</h3>

    {!! Form::model($homeData, ['method' => 'PUT', 'route' => ['admin.home.sectionSearchUpdate', $homeData->language_id], 'files'=>true]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
          Search Section Edit
        </div>

        <div class="panel-body">
          @if($homeData->main_img != "")
            <div class="row">
                <div class="col-xs-3 form-group">
                    {!! Form::label('img','Image')!!}
                    <div>
                      <img src="{{url('images/home/'.$homeData->main_img) }}" onerror="this.src='{{ url('images/default.png') }}'" id="img_left" width="100" height="100"/>
                    </div>
                </div>
            </div>
          @endif
          <div class="row">
            <div class="col-xs-3 form-group">
              {!! Form::label('main_img','Image')!!}
              <div class="input-group date">
                <input type="hidden"  name="file_delete" id="file_delete" value="0" />
                  <input type="file" class='form-control file_name' size="1" name="main_img" accept="image/*" />
                  <span class="input-group-addon">
                      <span class="glyphicon glyphicon-remove" id="file_remove" style="{{$homeData->main_img != "" ? 'display:inline-block':'display:none'}};">
                      </span>
                      <span class="glyphicon glyphicon-upload" id="file_upload" style="{{$homeData->main_img != "" ? 'display:none':'display:inline-block'}};">
                      </span>
                  </span>
              </div>
              <p class="help-block file_name_error">
              </p>
            </div>
            <div class="col-xs-3 form-group">
                {!! Form::label('main_title_1', 'Heading Title 1*', ['class' => 'control-label']) !!}
                {!! Form::text('main_title_1', old('main_title_1'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('main_title_1'))
                    <p class="help-block">
                        {{ $errors->first('main_title_1') }}
                    </p>
                @endif
            </div>
            <div class="col-xs-3 form-group">
                {!! Form::label('main_title_2', 'Heading Title 2*', ['class' => 'control-label']) !!}
                {!! Form::text('main_title_2', old('main_title_2'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('main_title_2'))
                    <p class="help-block">
                        {{ $errors->first('main_title_2') }}
                    </p>
                @endif
            </div>
          </div>

          <div class="row">
            <div class="col-xs-6 form-group">
                {!! Form::label('dropdown_1', 'Dropdown Title(where am i from?)*', ['class' => 'control-label']) !!}
                {!! Form::text('dropdown_1', old('dropdown_1'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('dropdown_1'))
                    <p class="help-block">
                        {{ $errors->first('dropdown_1') }}
                    </p>
                @endif
            </div>
            <div class="col-xs-6 form-group">
                {!! Form::label('dropdown_2', 'Dropdown Title(where am i go?)*', ['class' => 'control-label']) !!}
                {!! Form::text('dropdown_2', old('dropdown_2'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('dropdown_1'))
                    <p class="help-block">
                        {{ $errors->first('dropdown_1') }}
                    </p>
                @endif
            </div>
          </div>

          <div class="row">
            <div class="col-xs-6 form-group">
                {!! Form::label('main_button_name', 'Button Title(Apply)*', ['class' => 'control-label']) !!}
                {!! Form::text('main_button_name', old('main_button_name'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('main_button_name'))
                    <p class="help-block">
                        {{ $errors->first('main_button_name') }}
                    </p>
                @endif
            </div>
          </div>
          <div class="row">
            <div class="col-xs-6 form-group">
                {!! Form::label('popular', 'Suggestion Main Tag(Popular)*', ['class' => 'control-label']) !!}
                {!! Form::text('popular', old('popular'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('popular'))
                    <p class="help-block">
                        {{ $errors->first('popular') }}
                    </p>
                @endif
            </div>
          </div>
              <div class="row">
                <div class="col-xs-3 form-group">
                    {!! Form::label('title_1', 'Suggestion Tag*', ['class' => 'control-label']) !!}
                    {!! Form::text('title_1', $homeData->title_1, ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('title_1'))
                        <p class="help-block">
                            {{ $errors->first('title_1') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-3 form-group">
                    {!! Form::label('link_1', 'Select Link*', ['class' => 'control-label']) !!}
                    <select class="form-control selectpicker" required name="link_1" value="" >
                      @foreach($urlSet as $key => $val)
                        <option value="{{$key}}" {{ $key == $homeData->link_1 ? 'selected' : '' }}>{{$val}}</option>
                      @endforeach
                    </select>
                    <p class="help-block"></p>
                    @if($errors->has('link_1'))
                        <p class="help-block">
                            {{ $errors->first('link_1') }}
                        </p>
                    @endif
                </div>

              </div>

              <div class="row">
                <div class="col-xs-3 form-group">
                    {!! Form::label('title_2', 'Suggestion Tag*', ['class' => 'control-label']) !!}
                    {!! Form::text('title_2', $homeData->title_2, ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('title_2'))
                        <p class="help-block">
                            {{ $errors->first('title_2') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-3 form-group">
                    {!! Form::label('link_2', 'Select Link*', ['class' => 'control-label']) !!}
                    <select class="form-control selectpicker" required name="link_2" value="" >
                      @foreach($urlSet as $key => $val)
                        <option value="{{$key}}" {{ $key == $homeData->link_2 ? 'selected' : '' }}>{{$val}}</option>
                      @endforeach
                    </select>
                    <p class="help-block"></p>
                    @if($errors->has('link_2'))
                        <p class="help-block">
                            {{ $errors->first('link_2') }}
                        </p>
                    @endif
                </div>

              </div>

              <div class="row">
                <div class="col-xs-3 form-group">
                    {!! Form::label('title_3', 'Suggestion Tag*', ['class' => 'control-label']) !!}
                    {!! Form::text('title_3', $homeData->title_3, ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('title_3'))
                        <p class="help-block">
                            {{ $errors->first('title_3') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-3 form-group">
                    {!! Form::label('link_3', 'Select Link*', ['class' => 'control-label']) !!}
                    <select class="form-control selectpicker" required name="link_3" value="" >
                      @foreach($urlSet as $key => $val)
                        <option value="{{$key}}" {{ $key == $homeData->link_3 ? 'selected' : '' }}>{{$val}}</option>
                      @endforeach
                    </select>
                    <p class="help-block"></p>
                    @if($errors->has('link_3'))
                        <p class="help-block">
                            {{ $errors->first('link_3') }}
                        </p>
                    @endif
                </div>


              </div>

              <div class="row">
                <div class="col-xs-3 form-group">
                    {!! Form::label('title_4', 'Suggestion Tag*', ['class' => 'control-label']) !!}
                    {!! Form::text('title_4', $homeData->title_4, ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('title_4'))
                        <p class="help-block">
                            {{ $errors->first('title_4') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-3 form-group">
                    {!! Form::label('link_4', 'Select Link*', ['class' => 'control-label']) !!}
                    <select class="form-control selectpicker" required name="link_4" value="" >
                      @foreach($urlSet as $key => $val)
                        <option value="{{$key}}" {{ $key == $homeData->link_4 ? 'selected' : '' }}>{{$val}}</option>
                      @endforeach
                    </select>
                    <p class="help-block"></p>
                    @if($errors->has('link_4'))
                        <p class="help-block">
                            {{ $errors->first('link_4') }}
                        </p>
                    @endif
                </div>

              </div>

        </div>
    </div>

    {!! Form::submit('Update', ['class' => 'btn btn-danger']) !!}
    <a href="{{ route('admin.home.index') }}" class="btn btn-primary">Cancel</a>
    {!! Form::close() !!}
@stop

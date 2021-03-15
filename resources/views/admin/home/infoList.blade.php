@extends('admin.layouts.app')

@section('content')
    <h3 class="page-title">Home</h3>

    {!! Form::model($homeData, ['method' => 'PUT', 'route' => ['admin.home.infoUpdate', $homeData->language_id], 'files'=>true]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
          Client Review Edit
        </div>

        <div class="panel-body">
          @if($homeData->info_img != "")
            <div class="row">
                <div class="col-xs-6 form-group">
                    {!! Form::label('img','Image')!!}
                    <div>
                      <img src="{{url('images/home/'.$homeData->info_img) }}" onerror="this.src='{{ url('images/default.png') }}'" id="img_left" width="100" height="100"/>
                    </div>
                </div>
            </div>
          @endif
          <div class="row">
            <div class="col-xs-3 form-group">
              {!! Form::label('info_img','Image')!!}
              <div class="input-group date">
                <input type="hidden"  name="file_delete" id="file_delete" value="0" />
                  <input type="file" class='form-control file_name' size="1" name="info_img" accept="image/*" />
                  <span class="input-group-addon">
                      <span class="glyphicon glyphicon-remove" id="file_remove" style="{{$homeData->info_img != "" ? 'display:inline-block':'display:none'}};">
                      </span>
                      <span class="glyphicon glyphicon-upload" id="file_upload" style="{{$homeData->info_img != "" ? 'display:none':'display:inline-block'}};">
                      </span>
                  </span>
              </div>
              <p class="help-block file_name_error">
              </p>
            </div>
            <div class="col-xs-6 form-group">
                {!! Form::label('info_title', 'Info Heading Title*', ['class' => 'control-label']) !!}
                {!! Form::text('info_title', old('info_title'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('info_title'))
                    <p class="help-block">
                        {{ $errors->first('info_title') }}
                    </p>
                @endif
            </div>
          </div>

              <div class="row">
                <div class="col-xs-3 form-group">
                    {!! Form::label('title_1', 'Title*', ['class' => 'control-label']) !!}
                    {!! Form::text('title_1', $homeData->title_1, ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('title_1'))
                        <p class="help-block">
                            {{ $errors->first('title_1') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-3 form-group">
                    {!! Form::label('content_1', 'Content*', ['class' => 'control-label']) !!}
                    {!! Form::text('content_1', $homeData->content_1, ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('content_1'))
                        <p class="help-block">
                            {{ $errors->first('content_1') }}
                        </p>
                    @endif
                </div>

              </div>

              <div class="row">
                <div class="col-xs-3 form-group">
                    {!! Form::label('title_2', 'Title*', ['class' => 'control-label']) !!}
                    {!! Form::text('title_2', $homeData->title_2, ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('title_2'))
                        <p class="help-block">
                            {{ $errors->first('title_2') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-3 form-group">
                    {!! Form::label('content_2', 'Content*', ['class' => 'control-label']) !!}
                    {!! Form::text('content_2', $homeData->content_2, ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('content_2'))
                        <p class="help-block">
                            {{ $errors->first('content_2') }}
                        </p>
                    @endif
                </div>

              </div>

              <div class="row">
                <div class="col-xs-3 form-group">
                    {!! Form::label('title_3', 'Title*', ['class' => 'control-label']) !!}
                    {!! Form::text('title_3', $homeData->title_3, ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('title_3'))
                        <p class="help-block">
                            {{ $errors->first('title_3') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-3 form-group">
                    {!! Form::label('content_3', 'Content*', ['class' => 'control-label']) !!}
                    {!! Form::text('content_3', $homeData->content_3, ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('content_3'))
                        <p class="help-block">
                            {{ $errors->first('content_3') }}
                        </p>
                    @endif
                </div>

              </div>

              <div class="row">
                <div class="col-xs-3 form-group">
                    {!! Form::label('title_4', 'Title*', ['class' => 'control-label']) !!}
                    {!! Form::text('title_4', $homeData->title_4, ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('title_4'))
                        <p class="help-block">
                            {{ $errors->first('title_4') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-3 form-group">
                    {!! Form::label('content_4', 'Content*', ['class' => 'control-label']) !!}
                    {!! Form::text('content_4', $homeData->content_4, ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('content_4'))
                        <p class="help-block">
                            {{ $errors->first('content_4') }}
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

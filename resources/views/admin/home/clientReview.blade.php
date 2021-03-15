@extends('admin.layouts.app')

@section('content')
    <h3 class="page-title">Home</h3>

    {!! Form::model($homeData, ['method' => 'PUT', 'route' => ['admin.home.clientReview', $homeData->language_id], 'files'=>true]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
          Client Review Edit
        </div>

        <div class="panel-body">
          <div class="row">
            <div class="col-xs-6 form-group">
                {!! Form::label('section_4_title', 'Review Heading*', ['class' => 'control-label']) !!}
                {!! Form::text('section_4_title', old('section_4_title'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('section_4_title'))
                    <p class="help-block">
                        {{ $errors->first('section_4_title') }}
                    </p>
                @endif
            </div>
          </div>
              @if($homeData->client_img_1 != "")
                <div class="row">
                    <div class="col-xs-6 form-group">
                        {!! Form::label('img','Image')!!}
                        <div>
                          <img src="{{url('images/home/'.$homeData->client_img_1) }}" onerror="this.src='{{ url('images/default.png') }}'" id="img_left" width="100" height="100"/>
                        </div>
                    </div>
                </div>
              @endif
              <div class="row">
                <div class="col-xs-3 form-group">
                  {!! Form::label('client_img_1','Image')!!}
                  <div class="input-group date">
                    <input type="hidden"  name="file_delete" id="file_delete" value="0" />
                      <input type="file" class='form-control file_name' size="1" name="client_img_1" accept="image/*" />
                      <span class="input-group-addon">
                          <span class="glyphicon glyphicon-remove" id="file_remove" style="{{$homeData->client_img_1 != "" ? 'display:inline-block':'display:none'}};">
                          </span>
                          <span class="glyphicon glyphicon-upload" id="file_upload" style="{{$homeData->client_img_1 != "" ? 'display:none':'display:inline-block'}};">
                          </span>
                      </span>
                  </div>
                  <p class="help-block file_name_error">
                  </p>
                </div>
                <div class="col-xs-3 form-group">
                    {!! Form::label('client_name_1', 'Client Name*', ['class' => 'control-label']) !!}
                    {!! Form::text('client_name_1', $homeData->client_name_1, ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('client_name_1'))
                        <p class="help-block">
                            {{ $errors->first('client_name_1') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-3 form-group">
                    {!! Form::label('client_review_1', 'Client Review*', ['class' => 'control-label']) !!}
                    {!! Form::text('client_review_1', $homeData->client_review_1, ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('content_1'))
                        <p class="help-block">
                            {{ $errors->first('content_1') }}
                        </p>
                    @endif
                </div>
              </div>


              @if($homeData->client_img_2 != "")
                <div class="row">
                    <div class="col-xs-6 form-group">
                        {!! Form::label('client_img_2','Image')!!}
                        <div>
                          <img src="{{url('images/home/'.$homeData->client_img_2) }}" onerror="this.src='{{ url('images/default.png') }}'" id="img_left" width="100" height="100"/>
                        </div>
                    </div>
                </div>
              @endif
              <div class="row">
                <div class="col-xs-3 form-group">
                  {!! Form::label('client_img_2','Image')!!}
                  <div class="input-group date">
                    <input type="hidden"  name="file_delete" id="file_delete" value="0" />
                      <input type="file" class='form-control file_name' size="1" name="client_img_2" accept="image/*" />
                      <span class="input-group-addon">
                          <span class="glyphicon glyphicon-remove" id="file_remove" style="{{$homeData->client_img_2 != "" ? 'display:inline-block':'display:none'}};">
                          </span>
                          <span class="glyphicon glyphicon-upload" id="file_upload" style="{{$homeData->client_img_2 != "" ? 'display:none':'display:inline-block'}};">
                          </span>
                      </span>
                  </div>
                  <p class="help-block file_name_error">
                  </p>
                </div>
                <div class="col-xs-3 form-group">
                    {!! Form::label('client_name_2', 'Client Name*', ['class' => 'control-label']) !!}
                    {!! Form::text('client_name_2', $homeData->client_name_2, ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('client_name_2'))
                        <p class="help-block">
                            {{ $errors->first('client_name_2') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-3 form-group">
                    {!! Form::label('client_review_2', 'Client Review*', ['class' => 'control-label']) !!}
                    {!! Form::text('client_review_2', $homeData->client_review_2, ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('content_2'))
                        <p class="help-block">
                            {{ $errors->first('content_2') }}
                        </p>
                    @endif
                </div>
              </div>

              @if($homeData->client_img_3 != "")
              <div class="row">
                <div class="col-xs-6 form-group">
                  {!! Form::label('client_img_3','Image')!!}
                  <div>
                    <img src="{{url('images/home/'.$homeData->client_img_3) }}" onerror="this.src='{{ url('images/default.png') }}'" id="img_left" width="100" height="100"/>
                  </div>
                </div>
              </div>
              @endif
              <div class="row">
                <div class="col-xs-3 form-group">
                  {!! Form::label('client_img_3','Image')!!}
                  <div class="input-group date">
                    <input type="hidden"  name="file_delete" id="file_delete" value="0" />
                    <input type="file" class='form-control file_name' size="1" name="client_img_3" accept="image/*" />
                    <span class="input-group-addon">
                      <span class="glyphicon glyphicon-remove" id="file_remove" style="{{$homeData->client_img_3 != "" ? 'display:inline-block':'display:none'}};">
                      </span>
                      <span class="glyphicon glyphicon-upload" id="file_upload" style="{{$homeData->client_img_3 != "" ? 'display:none':'display:inline-block'}};">
                      </span>
                    </span>
                  </div>
                  <p class="help-block file_name_error">
                  </p>
                </div>
                <div class="col-xs-3 form-group">
                  {!! Form::label('client_name_3', 'Client Name*', ['class' => 'control-label']) !!}
                  {!! Form::text('client_name_3', $homeData->client_name_3, ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                  <p class="help-block"></p>
                  @if($errors->has('client_name_3'))
                  <p class="help-block">
                    {{ $errors->first('client_name_3') }}
                  </p>
                  @endif
                </div>
                <div class="col-xs-3 form-group">
                  {!! Form::label('client_review_3', 'Client Review*', ['class' => 'control-label']) !!}
                  {!! Form::text('client_review_3', $homeData->client_review_3, ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                  <p class="help-block"></p>
                  @if($errors->has('content_3'))
                  <p class="help-block">
                    {{ $errors->first('content_3') }}
                  </p>
                  @endif
                </div>
              </div>

              @if($homeData->client_img_4 != "")
              <div class="row">
                <div class="col-xs-6 form-group">
                  {!! Form::label('client_img_4','Image')!!}
                  <div>
                    <img src="{{url('images/home/'.$homeData->client_img_4) }}" onerror="this.src='{{ url('images/default.png') }}'" id="img_left" width="100" height="100"/>
                  </div>
                </div>
              </div>
              @endif
              <div class="row">
                <div class="col-xs-3 form-group">
                  {!! Form::label('client_img_4','Image')!!}
                  <div class="input-group date">
                    <input type="hidden"  name="file_delete" id="file_delete" value="0" />
                    <input type="file" class='form-control file_name' size="1" name="client_img_4" accept="image/*" />
                    <span class="input-group-addon">
                      <span class="glyphicon glyphicon-remove" id="file_remove" style="{{$homeData->client_img_4 != "" ? 'display:inline-block':'display:none'}};">
                      </span>
                      <span class="glyphicon glyphicon-upload" id="file_upload" style="{{$homeData->client_img_4 != "" ? 'display:none':'display:inline-block'}};">
                      </span>
                    </span>
                  </div>
                  <p class="help-block file_name_error">
                  </p>
                </div>
                <div class="col-xs-3 form-group">
                  {!! Form::label('client_name_4', 'Client Name*', ['class' => 'control-label']) !!}
                  {!! Form::text('client_name_4', $homeData->client_name_4, ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                  <p class="help-block"></p>
                  @if($errors->has('client_name_4'))
                  <p class="help-block">
                    {{ $errors->first('client_name_4') }}
                  </p>
                  @endif
                </div>
                <div class="col-xs-3 form-group">
                  {!! Form::label('client_review_4', 'Client Review*', ['class' => 'control-label']) !!}
                  {!! Form::text('client_review_4', $homeData->client_review_4, ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
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

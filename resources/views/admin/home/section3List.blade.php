@extends('admin.layouts.app')

@section('content')
    <h3 class="page-title">Home</h3>

    {!! Form::model($homeData, ['method' => 'PUT', 'route' => ['admin.home.section3Update', $homeData->language_id], 'files'=>true]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
          Section 3 Edit
        </div>

        <div class="panel-body">
          <div class="row">
            <div class="col-xs-6 form-group">
                {!! Form::label('section_3_title', 'Section Heading*', ['class' => 'control-label']) !!}
                {!! Form::text('section_3_title', old('section_3_title'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('section_3_title'))
                    <p class="help-block">
                        {{ $errors->first('section_3_title') }}
                    </p>
                @endif
            </div>
          </div>
              @if($homeData->img_1 != "")
                <div class="row">
                    <div class="col-xs-6 form-group">
                        {!! Form::label('img','Image')!!}
                        <div>
                          <img src="{{url('images/home/'.$homeData->img_1) }}" onerror="this.src='{{ url('images/default.png') }}'" id="img_left" width="100" height="100"/>
                        </div>
                    </div>
                </div>
              @endif
              <div class="row">
                <div class="col-xs-3 form-group">
                  {!! Form::label('img_1','Image')!!}
                  <div class="input-group date">
                    <input type="hidden"  name="file_delete" id="file_delete" value="0" />
                      <input type="file" class='form-control file_name' size="1" name="img_1" accept="image/*" />
                      <span class="input-group-addon">
                          <span class="glyphicon glyphicon-remove" id="file_remove" style="{{$homeData->img_1 != "" ? 'display:inline-block':'display:none'}};">
                          </span>
                          <span class="glyphicon glyphicon-upload" id="file_upload" style="{{$homeData->img_1 != "" ? 'display:none':'display:inline-block'}};">
                          </span>
                      </span>
                  </div>
                  <p class="help-block file_name_error">
                  </p>
                </div>
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
                    {!! Form::label('link_1', 'Select Link*', ['class' => 'control-label']) !!}
                    <select class="form-control selectpicker" required name="link_1" value="" >
                      @foreach($urlSet as $key => $val)
                        <option value="{{$val}}" {{ $val == $homeData->link_1 ? 'selected' : '' }}>{{$val}}</option>
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


              @if($homeData->img_2 != "")
                <div class="row">
                    <div class="col-xs-6 form-group">
                        {!! Form::label('img','Image')!!}
                        <div>
                          <img src="{{url('images/home/'.$homeData->img_2) }}" onerror="this.src='{{ url('images/default.png') }}'" id="img_left" width="100" height="100"/>
                        </div>
                    </div>
                </div>
              @endif
              <div class="row">
                <div class="col-xs-3 form-group">
                  {!! Form::label('img_2','Image')!!}
                  <div class="input-group date">
                    <input type="hidden"  name="file_delete" id="file_delete" value="0" />
                      <input type="file" class='form-control file_name' size="1" name="img_2" accept="image/*" />
                      <span class="input-group-addon">
                          <span class="glyphicon glyphicon-remove" id="file_remove" style="{{$homeData->img_2 != "" ? 'display:inline-block':'display:none'}};">
                          </span>
                          <span class="glyphicon glyphicon-upload" id="file_upload" style="{{$homeData->img_2 != "" ? 'display:none':'display:inline-block'}};">
                          </span>
                      </span>
                  </div>
                  <p class="help-block file_name_error">
                  </p>
                </div>
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
                    {!! Form::label('link_2', 'Select Link*', ['class' => 'control-label']) !!}
                    <select class="form-control selectpicker" required name="link_2" value="" >
                      @foreach($urlSet as $key => $val)
                        <option value="{{$val}}" {{ $val == $homeData->link_2 ? 'selected' : '' }}>{{$val}}</option>
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

              @if($homeData->img_3 != "")
              <div class="row">
                <div class="col-xs-6 form-group">
                  {!! Form::label('img','Image')!!}
                  <div>
                    <img src="{{url('images/home/'.$homeData->img_3) }}" onerror="this.src='{{ url('images/default.png') }}'" id="img_left" width="100" height="100"/>
                  </div>
                </div>
              </div>
              @endif
              <div class="row">
                <div class="col-xs-3 form-group">
                  {!! Form::label('img_3','Image')!!}
                  <div class="input-group date">
                    <input type="hidden"  name="file_delete" id="file_delete" value="0" />
                    <input type="file" class='form-control file_name' size="1" name="img_3" accept="image/*" />
                    <span class="input-group-addon">
                      <span class="glyphicon glyphicon-remove" id="file_remove" style="{{$homeData->img_3 != "" ? 'display:inline-block':'display:none'}};">
                      </span>
                      <span class="glyphicon glyphicon-upload" id="file_upload" style="{{$homeData->img_3 != "" ? 'display:none':'display:inline-block'}};">
                      </span>
                    </span>
                  </div>
                  <p class="help-block file_name_error">
                  </p>
                </div>
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
                    {!! Form::label('link_3', 'Select Link*', ['class' => 'control-label']) !!}
                    <select class="form-control selectpicker" required name="link_3" value="" >
                      @foreach($urlSet as $key => $val)
                        <option value="{{$val}}" {{ $val == $homeData->link_3 ? 'selected' : '' }}>{{$val}}</option>
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




        </div>
    </div>

    {!! Form::submit('Update', ['class' => 'btn btn-danger']) !!}
    <a href="{{ route('admin.footer.index') }}" class="btn btn-primary">Cancel</a>
    {!! Form::close() !!}
@stop

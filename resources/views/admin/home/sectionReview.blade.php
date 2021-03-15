@extends('admin.layouts.app')

@section('content')
    <h3 class="page-title">Home</h3>

    {!! Form::model($homeData, ['method' => 'PUT', 'route' => ['admin.home.sectionReviewUpdate', $homeData->language_id], 'files'=>true]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
          Review Section Edit
        </div>

        <div class="panel-body">
              <div class="row">
                @if($homeData->review_img_1 != "")
                  <div class="col-xs-3 form-group">
                      {!! Form::label('img','Review Image 1')!!}
                      <div>
                        <img src="{{url('images/home/'.$homeData->review_img_1) }}" onerror="this.src='{{ url('images/default.png') }}'" id="img_left" width="100" height="100"/>
                      </div>
                  </div>
                  @endif
                  @if($homeData->review_img_2 != "")
                    <div class="col-xs-3 form-group">
                        {!! Form::label('img','Review Image 2')!!}
                        <div>
                          <img src="{{url('images/home/'.$homeData->review_img_2) }}" onerror="this.src='{{ url('images/default.png') }}'" id="img_left" width="100" height="100"/>
                        </div>
                    </div>
                    @endif
              </div>
              <div class="row">
                <div class="col-xs-3 form-group">
                  {!! Form::label('review_img_1','Review Image 1')!!}
                  <div class="input-group date">
                    <input type="hidden"  name="file_delete" id="file_delete" value="0" />
                      <input type="file" class='form-control file_name' size="1" name="review_img_1" accept="image/*" />
                      <span class="input-group-addon">
                          <span class="glyphicon glyphicon-remove" id="file_remove" style="{{$homeData->review_img_1 != "" ? 'display:inline-block':'display:none'}};">
                          </span>
                          <span class="glyphicon glyphicon-upload" id="file_upload" style="{{$homeData->review_img_1 != "" ? 'display:none':'display:inline-block'}};">
                          </span>
                      </span>
                  </div>
                  <p class="help-block file_name_error">
                  </p>
                </div>
                <div class="col-xs-3 form-group">
                  {!! Form::label('review_img_2','Review Image 1')!!}
                  <div class="input-group date">
                    <input type="hidden"  name="file_delete" id="file_delete" value="0" />
                      <input type="file" class='form-control file_name' size="1" name="review_img_2" accept="image/*" />
                      <span class="input-group-addon">
                          <span class="glyphicon glyphicon-remove" id="file_remove" style="{{$homeData->review_img_2 != "" ? 'display:inline-block':'display:none'}};">
                          </span>
                          <span class="glyphicon glyphicon-upload" id="file_upload" style="{{$homeData->review_img_2 != "" ? 'display:none':'display:inline-block'}};">
                          </span>
                      </span>
                  </div>
                  <p class="help-block file_name_error">
                  </p>
                </div>


                <div class="col-xs-3 form-group">
                    {!! Form::label('review_tag', 'Review Tag*', ['class' => 'control-label']) !!}
                    {!! Form::text('review_tag', $homeData->review_tag, ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('review_tag'))
                        <p class="help-block">
                            {{ $errors->first('review_tag') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-3 form-group">
                  {!! Form::label('review_detail', 'Review Detail*', ['class' => 'control-label']) !!}
                  {!! Form::text('review_detail', $homeData->review_detail, ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                  <p class="help-block"></p>
                  @if($errors->has('review_detail'))
                  <p class="help-block">
                    {{ $errors->first('review_detail') }}
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

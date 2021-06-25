@extends('admin.layouts.app')

@section('content')
    <h3 class="page-title">Services Apply Page Content</h3>

    {!! Form::model($applyData, ['method' => 'POST', 'route' => ['admin.services.applyDetailSave',$applyData->services_id], 'files'=>true]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
          Edit
        </div>

        <div class="panel-body">
          <div class="row">
              <div class="col-xs-6 form-group">
                @if($applyData->thank_you_img != "")
                  {!! Form::label('thank_you_img','Image')!!}
                  <div>
                    <img src="{{url('images/services/apply/'.$applyData->thank_you_img) }}" onerror="this.src='{{ url('images/default.png') }}'" id="img_left" width="100" height="100"/>
                  </div>
                @endif
              </div>
            </div>
          <div class="row">
            <div class="col-xs-4 form-group">
              {!! Form::label('thank_you_img','Thank You Image')!!}
              <div class="input-group date">
                  <input type="file" class='form-control file_name' size="1" name="thank_you_img" accept="image/*" />
              </div>
              <p class="help-block file_name_error">
              </p>
            </div>
            <div class="col-xs-4 form-group">
                {!! Form::label('thank_you_content', 'Thank You Content*', ['class' => 'control-label']) !!}
                {!! Form::textarea('thank_you_content', old('thank_you_content'), ['class' => 'form-control tinymceEditor', 'placeholder' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('thank_you_content'))
                    <p class="help-block">
                        {{ $errors->first('thank_you_content') }}
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

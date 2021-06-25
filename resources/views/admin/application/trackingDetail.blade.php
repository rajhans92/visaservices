@extends('admin.layouts.app')

@section('content')
    <h3 class="page-title">Visa Faq</h3>

    {!! Form::model($visaData, ['method' => 'POST', 'route' => ['admin.application.trackingDetailUpdate',$visaData->id], 'files'=>true]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
          Edit
        </div>

        <div class="panel-body">

          <div class="row">
            <div class="col-xs-6 form-group">
              {!! Form::label('tracking_status', 'Tracking Status*', ['class' => 'control-label']) !!}
              {!! Form::text('tracking_status', old('tracking_status'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
              <p class="help-block"></p>
              @if($errors->has('tracking_status'))
              <p class="help-block">
                {{ $errors->first('tracking_status') }}
              </p>
              @endif
            </div>
          </div>
          <div class="row">
            <div class="col-xs-6 form-group">
              {!! Form::label('tracking_status_desc', 'Tracking Status Description*', ['class' => 'control-label']) !!}
              {!! Form::textarea('tracking_status_desc', old('answer'), ['class' => 'form-control tinymceEditor', 'placeholder' => '']) !!}
              <p class="help-block"></p>
              @if($errors->has('tracking_status_desc'))
              <p class="help-block">
                {{ $errors->first('tracking_status_desc') }}
              </p>
              @endif
            </div>
          </div>


        </div>
    </div>

    {!! Form::submit('Update', ['class' => 'btn btn-danger']) !!}
    <a href="{{ route('admin.application.index') }}" class="btn btn-primary">Cancel</a>
    {!! Form::close() !!}
@stop

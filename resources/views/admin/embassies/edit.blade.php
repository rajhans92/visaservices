@extends('admin.layouts.app')

@section('content')
    <h3 class="page-title">Embassies</h3>

    {!! Form::model($embassiesDetail, ['method' => 'POST', 'route' => ['admin.embassies.embassiesEdit',$embassies_id,$embassiesDetail->id], 'files'=>true]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
          Edit
        </div>

        <div class="panel-body">
          <div class="row">
            <div class="col-xs-4 form-group">
                {!! Form::label('embassy_in', 'Embassy In*', ['class' => 'control-label']) !!}
                {!! Form::text('embassy_in', old('embassy_in'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('embassy_in'))
                    <p class="help-block">
                        {{ $errors->first('embassy_in') }}
                    </p>
                @endif
            </div>
            <div class="col-xs-4 form-group">
                {!! Form::label('embassy_city', 'Embassy City*', ['class' => 'control-label']) !!}
                {!! Form::text('embassy_city', old('embassy_city'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('embassy_city'))
                    <p class="help-block">
                        {{ $errors->first('embassy_city') }}
                    </p>
                @endif
            </div>
            <div class="col-xs-4 form-group">
                {!! Form::label('heading', 'Heading*', ['class' => 'control-label']) !!}
                {!! Form::text('heading', old('heading'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('heading'))
                    <p class="help-block">
                        {{ $errors->first('heading') }}
                    </p>
                @endif
            </div>
          </div>

          <div class="row">
            <div class="col-xs-4 form-group">
                {!! Form::label('address', 'Address*', ['class' => 'control-label']) !!}
                {!! Form::text('address', old('address'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('address'))
                    <p class="help-block">
                        {{ $errors->first('address') }}
                    </p>
                @endif
            </div>
            <div class="col-xs-4 form-group">
                {!! Form::label('contact_us', 'Contact Us', ['class' => 'control-label']) !!}
                {!! Form::text('contact_us', old('contact_us'), ['class' => 'form-control', 'placeholder' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('contact_us'))
                    <p class="help-block">
                        {{ $errors->first('contact_us') }}
                    </p>
                @endif
            </div>
            <div class="col-xs-4 form-group">
                {!! Form::label('email_id', 'Email Id', ['class' => 'control-label']) !!}
                {!! Form::text('email_id', old('email_id'), ['class' => 'form-control', 'placeholder' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('email_id'))
                    <p class="help-block">
                        {{ $errors->first('email_id') }}
                    </p>
                @endif
            </div>
          </div>
          <div class="row">
            <div class="col-xs-4 form-group">
                {!! Form::label('website', 'Website', ['class' => 'control-label']) !!}
                {!! Form::text('website', old('website'), ['class' => 'form-control', 'placeholder' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('website'))
                    <p class="help-block">
                        {{ $errors->first('website') }}
                    </p>
                @endif
            </div>
            <div class="col-xs-4 form-group">
                {!! Form::label('map_location', 'Map Location', ['class' => 'control-label']) !!}
                {!! Form::text('map_location', old('map_location'), ['class' => 'form-control', 'placeholder' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('map_location'))
                    <p class="help-block">
                        {{ $errors->first('map_location') }}
                    </p>
                @endif
            </div>
          </div>

        </div>
    </div>

    {!! Form::submit('Update', ['class' => 'btn btn-danger']) !!}
    <a href="{{ route('admin.embassies.embassiesList',$embassies_id) }}" class="btn btn-primary">Cancel</a>
    {!! Form::close() !!}
@stop

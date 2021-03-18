@extends('admin.layouts.app')

@section('content')
    <h3 class="page-title">Port Of Arrival</h3>

    {!! Form::model([], ['method' => 'POST', 'route' => ['admin.country.portOfArrivalStoreCountry',$country_id], 'files'=>true]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
          Create
        </div>

        <div class="panel-body">
          <div class="row">
            <div class="col-xs-4 form-group">
                {!! Form::label('port_name', 'Port Name*', ['class' => 'control-label']) !!}
                {!! Form::text('port_name', old('port_name'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('port_name'))
                    <p class="help-block">
                        {{ $errors->first('port_name') }}
                    </p>
                @endif
            </div>
          </div>

        </div>
    </div>

    {!! Form::submit('Add', ['class' => 'btn btn-danger']) !!}
    <a href="{{ route('admin.country.portOfArrivalCountry',[$country_id]) }}" class="btn btn-primary">Cancel</a>
    {!! Form::close() !!}
@stop

@extends('admin.layouts.app')

@section('content')
    <h3 class="page-title">Embassies</h3>

    {!! Form::model($embassiesDetail, ['method' => 'POST', 'route' => ['admin.embassies.embassiesNameEdit',$embassiesDetail->id], 'files'=>true]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
          Edit
        </div>

        <div class="panel-body">
          <div class="row">
            <div class="col-xs-4 form-group">
                {!! Form::label('name', 'Embassy Name*', ['class' => 'control-label']) !!}
                {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('name'))
                    <p class="help-block">
                        {{ $errors->first('name') }}
                    </p>
                @endif
            </div>
            <div class="col-xs-4 form-group">
                {!! Form::label('url', 'Embassy Url*', ['class' => 'control-label']) !!}
                {!! Form::text('url', old('url'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('url'))
                    <p class="help-block">
                        {{ $errors->first('url') }}
                    </p>
                @endif
            </div>
          </div>
        </div>
    </div>

    {!! Form::submit('Update', ['class' => 'btn btn-danger']) !!}
    <a href="{{ route('admin.embassies.index') }}" class="btn btn-primary">Cancel</a>
    {!! Form::close() !!}
@stop

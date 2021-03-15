@extends('admin.layouts.app')

@section('content')
    <h3 class="page-title">Home</h3>

    {!! Form::model($homeData, ['method' => 'PUT', 'route' => ['admin.home.popularVisaUpdate', $homeData->language_id], 'files'=>true]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
          Section 3 Edit
        </div>

        <div class="panel-body">
          <div class="row">
            <div class="col-xs-6 form-group">
                {!! Form::label('section_1_title', 'Section Heading*', ['class' => 'control-label']) !!}
                {!! Form::text('section_1_title', old('section_1_title'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('section_1_title'))
                    <p class="help-block">
                        {{ $errors->first('section_1_title') }}
                    </p>
                @endif
            </div>
            <div class="col-xs-6 form-group">
                {!! Form::label('section_button_name', 'Section Button(Apply)*', ['class' => 'control-label']) !!}
                {!! Form::text('section_button_name', old('section_button_name'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('section_button_name'))
                    <p class="help-block">
                        {{ $errors->first('section_button_name') }}
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

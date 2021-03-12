@extends('admin.layouts.app')

@section('content')
    <h3 class="page-title">Footer</h3>

    {!! Form::model($footerData, ['method' => 'PUT', 'route' => ['admin.footer.social', $footerData->language_id]]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
          Social Info Edit
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-4 form-group">
                    {!! Form::label('social_network_title', 'Social Network Title*', ['class' => 'control-label']) !!}
                    {!! Form::text('social_network_title', old('social_network_title'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('social_network_title'))
                        <p class="help-block">
                            {{ $errors->first('social_network_title') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4 form-group">
                    {!! Form::label('social_network_link1', 'Link 1(Facebook)*', ['class' => 'control-label']) !!}
                    {!! Form::text('social_network_link1', old('social_network_link1'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('social_network_link1'))
                        <p class="help-block">
                            {{ $errors->first('social_network_link1') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-4 form-group">
                    {!! Form::label('social_network_link2', 'Link 1(Twitter)*', ['class' => 'control-label']) !!}
                    {!! Form::text('social_network_link2', old('social_network_link2'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('social_network_link2'))
                        <p class="help-block">
                            {{ $errors->first('social_network_link2') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-4 form-group">
                    {!! Form::label('social_network_link3', 'Link 1(Instagram)*', ['class' => 'control-label']) !!}
                    {!! Form::text('social_network_link3', old('social_network_link3'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('social_network_link3'))
                        <p class="help-block">
                            {{ $errors->first('social_network_link3') }}
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

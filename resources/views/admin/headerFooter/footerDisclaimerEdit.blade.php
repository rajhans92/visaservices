@extends('admin.layouts.app')

@section('content')
    <h3 class="page-title">Footer</h3>

    {!! Form::model($footerData, ['method' => 'PUT', 'route' => ['admin.footer.disclaimerUpdate', $footerData->language_id]]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
          Disclaimer Edit
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-6 form-group">
                    {!! Form::label('disclaimer_title', 'Disclaimer Title*', ['class' => 'control-label']) !!}
                    {!! Form::text('disclaimer_title', old('disclaimer_title'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('disclaimer_title'))
                        <p class="help-block">
                            {{ $errors->first('disclaimer_title') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6 form-group">
                    {!! Form::label('disclaimer_detail', 'Disclaimer Detail*', ['class' => 'control-label']) !!}
                    {!! Form::text('disclaimer_detail', old('disclaimer_detail'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('disclaimer_detail'))
                        <p class="help-block">
                            {{ $errors->first('disclaimer_detail') }}
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

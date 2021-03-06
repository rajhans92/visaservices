@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.exam-category.title')</h3>

    {!! Form::model($category, ['method' => 'PUT', 'route' => ['admin.exam-category.update', $category->id]]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_edit')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('title', 'Title*', ['class' => 'control-label']) !!}
                    {!! Form::text('title', old('title'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('title'))
                        <p class="help-block">
                            {{ $errors->first('title') }}
                        </p>
                    @endif
                </div>
            </div>

        </div>
    </div>

    {!! Form::submit(trans('global.app_update'), ['class' => 'btn btn-danger']) !!}
    <a href="{{ route('admin.exam-category.index') }}" class="btn btn-primary">Cancel</a>
    {!! Form::close() !!}
@stop

@extends('admin.layouts.app')

@section('content')
    <h3 class="page-title">Header</h3>

    {!! Form::model($menuData, ['method' => 'PUT', 'route' => ['admin.header.update', $menuData->id]]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
          Menu Edit
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('title', 'Title ($menuData->title)*', ['class' => 'control-label']) !!}
                    {!! Form::text('name', old('Name'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('name'))
                        <p class="help-block">
                            {{ $errors->first('name') }}
                        </p>
                    @endif
                </div>
            </div>

        </div>
    </div>

    {!! Form::submit('Update', ['class' => 'btn btn-danger']) !!}
    <a href="{{ route('admin.header.index') }}" class="btn btn-primary">Cancel</a>
    {!! Form::close() !!}
@stop

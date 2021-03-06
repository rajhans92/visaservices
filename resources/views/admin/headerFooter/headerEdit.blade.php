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
            <div class="col-xs-4 form-group">
                {!! Form::label('name', 'Menu Name*', ['class' => 'control-label']) !!}
                {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                <p class="help-block"></p>
                @if($errors->has('name'))
                    <p class="help-block">
                        {{ $errors->first('name') }}
                    </p>
                @endif
            </div>
            <div class="col-xs-4 form-group">
                {!! Form::label('url', 'Select URL*', ['class' => 'control-label']) !!}
                <select class="form-control selectpicker" required name="url" >
                  @foreach($links as $val)
                    <option value="{{$val->id}}" {{$val->id == $menuData->url ? "selected" : ""}}>{{$val->visa_url}}</option>
                  @endforeach
                </select>
            </div>
            <div class="col-xs-4 form-group">
                {!! Form::label('menu_type', 'Select Menu Type*', ['class' => 'control-label']) !!}
                <select class="form-control selectpicker" required name="menu_type" >
                    <option value="header" {{$menuData->menu_type == "header" ? "selected" : ""}}>header</option>
                    <option value="footer" {{$menuData->menu_type == "footer" ? "selected" : ""}}>footer</option>
                </select>
            </div>
          </div>

        </div>
    </div>

    {!! Form::submit('Update', ['class' => 'btn btn-danger']) !!}
    <a href="{{ route('admin.header.index') }}" class="btn btn-primary">Cancel</a>
    {!! Form::close() !!}
@stop

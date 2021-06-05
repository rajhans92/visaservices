@extends('admin.layouts.app')

@section('content')
    <h3 class="page-title">Blog Category</h3>

    {!! Form::model($data, ['method' => 'POST', 'route' => ['admin.blog.categoryStore'], 'files'=>true]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
          Create
        </div>

        <div class="panel-body">

          <div class="row">
            <div class="col-xs-6 form-group">
              {!! Form::label('name', 'Category Name*', ['class' => 'control-label']) !!}
              {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
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

    {!! Form::submit('Add', ['class' => 'btn btn-danger']) !!}
    <a href="{{ route('admin.blog.categoryList') }}" class="btn btn-primary">Cancel</a>
    {!! Form::close() !!}
@stop

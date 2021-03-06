@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.exam-slider.title')</h3>

    {!! Form::model($slider, ['method' => 'PUT', 'route' => ['admin.exam-slider.update', $slider->id], 'files'=>true]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_edit')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-6 form-group">
                    {!! Form::label('title', 'Sider Title*', ['class' => 'control-label']) !!}
                    {!! Form::text('title', old('title'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('title'))
                        <p class="help-block">
                            {{ $errors->first('title') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-6 form-group">
                    {!! Form::label('Slider Photo','Photo')!!}
                    {!! Form::file('path',['class'=>'form-control'])!!}
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6 form-group">

                </div>
                <div class="col-xs-6 form-group">
                  @if($slider->path != "")
                  {!! Form::label('path','Slider Photo')!!}
                    <div>
                      <img src="{{ env('IMG_URL') }}/img/slider/{{ $slider->path }}" onerror="this.src='{{ env('IMG_URL') }}/img/default.png'" id="path" width="100" height="100"/>
                    </div>
                  @endif
                </div>
            </div>
            <div class="row">
              <div class="col-xs-12 form-group">
                  {!! Form::label('detail', 'Slider Detail*', ['class' => 'control-label']) !!}
                  {!! Form::textarea('detail', old('detail'),['class' => 'form-control', 'placeholder' => '']) !!}
                  <p class="help-block"></p>
                  @if($errors->has('detail'))
                      <p class="help-block">
                          {{ $errors->first('detail') }}
                      </p>
                  @endif
              </div>
            </div>

        </div>
    </div>

    {!! Form::submit(trans('global.app_update'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop

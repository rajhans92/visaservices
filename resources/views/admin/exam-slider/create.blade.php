@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.exam-slider.title')</h3>
    <form action="{{route('admin.exam-slider.store')}}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_create')
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

    {!! Form::submit(trans('global.app_save'), ['class' => 'btn btn-danger']) !!}
</form>
@stop
@section('javascript')

<script type="text/javascript">

    $(function(){
      
    });
</script>

@endsection

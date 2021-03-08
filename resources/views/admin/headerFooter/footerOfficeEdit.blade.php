@extends('admin.layouts.app')

@section('content')
    <h3 class="page-title">Footer</h3>

    {!! Form::model($footerData, ['method' => 'PUT', 'route' => ['admin.footer.officeUpdate', $footerData->language_id]]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
          Office Address Edit
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-3 form-group">
                    {!! Form::label('address_title_1', 'Address Title 1*', ['class' => 'control-label']) !!}
                    {!! Form::text('address_title_1', old('address_title_1'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('address_title_1'))
                        <p class="help-block">
                            {{ $errors->first('address_title_1') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-3 form-group">
                    {!! Form::label('address_title_2', 'Address Title 2*', ['class' => 'control-label']) !!}
                    {!! Form::text('address_title_2', old('address_title_2'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('address_title_2'))
                        <p class="help-block">
                            {{ $errors->first('address_title_2') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-3 form-group">
                    {!! Form::label('address_title_3', 'Address Title 3*', ['class' => 'control-label']) !!}
                    {!! Form::text('address_title_3', old('address_title_3'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('address_title_3'))
                        <p class="help-block">
                            {{ $errors->first('address_title_3') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-3 form-group">
                    {!! Form::label('address_title_4', 'Address Title 4*', ['class' => 'control-label']) !!}
                    {!! Form::text('address_title_4', old('address_title_4'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('address_title_4'))
                        <p class="help-block">
                            {{ $errors->first('address_title_4') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-3 form-group">
                    {!! Form::label('address_detail_1', 'Address Detail 1*', ['class' => 'control-label']) !!}
                    {!! Form::text('address_detail_1', old('address_detail_1'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('address_detail_1'))
                        <p class="help-block">
                            {{ $errors->first('address_detail_1') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-3 form-group">
                    {!! Form::label('address_detail_2', 'Address Detail 2*', ['class' => 'control-label']) !!}
                    {!! Form::text('address_detail_2', old('address_detail_2'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('address_detail_2'))
                        <p class="help-block">
                            {{ $errors->first('address_detail_2') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-3 form-group">
                    {!! Form::label('address_detail_3', 'Address Detail 3*', ['class' => 'control-label']) !!}
                    {!! Form::text('address_detail_3', old('address_detail_3'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('address_detail_3'))
                        <p class="help-block">
                            {{ $errors->first('address_detail_3') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-3 form-group">
                    {!! Form::label('address_detail_4', 'Address Detail 4*', ['class' => 'control-label']) !!}
                    {!! Form::text('address_detail_4', old('address_detail_4'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('address_detail_4'))
                        <p class="help-block">
                            {{ $errors->first('address_detail_4') }}
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

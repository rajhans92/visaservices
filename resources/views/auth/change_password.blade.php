@extends('layouts.app')

@section('content')
    <h3 class="page-title">Change password</h3>

        {!! Form::open(['method' => 'PATCH', 'route' => ['admin.auth.change_password']]) !!}
        <!-- If no success message in flash session show change password form  -->
        <div class="panel panel-default">
            <div class="panel-heading">
            [ <b>NOTE</b> ] Password must be at least 6 characters in length, one lowercase/uppercase letter, one digit and a special character.
            </div>

            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 form-group">
                        {!! Form::label('current_password', 'Current password*', ['class' => 'control-label']) !!}
                        {!! Form::password('current_password', ['class' => 'form-control', 'placeholder' => '']) !!}
                        <p class="help-block"></p>
                        @if($errors->has('current_password'))
                            <p class="help-block">
                                {{ $errors->first('current_password') }}
                            </p>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 form-group">
                        {!! Form::label('new_password', 'New password*', ['class' => 'control-label']) !!}
                        {!! Form::password('new_password', ['class' => 'form-control', 'placeholder' => '']) !!}
                        <p class="help-block"></p>
                        @if($errors->has('new_password'))
                            <p class="help-block">
                                {{ $errors->first('new_password') }}
                            </p>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 form-group">
                        {!! Form::label('new_password_confirmation', 'New password confirmation*', ['class' => 'control-label']) !!}
                        {!! Form::password('new_password_confirmation', ['class' => 'form-control', 'placeholder' => '']) !!}
                        <p class="help-block"></p>
                        @if($errors->has('new_password_confirmation'))
                            <p class="help-block">
                                {{ $errors->first('new_password_confirmation') }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {!! Form::submit(trans('global.app_save'), ['class' => 'btn btn-danger']) !!}
        {!! Form::close() !!}
@stop

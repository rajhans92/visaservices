@extends('admin.layouts.app')

@section('content')
    <h3 class="page-title">Footer</h3>

    {!! Form::model($footerData, ['method' => 'PUT', 'route' => ['admin.footer.companyUpdate', $footerData->language_id]]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
          Company Detail Edit
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-6 form-group">
                    {!! Form::label('company_detail', 'Company Detail*', ['class' => 'control-label']) !!}
                    {!! Form::text('company_detail', old('company_detail'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('company_detail'))
                        <p class="help-block">
                            {{ $errors->first('company_detail') }}
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

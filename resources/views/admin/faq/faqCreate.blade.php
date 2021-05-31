@extends('admin.layouts.app')

@section('content')
    <h3 class="page-title">Visa Faq</h3>

    {!! Form::model($faqData, ['method' => 'POST', 'route' => ['admin.faq.save'], 'files'=>true]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
          Create
        </div>

        <div class="panel-body">

          <div class="row">
            <div class="col-xs-6 form-group">
              {!! Form::label('question', 'Faq Question*', ['class' => 'control-label']) !!}
              {!! Form::text('question', old('question'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
              <p class="help-block"></p>
              @if($errors->has('question'))
              <p class="help-block">
                {{ $errors->first('question') }}
              </p>
              @endif
            </div>
          </div>
          <div class="row">
            <div class="col-xs-6 form-group">
              {!! Form::label('answer', 'Faq Answer*', ['class' => 'control-label']) !!}
              {!! Form::textarea('answer', old('answer'), ['class' => 'form-control', 'placeholder' => '']) !!}
              <p class="help-block"></p>
              @if($errors->has('answer'))
              <p class="help-block">
                {{ $errors->first('answer') }}
              </p>
              @endif
            </div>
          </div>


        </div>
    </div>

    {!! Form::submit('Add', ['class' => 'btn btn-danger']) !!}
    <a href="{{ route('admin.faq.list') }}" class="btn btn-primary">Cancel</a>
    {!! Form::close() !!}
@stop

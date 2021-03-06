@extends('admin.layouts.app')

@section('content')
    <h3 class="page-title">Services Faq</h3>

    {!! Form::model($faqData, ['method' => 'PUT', 'route' => ['admin.services.faqEdit',$id,$faqData->id], 'files'=>true]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
          Edit
        </div>

        <div class="panel-body">

          <div class="row">
            <div class="col-xs-6 form-group">
              {!! Form::label('question', 'Services Faq Question*', ['class' => 'control-label']) !!}
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
              {!! Form::label('answer', 'Services Faq Answer*', ['class' => 'control-label']) !!}
              {!! Form::textarea('answer', old('answer'), ['class' => 'form-control tinymceEditor', 'placeholder' => '']) !!}
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

    {!! Form::submit('Update', ['class' => 'btn btn-danger']) !!}
    <a href="{{ route('admin.services.faqList',$id) }}" class="btn btn-primary">Cancel</a>
    {!! Form::close() !!}
@stop

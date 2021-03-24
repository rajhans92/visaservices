@extends('admin.layouts.app')

@section('content')
    <h3 class="page-title">Footer</h3>

    {!! Form::model($footerTag, ['method' => 'PUT', 'route' => ['admin.footer.tagsUpdate', $footerTag->language_id]]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
          Tags Edit
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-3 form-group">
                    {!! Form::label('tag_1', 'Tag 1*', ['class' => 'control-label']) !!}
                    {!! Form::text('tag_1', old('tag_1'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('tag_1'))
                        <p class="help-block">
                            {{ $errors->first('tag_1') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-3 form-group">
                    {!! Form::label('tag_link_1', 'Select Link*', ['class' => 'control-label']) !!}
                    <select class="form-control selectpicker" required name="tag_link_1" value="" >
                      @foreach($urlSet as $key => $val)
                        <option value="{{$key}}" {{ $key == $footerTag->tag_link_1 ? 'selected' : '' }}>{{$val}}</option>
                      @endforeach
                    </select>
                    <p class="help-block"></p>
                    @if($errors->has('tag_link_1'))
                        <p class="help-block">
                            {{ $errors->first('tag_link_1') }}
                        </p>
                    @endif
                </div>
              </div>
              <div class="row">
                <div class="col-xs-3 form-group">
                    {!! Form::label('tag_2', 'Tag 2*', ['class' => 'control-label']) !!}
                    {!! Form::text('tag_2', old('tag_2'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('tag_2'))
                        <p class="help-block">
                            {{ $errors->first('tag_2') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-3 form-group">
                    {!! Form::label('tag_link_2', 'Select Link*', ['class' => 'control-label']) !!}
                    <select class="form-control selectpicker" required name="tag_link_2" value="" >
                      @foreach($urlSet as $key => $val)
                        <option value="{{$key}}" {{ $key == $footerTag->tag_link_2 ? 'selected' : '' }}>{{$val}}</option>
                      @endforeach
                    </select>
                    <p class="help-block"></p>
                    @if($errors->has('tag_link_2'))
                        <p class="help-block">
                            {{ $errors->first('tag_link_2') }}
                        </p>
                    @endif
                </div>
              </div>
              <div class="row">
                <div class="col-xs-3 form-group">
                    {!! Form::label('tag_3', 'Tag 3*', ['class' => 'control-label']) !!}
                    {!! Form::text('tag_3', old('tag_3'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('tag_3'))
                        <p class="help-block">
                            {{ $errors->first('tag_3') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-3 form-group">
                    {!! Form::label('tag_link_3', 'Select Link*', ['class' => 'control-label']) !!}
                    <select class="form-control selectpicker" required name="tag_link_3" value="" >
                      @foreach($urlSet as $key => $val)
                        <option value="{{$key}}" {{ $key == $footerTag->tag_link_3 ? 'selected' : '' }}>{{$val}}</option>
                      @endforeach
                    </select>
                    <p class="help-block"></p>
                    @if($errors->has('tag_link_3'))
                        <p class="help-block">
                            {{ $errors->first('tag_link_3') }}
                        </p>
                    @endif
                </div>
              </div>
              <div class="row">
                <div class="col-xs-3 form-group">
                    {!! Form::label('tag_4', 'Tag 4*', ['class' => 'control-label']) !!}
                    {!! Form::text('tag_4', old('tag_4'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('tag_4'))
                        <p class="help-block">
                            {{ $errors->first('tag_4') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-3 form-group">
                    {!! Form::label('tag_link_4', 'Select Link*', ['class' => 'control-label']) !!}
                    <select class="form-control selectpicker" required name="tag_link_4" value="" >
                      @foreach($urlSet as $key => $val)
                        <option value="{{$key}}" {{ $key == $footerTag->tag_link_4 ? 'selected' : '' }}>{{$val}}</option>
                      @endforeach
                    </select>
                    <p class="help-block"></p>
                    @if($errors->has('tag_link_4'))
                        <p class="help-block">
                            {{ $errors->first('tag_link_4') }}
                        </p>
                    @endif
                </div>
            </div>
          </div>

        </div>
    </div>

    {!! Form::submit('Update', ['class' => 'btn btn-danger']) !!}
    <a href="{{ route('admin.footer.index') }}" class="btn btn-primary">Cancel</a>
    {!! Form::close() !!}
@stop

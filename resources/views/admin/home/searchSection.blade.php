@extends('admin.layouts.app')

@section('content')
    <h3 class="page-title">Footer</h3>

    {!! Form::model($footerLogo, ['method' => 'PUT', 'route' => ['admin.footer.logoUpdate', $footerLogo->language_id], 'files'=>true]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
          Logo Edit
        </div>

        <div class="panel-body">
          <div class="row">
              <div class="col-xs-6 form-group">
                @if($footerLogo->img_left != "")
                  {!! Form::label('img_left','Left Image')!!}
                  <div>
                    <img src="{{url('images/footer/'.$footerLogo->img_left) }}" onerror="this.src='{{ url('images/default.png') }}'" id="img_left" width="100" height="100"/>
                  </div>
                @endif
              </div>
              <div class="col-xs-6 form-group">
                @if($footerLogo->img_right != "")
                  {!! Form::label('img_right','Right Image')!!}
                  <div>
                    <img src="{{url('images/footer/'.$footerLogo->img_right) }}" onerror="this.src='{{ url('images/default.png') }}'" id="img_right" width="100" height="100"/>
                  </div>
                @endif
              </div>
          </div>
            <div class="row">
              <div class="col-xs-6 form-group">
                {!! Form::label('img_left','Left Image')!!}
                <div class="input-group date">
                  <input type="hidden"  name="file_delete" id="file_delete" value="0" />
                    <input type="file" class='form-control file_name' size="1" name="img_left" accept="image/*" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-remove" id="file_remove" style="{{$footerLogo->img_left != "" ? 'display:inline-block':'display:none'}};">
                        </span>
                        <span class="glyphicon glyphicon-upload" id="file_upload" style="{{$footerLogo->img_left != "" ? 'display:none':'display:inline-block'}};">
                        </span>
                    </span>
                </div>
                <p class="help-block file_name_error">
                </p>
              </div>
              <div class="col-xs-6 form-group">
                {!! Form::label('img_right','Right Image')!!}
                <div class="input-group date">
                  <input type="hidden"  name="file_delete" id="file_delete" value="0" />
                    <input type="file" class='form-control file_name' size="1" name="img_right" accept="image/*" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-remove" id="file_remove" style="{{$footerLogo->img_right != "" ? 'display:inline-block':'display:none'}};">
                        </span>
                        <span class="glyphicon glyphicon-upload" id="file_upload" style="{{$footerLogo->img_right != "" ? 'display:none':'display:inline-block'}};">
                        </span>
                    </span>
                </div>
                <p class="help-block file_name_error">
                </p>
              </div>
            </div>

        </div>
    </div>

    {!! Form::submit('Update', ['class' => 'btn btn-danger']) !!}
    <a href="{{ route('admin.home.index') }}" class="btn btn-primary">Cancel</a>
    {!! Form::close() !!}
@stop

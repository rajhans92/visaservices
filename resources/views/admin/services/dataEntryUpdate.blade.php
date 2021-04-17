@inject('request', 'Illuminate\Http\Request')
@extends('admin.layouts.app')

@section('content')
    <h3 class="page-title"></h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            Services Table Upload
        </div>

        <div class="panel-body">
            <div class="row">
              <div class="col-xs-4 form-group">
                <a href="{{ asset('/s3/services-sheet.xlsx') }}" class="btn btn-primary">Download Formatted Sheet</a>
              </div>
              <div class="col-xs-4 form-group">

              </div>
            </div>
        </div>

        <div class="panel-body">
          <form action="{{route('admin.services.dataEntrySave',[$services_id])}}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
              <div class="col-xs-4 form-group">
              </div>
              <div class="col-xs-4 form-group">
                  <label for="file_name">Upload Excel File</label>
                  <input class="form-control" name="file_name" type="file" id="file_name">
                  @if($errors->has('file_name'))
                      <p class="help-block">
                          {{ $errors->first('file_name') }}
                      </p>
                  @endif
              </div>
            </div>
            <div class="row">
              <div class="col-xs-4 form-group">
              </div>
              <div class="col-xs-4 form-group">
                  <input class="form-control btn btn-danger" name="Submit" type="submit">
              </div>
            </div>
          </form>
        </div>
        <div class="panel-body">
          <div class="row">
            <div class="col-xs-4 form-group">
              <a href="{{ route('admin.services.dataEntryList',[$services_id]) }}" class="btn btn-default">Back</a>
            </div>
          </div>
        </div>
    </div>
@stop

@section('javascript')

<script type="text/javascript">

$(function(){

});
</script>

@endsection

@inject('request', 'Illuminate\Http\Request')
@extends('admin.layouts.app')

@section('content')
    <h3 class="page-title">Embassies Name</h3>
    <p>
        <a href="{{ route('admin.embassies.embassiesNameUpload') }}" class="btn btn-success">Upload Embassies</a>

    </p>

    <div class="panel panel-default">
        <div class="panel-heading">
            List
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped datatable dt-select ">
                <thead>
                    <tr>
                        <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        <th>Embassy Name</th>
                        <th>Embassy URL</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>

                <tbody>
                  @foreach($embassiesList as $key => $val)
                    <tr data-entry-id="">
                        <td></td>
                        <td>{{$val->name}}</td>
                        <td>{{$val->url}}</td>
                        <td>
                          <a href="{{ route('admin.embassies.embassiesList',[$val->id]) }}" class="btn btn-xs btn-success">Detail</a>
                          <a href="{{ route('admin.embassies.embassiesNameEdit',[$val->id]) }}" class="btn btn-xs btn-info">Edit</a>
                          {!! Form::open(array(
                              'style' => 'display: inline-block;',
                              'method' => 'DELETE',
                              'onsubmit' => "return confirm('Are you sure?');",
                              'route' => ['admin.embassies.embassiesNameDelete', $val->id])) !!}
                          {!! Form::submit('Delete', array('class' => 'btn btn-xs btn-danger')) !!}
                          {!! Form::close() !!}
                        </td>
                    </tr>
                  @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

@inject('request', 'Illuminate\Http\Request')
@extends('admin.layouts.app')

@section('content')
    <h3 class="page-title">Embassies</h3>
    <p>
        <a href="{{ route('admin.embassies.embassiesUpload') }}" class="btn btn-success">Upload Embassies</a>

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
                        <th>Embassy Of</th>
                        <th>Embassy In</th>
                        <th>Heading</th>
                        <th>Address</th>
                        <th>contact us</th>
                        <th>Email</th>
                        <th>Website</th>
                        <th>Map Location</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>

                <tbody>
                  @foreach($embassiesList as $key => $val)
                    <tr data-entry-id="">
                        <td></td>
                        <td>{{$val->embassy_of}}</td>
                        <td>{{$val->embassy_in}}</td>
                        <td>{{$val->heading}}</td>
                        <td>{{$val->address}}</td>
                        <td>{{$val->contact_us}}</td>
                        <td>{{$val->email_id}}</td>
                        <td>{{$val->website}}</td>
                        @if($val->map_location != "")
                        <td><a hreef='{{$val->map_location}}'>Map</a></td>
                        @else
                        <td>NA</td>
                        @endif
                        <td>
                          <a href="{{ route('admin.embassies.embassiesEdit',[$val->id]) }}" class="btn btn-xs btn-info">Edit</a>
                          {!! Form::open(array(
                              'style' => 'display: inline-block;',
                              'method' => 'DELETE',
                              'onsubmit' => "return confirm('Are you sure?');",
                              'route' => ['admin.embassies.embassiesDelete', $val->id])) !!}
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

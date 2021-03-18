@inject('request', 'Illuminate\Http\Request')
@extends('admin.layouts.app')

@section('content')
    <h3 class="page-title">Country</h3>
    <p>
        <a href="{{ route('admin.country.portOfArrivalAddCountry',[$country_id]) }}" class="btn btn-success">Create</a>

    </p>

    <div class="panel panel-default">
        <div class="panel-heading">
            Port Of Arrival List
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped datatable dt-select ">
                <thead>
                    <tr>
                        <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        <th>Port Of Arrival</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>

                <tbody>
                  @foreach($countryData as $key => $val)
                    <tr data-entry-id="">
                        <td></td>
                        <td>{{$val->port_name}}</td>
                        <td>
                          <a href="{{ route('admin.country.portOfArrivalEditCountry',[$country_id,$val->id]) }}" class="btn btn-xs btn-info">Edit</a>

                          {!! Form::open(array(
                              'style' => 'display: inline-block;',
                              'method' => 'DELETE',
                              'onsubmit' => "return confirm('Are you sure?');",
                              'route' => ['admin.country.portOfArrivalDeleteCountry', $country_id,$val->id])) !!}
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

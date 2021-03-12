@inject('request', 'Illuminate\Http\Request')
@extends('admin.layouts.app')

@section('content')
    <h3 class="page-title">Country</h3>
    <p>
        <a href="{{ route('admin.country.create') }}" class="btn btn-success">Create</a>

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
                        <th>Title</th>
                        <th>Country Code</th>
                        <th>Country Flag</th>
                        <th>Popular Visa</th>
                        <th>Current Status</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>

                <tbody>
                  @foreach($countryData as $key => $val)
                    <tr data-entry-id="">
                        <td></td>
                        <td>{{$val->country_name}}</td>
                        <td>{{$val->country_code}}</td>
                        <td>
                        @if($val->country_flag != "")
                          <img src="{{url('images/country/'.$val->country_flag)}}" onerror="this.src='{{ url('images/default.png') }}'" id="img_left" width="50" height="50"/>
                        @endif
                        <td>
                          {{$val->popular_visa}}
                        </td>
                        <td>
                          {{$val->status == 1 ? "Activated" : "Inactived"}}
                        </td>
                        <td>
                          <a href="{{ route('admin.country.edit',[$val->id]) }}" class="btn btn-xs btn-info">Edit</a>

                          {!! Form::open(array(
                              'style' => 'display: inline-block;',
                              'method' => 'PUT',
                              'onsubmit' => "return confirm('Are you sure?');",
                              'route' => 'admin.country.status')) !!}
                          {!! Form::hidden('id',$val->id  ) !!}
                          {!! Form::hidden('status',($val->status == 1 ? 2 : 1)  ) !!}
                          {!! Form::submit($val->status == 1 ? "Inactived" : "Activated", array('class' => strtolower($val->status) == 1 ? "btn btn-xs btn-warning" : "btn btn-xs btn-success")) !!}
                          {!! Form::close() !!}

                          {!! Form::open(array(
                              'style' => 'display: inline-block;',
                              'method' => 'DELETE',
                              'onsubmit' => "return confirm('Are you sure?');",
                              'route' => ['admin.country.destroy', $val->id])) !!}
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

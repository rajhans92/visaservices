@inject('request', 'Illuminate\Http\Request')
@extends('admin.layouts.app')

@section('content')
    <h3 class="page-title">Services Pages</h3>
    <p>
        <a href="{{ route('admin.services.create') }}" class="btn btn-success">Create</a>

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
                        <th>Services Name</th>
                        <th>Services URL</th>
                        <th>Services Headline</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>

                <tbody>
                  @foreach($servicesData as $key => $val)
                    <tr data-entry-id="">
                        <td></td>
                        <td>{{$val->services_name}}</td>
                        <td>{{$val->visa_url}}</td>
                        <td>{{$val->services_heading}}</td>
                        <td>
                          <a href="{{ route('admin.services.edit',[$val->id]) }}" class="btn btn-xs btn-info">Edit</a>
                          <a href="{{ route('admin.services.faqList',[$val->id]) }}" class="btn btn-xs btn-primary">Faq List</a>
                          <a href="{{ route('admin.services.applyDetailList',[$val->id]) }}" class="btn btn-xs btn-warning">Apply Pag</a>
                          <a href="{{ route('admin.services.dataEntryList',[$val->id]) }}" class="btn btn-xs btn-success">Services Table</a>

                          {!! Form::open(array(
                              'style' => 'display: inline-block;',
                              'method' => 'DELETE',
                              'onsubmit' => "return confirm('Are you sure?');",
                              'route' => ['admin.services.destroy', $val->id])) !!}
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

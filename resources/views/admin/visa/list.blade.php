@inject('request', 'Illuminate\Http\Request')
@extends('admin.layouts.app')

@section('content')
    <h3 class="page-title">Visa Pages</h3>
    <p>
        <a href="{{ route('admin.visa.create') }}" class="btn btn-success">Create</a>

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
                        <th>Visa Country</th>
                        <th>Visa URL</th>
                        <th>Visa Headline</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>

                <tbody>
                  @foreach($visaData as $key => $val)
                    <tr data-entry-id="">
                        <td></td>
                        <td>{{$val->country_name}}</td>
                        <td>{{$val->visa_url}}</td>
                        <td>{{$val->visa_heading}}</td>
                        <td>
                          <a href="{{ route('admin.visa.edit',[$val->id]) }}" class="btn btn-xs btn-info">Edit</a>
                          <a href="{{ route('admin.visa.faqList',[$val->id]) }}" class="btn btn-xs btn-primary">Faq List</a>
                          <a href="{{ route('admin.visa.applyDetailList',[$val->id]) }}" class="btn btn-xs btn-warning">Apply Pag</a>
                          <a href="{{ route('admin.visa.typeOfVisaList',[$val->id]) }}" class="btn btn-xs btn-success">Visa Table</a>

                          {!! Form::open(array(
                              'style' => 'display: inline-block;',
                              'method' => 'DELETE',
                              'onsubmit' => "return confirm('Are you sure?');",
                              'route' => ['admin.visa.destroy', $val->id])) !!}
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

@inject('request', 'Illuminate\Http\Request')
@extends('admin.layouts.app')

@section('content')
    <h3 class="page-title">Services Faqs</h3>
    <p>
        <a href="{{ route('admin.services.faqCreate',[$id]) }}" class="btn btn-success">Create</a>

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
                        <th>Services Faq Question</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>

                <tbody>
                  @foreach($faqData as $key => $val)
                    <tr data-entry-id="">
                        <td></td>
                        <td>{{$val->question}}</td>
                        <td>
                          <a href="{{ route('admin.services.faqEdit',[$id,$val->id]) }}" class="btn btn-xs btn-info">Edit</a>

                          {!! Form::open(array(
                              'style' => 'display: inline-block;',
                              'method' => 'DELETE',
                              'onsubmit' => "return confirm('Are you sure?');",
                              'route' => ['admin.services.faqDelete', $id,$val->id])) !!}
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

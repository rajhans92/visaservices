@inject('request', 'Illuminate\Http\Request')
@extends('admin.layouts.app')

@section('content')
    <h3 class="page-title">Blog Category</h3>
    <p>
        <a href="{{ route('admin.blog.categoryAdd') }}" class="btn btn-success">Create</a>

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
                        <th>Category Name</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>

                <tbody>
                  @foreach($data as $key => $val)
                    <tr data-entry-id="">
                        <td></td>
                        <td>{{$val->name}}</td>
                        <td>
                          <a href="{{ route('admin.blog.categoryEdit',[$val->id]) }}" class="btn btn-xs btn-info">Edit</a>

                          {!! Form::open(array(
                              'style' => 'display: inline-block;',
                              'method' => 'DELETE',
                              'onsubmit' => "return confirm('If you delete category, all blog under this category will be deleted.');",
                              'route' => ['admin.blog.categoryDestroy', $val->id])) !!}
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

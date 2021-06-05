@inject('request', 'Illuminate\Http\Request')
@extends('admin.layouts.app')

@section('content')
    <h3 class="page-title">Blog Pages</h3>
    <p>
        <a href="{{ route('admin.blog.create') }}" class="btn btn-success">Create</a>

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
                        <th>Blog category</th>
                        <th>Blog Name</th>
                        <th>Blog URL</th>
                        <th>Blog Headline</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>

                <tbody>
                  @foreach($blogData as $key => $val)
                    <tr data-entry-id="">
                        <td></td>
                        <td>{{$val->category_name}}</td>
                        <td>{{$val->blog_name}}</td>
                        <td>{{$val->visa_url}}</td>
                        <td>{{$val->blog_heading}}</td>
                        <td>
                          <a href="{{ route('admin.blog.edit',[$val->id]) }}" class="btn btn-xs btn-info">Edit</a>

                          {!! Form::open(array(
                              'style' => 'display: inline-block;',
                              'method' => 'DELETE',
                              'onsubmit' => "return confirm('Are you sure?');",
                              'route' => ['admin.blog.destroy', $val->id])) !!}
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

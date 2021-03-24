@inject('request', 'Illuminate\Http\Request')
@extends('admin.layouts.app')

@section('content')
    <h3 class="page-title">Menu</h3>
    <p>
        <a href="{{ route('admin.header.create') }}" class="btn btn-success">Create</a>

    </p>

    <div class="panel panel-default">
        <div class="panel-heading">
            List
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($menuData) > 0 ? 'datatable' : '' }} dt-select ">
                <thead>
                    <tr>
                        <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        <th>Menu Name</th>
                        <th>Menu Link</th>
                        <th>Menu Type</th>
                        <th>Menu Status</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>

                <tbody>
                    @if (count($menuData) > 0)
                        @foreach ($menuData as $data)
                            <tr data-entry-id="{{ $data->id }}">
                                <td></td>

                                <td>{{ $data->name }}</td>
                                <td>{{ $data->url }}</td>
                                <td>{{ $data->menu_type }}</td>
                                <td>{{ $data->status == 1 ? "Active" : "Inactive" }}</td>
                                <td>
                                    <a href="{{ route('admin.header.edit',[$data->id]) }}" class="btn btn-xs btn-info">Edit</a>
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'POST',
                                        'onsubmit' => "return confirm('are you sure?');",
                                        'route' => 'admin.header.updateMenuStatus')) !!}
                                    {!! Form::hidden('id',$data->id  ) !!}
                                    {!! Form::hidden('status',($data->status == 1 ? 0 : 1)  ) !!}
                                    {!! Form::submit($data->status == 1 ? "Inactived" : "Activated", array('class' => $data->status == 1 ? "btn btn-xs btn-warning" : "btn btn-xs btn-success")) !!}
                                    {!! Form::close() !!}

                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('are you sure?');",
                                        'route' => ['admin.header.destroyMenu', $data->id])) !!}
                                    {!! Form::hidden('id',$data->id  ) !!}
                                    {!! Form::submit('Delete', array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                </td>

                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4">No Data Found</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop

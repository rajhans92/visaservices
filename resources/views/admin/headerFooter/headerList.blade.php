@inject('request', 'Illuminate\Http\Request')
@extends('admin.layouts.app')

@section('content')
    <h3 class="page-title">Header</h3>


    <div class="panel panel-default">
        <div class="panel-heading">
            List
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($menuData) > 0 ? 'datatable' : '' }} dt-select ">
                <thead>
                    <tr>
                        <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        <th>Menu</th>
                        <th>Title</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>

                <tbody>
                    @if (count($menuData) > 0)
                        @foreach ($menuData as $data)
                            <tr data-entry-id="{{ $data->id }}">
                                <td></td>

                                <td>{{ $data->title }}</td>

                                <td>{{ $data->name }}</td>
                                <td>
                                    <a href="{{ route('admin.header.edit',[$data->id]) }}" class="btn btn-xs btn-info">Edit</a>
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

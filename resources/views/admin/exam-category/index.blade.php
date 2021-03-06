@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.exam-category.title')</h3>
    @can('exam_category_create')
    <p>
        <a href="{{ route('admin.exam-category.create') }}" class="btn btn-success">@lang('global.app_add_new')</a>

    </p>
    @endcan



    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($category) > 0 ? 'datatable' : '' }} @can('exam_category_delete') dt-select @endcan">
                <thead>
                    <tr>
                        @can('exam_category_delete')
                            <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        @endcan
                        <th>@lang('global.exam-category.fields.name')</th>
                        <th>@lang('global.exam-category.fields.status')</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>

                <tbody>
                    @if (count($category) > 0)
                        @foreach ($category as $data)
                            <tr data-entry-id="{{ $data->id }}">
                                @can('exam_category_delete')
                                    <td></td>
                                @endcan

                                <td>{{ $data->title }}</td>

                                <td>{{ $data->status }}</td>
                                <td>
                                    
                                    @can('exam_category_edit')
                                    <a href="{{ route('admin.exam-category.edit',[$data->id]) }}" class="btn btn-xs btn-info">@lang('global.app_edit')</a>

                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'POST',
                                        'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                        'route' => 'admin.exam-category.update_status')) !!}
                                    {!! Form::hidden('id',$data->id  ) !!}
                                    {!! Form::hidden('status',(strtolower($data->status) == "active" ? 1 : 2)  ) !!}
                                    {!! Form::submit(strtolower($data->status) == "active" ? "Inactived" : "Activated", array('class' => strtolower($data->status) == "active" ? "btn btn-xs btn-warning" : "btn btn-xs btn-success")) !!}
                                    {!! Form::close() !!}

                                    @endcan
                                    @can('exam_category_delete')
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                        'route' => ['admin.exam-category.destroy', $data->id])) !!}
                                    {!! Form::submit(trans('global.app_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                </td>

                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="9">@lang('global.app_no_entries_in_table')</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop

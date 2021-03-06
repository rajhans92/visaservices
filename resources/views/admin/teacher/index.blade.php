@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.teacher.title')</h3>
    @can('teacher_create')
    <p>
        <a href="{{ route('admin.teacher.create') }}" class="btn btn-success">@lang('global.app_add_new')</a>

    </p>
    @endcan



    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($users) > 0 ? 'datatable' : '' }} @can('teacher_delete') dt-select @endcan">
                <thead>
                    <tr>
                        @can('teacher_delete')
                            <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        @endcan
                        <th>@lang('global.teacher.fields.name')</th>
                        <th>@lang('global.teacher.fields.email')</th>
                        <th>@lang('global.teacher.fields.phone')</th>
                        <th>@lang('global.teacher.fields.experience')</th>
                        <th>@lang('global.teacher.fields.specialties')</th>
                        <th>@lang('global.teacher.fields.organization')</th>
                        <th>@lang('global.teacher.fields.status')</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>

                <tbody>
                    @if (count($users) > 0)
                        @foreach ($users as $user)
                            <tr data-entry-id="{{ $user->id }}">
                                @can('teacher_delete')
                                    <td></td>
                                @endcan

                                <td>{{ $user->first_name }} {{ $user->last_name && $user->last_name != null ? $user->last_name : "" }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone_no }}{{ $user->alt_phone_no && $user->alt_phone_no != null ? "/".$user->alt_phone_no : "" }}</td>
                                <td>{{ $user->experience }}</td>
                                <td>{{ $user->specialties }}</td>
                                <td>{{ array_key_exists($user->organization_id,$orgObj) ? $orgObj[$user->organization_id] : $orgObj[0] }}</td>
                                <td>{{ $user->status }}</td>
                                <td>
                                    @can('teacher_view')
                                    <a href="{{ route('admin.teacher.show',[$user->id]) }}" class="btn btn-xs btn-primary">@lang('global.app_view')</a>
                                    @endcan
                                    @can('teacher_edit')
                                    <a href="{{ route('admin.teacher.edit',[$user->id]) }}" class="btn btn-xs btn-info">@lang('global.app_edit')</a>

                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'POST',
                                        'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                        'route' => 'admin.teacher.update_status')) !!}
                                    {!! Form::hidden('userId',$user->id  ) !!}
                                    {!! Form::hidden('status',(strtolower($user->status) == "active" ? 1 : 2)  ) !!}
                                    {!! Form::submit(strtolower($user->status) == "active" ? "Inactived" : "Activated", array('class' => strtolower($user->status) == "active" ? "btn btn-xs btn-warning" : "btn btn-xs btn-success")) !!}
                                    {!! Form::close() !!}

                                    @endcan
                                    @can('teacher_delete')
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                        'route' => ['admin.teacher.destroy', $user->id])) !!}
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

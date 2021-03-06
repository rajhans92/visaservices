@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.subadmin.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_view') &nbsp;&nbsp; <a href="{{ route('admin.subadmin.index') }}" class="btn btn-default">@lang('global.app_back_to_list')</a>
        </div>

        <div class="panel-body">
            <div class="row">
              <div class="col-md-12">

                <img src="{{ env('IMG_URL') }}/img/subadmin/profile/{{ $user->profile_pic }}" onerror="this.src='{{ env('IMG_URL') }}/img/default.png'" width="100" height="100"/>
              </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('global.subadmin.fields.name')</th>
                            <td>{{ $user->first_name }} {{ $user->last_name && $user->last_name != null ? $user->last_name : "" }}</td>

                        </tr>
                        <tr>
                            <th>@lang('global.subadmin.fields.email')</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.subadmin.fields.phone')</th>
                            <td>{{ $user->phone_no }}{{ $user->alt_phone_no && $user->alt_phone_no != null ? "/".$user->alt_phone_no : "" }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.subadmin.fields.post')</th>
                            <td>{{ $user->post }}</td>

                        </tr>
                        <tr>
                            <th>@lang('global.subadmin.fields.status')</th>
                            <td>{{ $user->status }}</td>

                        </tr>
                        <tr>
                            <th>@lang('global.subadmin.fields.dob')</th>
                            <td>{{ date("d-m-Y", strtotime($user->dob)) }}</td>

                        </tr>
                        <tr>
                            <th>@lang('global.subadmin.fields.detail')</th>
                            <td>{!! $user->detail !!}</td>

                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->
<!-- <ul class="nav nav-tabs" role="tablist">

<li role="presentation" class="active"><a href="#courses" aria-controls="courses" role="tab" data-toggle="tab">Courses</a></li>
</ul> -->

<!-- Tab panes -->
<!-- <div class="tab-content">

<div role="tabpanel" class="tab-pane active" id="courses">

</div>
</div> -->

            <p>&nbsp;</p>


        </div>
    </div>
@stop

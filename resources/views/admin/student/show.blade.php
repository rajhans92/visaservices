@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.student.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_view') &nbsp;&nbsp;     <a href="{{ route('admin.student.index') }}" class="btn btn-default">@lang('global.app_back_to_list')</a>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>Profile Pic</th>
                            <td>
                              <img src="{{ env('IMG_URL') }}/img/student/profile/{{ $user->profile_pic }}" onerror="this.src='{{ env('IMG_URL') }}/img/default.png'" width="100" height="100"/>
                            </td>

                        </tr>
                        <tr>
                            <th>@lang('global.student.fields.name')</th>
                            <td>{{ $user->first_name }} {{ $user->last_name && $user->last_name != null ? $user->last_name : "" }}</td>

                        </tr>
                        <tr>
                            <th>@lang('global.student.fields.email')</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.student.fields.phone')</th>
                            <td>{{ $user->phone_no }}{{ $user->alt_phone_no && $user->alt_phone_no != null ? "/".$user->alt_phone_no : "" }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.student.fields.dob')</th>
                            <td>{{ date('d/m/Y',strtotime($user->dob)) }}</td>

                        </tr>
                        <tr>
                            <th>@lang('global.student.fields.status')</th>
                            <td>{{ $user->status }}</td>

                        </tr>
                        <tr>
                            <th>@lang('global.student.fields.education')</th>
                            <td>{{ $user->education }}</td>

                        </tr>
                        <tr>
                            <th>@lang('global.student.fields.teacher')</th>
                            <td>{{ array_key_exists($user->teacher_id,$teacherObj) ? $teacherObj[$user->teacher_id] : $teacherObj[0] }}</td>

                        </tr>
                        <tr>
                            <th>@lang('global.student.fields.organization')</th>
                            <td>{{ array_key_exists($user->organization_id,$orgObj) ? $orgObj[$user->organization_id] : $orgObj[0] }}</td>

                        </tr>
                        <tr>
                            <th>@lang('global.student.fields.address')</th>
                            <td>{{ $user->address }}</td>

                        </tr>
                        <tr>
                            <th>@lang('global.student.fields.about')</th>
                            <td>{{ $user->about }}</td>

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

@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.org.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_view')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>Profile Pic</th>
                            <td>
                              <img src="{{ env('IMG_URL') }}/img/org/profile/{{ $user->profile_pic }}" onerror="this.src='{{ env('IMG_URL') }}/img/default.png'" width="100" height="100"/>
                            </td>

                        </tr>
                        <tr>
                            <th>Banner</th>
                            <td>
                              <img src="{{ env('IMG_URL') }}/img/org/banner/{{ $user->banner }}" onerror="this.src='{{ env('IMG_URL') }}/img/org/banner-default.jpg'"  height="100"/>
                            </td>

                        </tr>
                        <tr>
                            <th>@lang('global.org.fields.name')</th>
                            <td>{{ $user->first_name }} {{ $user->last_name && $user->last_name != null ? $user->last_name : "" }}</td>

                        </tr>
                        <tr>
                            <th>@lang('global.org.fields.email')</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.org.fields.phone')</th>
                            <td>{{ $user->phone_no }}{{ $user->alt_phone_no && $user->alt_phone_no != null ? "/".$user->alt_phone_no : "" }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.org.fields.established')</th>
                            <td>{{ date('d/m/Y',strtotime($user->established_date)) }}</td>

                        </tr>
                        <tr>
                            <th>@lang('global.org.fields.status')</th>
                            <td>{{ $user->status }}</td>

                        </tr>
                        <tr>
                            <th>@lang('global.org.fields.website')</th>
                            <td>{{ $user->website }}</td>

                        </tr>
                        <tr>
                            <th>@lang('global.org.fields.teacher_strength')</th>
                            <td>{{ $user->teacher_strength }}</td>

                        </tr>
                        <tr>
                            <th>@lang('global.org.fields.student_strength')</th>
                            <td>{{ $user->student_strength }}</td>

                        </tr>
                        <tr>
                            <th>@lang('global.org.fields.address')</th>
                            <td>{{ $user->address }}</td>

                        </tr>
                        <tr>
                            <th>@lang('global.org.fields.specialties')</th>
                            <td>{{ $user->specialties }}</td>

                        </tr>
                        <tr>
                            <th>@lang('global.org.fields.overview')</th>
                            <td>{{ $user->overview }}</td>

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

            <a href="{{ route('admin.org.index') }}" class="btn btn-default">@lang('global.app_back_to_list')</a>
        </div>
    </div>
@stop

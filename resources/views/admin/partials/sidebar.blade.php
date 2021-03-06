@inject('request', 'Illuminate\Http\Request')
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar"  style="height: 580px !important;overflow-y: auto;">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <ul class="sidebar-menu">

            <li class="{{ $request->segment(1) == '' ? 'active' : '' }}">
                <a href="{{ url('/admin/') }}">
                    <i class="fa fa-wrench"></i>
                    <span class="title">@lang('global.app_dashboard')</span>
                </a>
            </li>


            @can('user_management_access')
            <li class="treeview active">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span class="title">@lang('global.user-management.title')</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">

                @can('permission_access')
                <li class="{{ $request->segment(2) == 'permissions' ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.permissions.index') }}">
                            <i class="fa fa-briefcase"></i>
                            <span class="title">
                                @lang('global.permissions.title')
                            </span>
                        </a>
                    </li>
                @endcan
                @can('role_access')
                <li class="{{ $request->segment(2) == 'roles' ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.roles.index') }}">
                            <i class="fa fa-briefcase"></i>
                            <span class="title">
                                @lang('global.roles.title')
                            </span>
                        </a>
                    </li>
                @endcan
                @can('subadmin_access')
                <li class="{{ $request->segment(2) == 'subadmin' ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.subadmin.index') }}">
                            <i class="fa fa-user"></i>
                            <span class="title">
                                @lang('global.subadmin.title')
                            </span>
                        </a>
                    </li>
                @endcan
                @can('org_access')
                <li class="{{ $request->segment(2) == 'org' ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.org.index') }}">
                            <i class="fa fa-users"></i>
                            <span class="title">
                                @lang('global.org.title')
                            </span>
                        </a>
                    </li>
                @endcan
                @can('teacher_access')
                <li class="{{ $request->segment(2) == 'teacher' ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.teacher.index') }}">
                            <i class="fa fa-user"></i>
                            <span class="title">
                                @lang('global.teacher.title')
                            </span>
                        </a>
                    </li>
                @endcan
                @can('student_access')
                <li class="{{ $request->segment(2) == 'student' ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.student.index') }}">
                            <i class="fa fa-user"></i>
                            <span class="title">
                                @lang('global.student.title')
                            </span>
                        </a>
                    </li>
                @endcan
                </ul>
            </li>
            @endcan


            @can('exam_management_access')
            <li class="treeview active">
                <a href="#">
                    <i class="fa fa-server"></i>
                    <span class="title">@lang('global.exam-management.title')</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">

                  @can('exam_slider_access')
                  <li class="{{ $request->segment(2) == 'exam-slider' ? 'active active-sub' : '' }}">
                          <a href="{{ route('admin.exam-slider.index') }}">
                              <i class="fa fa-picture-o"></i>
                              <span class="title">
                                  @lang('global.exam-slider.title')
                              </span>
                          </a>
                      </li>
                  @endcan

                  @can('language_access')
                  <li class="{{ $request->segment(2) == 'language' ? 'active active-sub' : '' }}">
                          <a href="{{ route('admin.language.index') }}">
                              <i class="fa fa-language"></i>
                              <span class="title">
                                  @lang('global.language.title')
                              </span>
                          </a>
                      </li>
                  @endcan


                @can('exam_category_access')
                <li class="{{ $request->segment(2) == 'exam-category' ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.exam-category.index') }}">
                            <i class="fa fa-cubes"></i>
                            <span class="title">
                                @lang('global.exam-category.title')
                            </span>
                        </a>
                    </li>
                @endcan

                @can('exam_access')
                <li class="{{ $request->segment(2) == 'exam' ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.exam.index') }}">
                            <i class="fa fa-book"></i>
                            <span class="title">
                                @lang('global.exam.title')
                            </span>
                        </a>
                    </li>
                @endcan
                @can('exam_schedule_access')
                <li class="{{ $request->segment(2) == 'exam-schedule' ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.exam-schedule.index') }}">
                            <i class="fa fa-table"></i>
                            <span class="title">
                                @lang('global.exam-schedule.title')
                            </span>
                        </a>
                    </li>
                @endcan
                @can('uncheck_paper_access')
                <li class="{{ $request->segment(2) == 'uncheck-paper' ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.uncheck-paper.index') }}">
                            <i class="fa fa-file-o"></i>
                            <span class="title">
                                @lang('global.uncheck-paper.title')
                            </span>
                        </a>
                    </li>
                @endcan
                @can('exam_result_access')
                <li class="{{ $request->segment(2) == 'exam-result' ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.exam-result.index') }}">
                            <i class="fa fa-graduation-cap"></i>
                            <span class="title">
                                @lang('global.exam-result.title')
                            </span>
                        </a>
                    </li>
                @endcan
                </ul>
            </li>
            @endcan

            <li class="treeview active">
                <a href="#">
                    <i class="fa fa-briefcase"></i>
                    <span class="title">@lang('global.account.title')</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ $request->segment(1) == 'user-profile' ? 'active' : '' }}">
                        <a href="{{ route('admin.user-profile.index') }}">
                            <i class="fa fa-cogs"></i>
                            <span class="title">Profile Details</span>
                        </a>
                    </li>
                    <li class="{{ $request->segment(1) == 'change_password' ? 'active' : '' }}">
                        <a href="{{ route('admin.auth.change_password') }}">
                            <i class="fa fa-key"></i>
                            <span class="title">Change password</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>

                <a href="#logout" onclick="$('#logout').submit();">
                    <i class="fa fa-arrow-left"></i>
                    <span class="title">@lang('global.app_logout')</span>
                </a>
            </li>
        </ul>
    </section>
</aside>
{!! Form::open(['route' => 'auth.logout', 'style' => 'display:none;', 'id' => 'logout']) !!}
<button type="submit">@lang('global.logout')</button>
{!! Form::close() !!}

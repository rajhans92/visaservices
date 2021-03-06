@extends('layouts.app')
@section('content')
    <h3 class="page-title">@lang('global.account.fields.title')</h3>

    {!! Form::model($user, ['method' => 'PUT', 'route' => ['admin.user-profile.update', $user->user_id] , 'files'=>true]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_edit')
        </div>

        <div class="panel-body"> 
            <div class="row">
              @if($user->role_id == 1 || $user->role_id == 4 )
              <div class="col-xs-4 form-group">
                @if($user->profile_pic != "")
                  {!! Form::label('current_pic','Profile Pic')!!}
                  <div>
                    <img src="{{ env('IMG_URL') }}/img/subadmin/profile/{{ $user->profile_pic }}" onerror="this.src='{{ env('IMG_URL') }}/img/default.png'" id="current_pic" width="100" height="100"/>
                  </div>
                @endif
              </div>
              @endif
              @if($user->role_id == 2 )
              <div class="col-xs-4 form-group">
                @if($user->profile_pic != "")
                  {!! Form::label('current_pic','Profile Pic')!!}
                  <div>
                    <img src="{{ env('IMG_URL') }}/img/teacher/profile/{{ $user->profile_pic }}" onerror="this.src='{{ env('IMG_URL') }}/img/default.png'" id="current_pic" width="100" height="100"/>
                  </div>
                @endif
              </div>
              <div class="col-xs-4 form-group">
                @if($user->banner != "")
                  {!! Form::label('current_banner','Organization Banner')!!}
                  <div>
                    <img src="{{ env('IMG_URL') }}/img/teacher/banner/{{ $user->banner }}" onerror="this.src='{{ env('IMG_URL') }}/img/teacher/banner-default.jpg'" id="current_banner"  height="100"/>
                  </div>
                @endif
              </div>
              @endif
              @if($user->role_id == 5 )
              <div class="col-xs-4 form-group">
                 @if($user->profile_pic != "")
                    {!! Form::label('current_pic','Profile Pic')!!}
                    <div>
                      <img src="{{ env('IMG_URL') }}/img/org/profile/{{ $user->profile_pic }}" onerror="this.src='{{ env('IMG_URL') }}/img/default.png'" id="current_pic" width="100" height="100"/>
                    </div>
                  @endif
              </div>
              <div class="col-xs-4 form-group">
                @if($user->banner != "")
                  {!! Form::label('current_banner','Organization Banner')!!}
                  <div>
                    <img src="{{ env('IMG_URL') }}/img/org/banner/{{ $user->banner }}" onerror="this.src='{{ env('IMG_URL') }}/img/org/banner-default.jpg'" id="current_banner"  height="100"/>
                  </div>
                @endif
              </div>
              @endif
            </div>
            <div class="row">
              <div class="col-xs-4 form-group">
                  {!! Form::label('profile_pic','Update Profile Pic')!!}
                  {!! Form::file('profile_pic',['class'=>'form-control'])!!}
              </div>
              @if($user->role_id == 5 )
              <div class="col-xs-4 form-group">
                  {!! Form::label('banner','Organization Banner')!!}
                  {!! Form::file('banner',['class'=>'form-control'])!!}
              </div>
              @endif
              @if($user->role_id == 2 )
              <div class="col-xs-4 form-group">
                  {!! Form::label('banner','Teacher Banner')!!}
                  {!! Form::file('banner',['class'=>'form-control'])!!}
              </div>
              @endif
              <div class="col-xs-4 form-group">
                  {!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
                  {!! Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => '', 'readonly' => '']) !!}
                  <p class="help-block"></p>
                  @if($errors->has('email'))
                      <p class="help-block">
                          {{ $errors->first('email') }}
                      </p>
                  @endif
              </div>
              @if($user->role_id == 1 || $user->role_id == 4 )
              <div class="col-xs-4 form-group">
                  {!! Form::label('post', 'Post', ['class' => 'control-label']) !!}
                  {!! Form::text('post', old('post'), ['class' => 'form-control', 'placeholder' => '','readonly' => '']) !!}
                  @if($errors->has('post'))
                      <p class="help-block">
                          {{ $errors->first('post') }}
                      </p>
                  @endif
              </div>
              @endif
            </div>
            <div class="row">
                <div class="col-xs-4 form-group">
                    {!! Form::label('first_name', 'First Name*', ['class' => 'control-label']) !!}
                    {!! Form::text('first_name', old('first_name'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('first_name'))
                        <p class="help-block">
                            {{ $errors->first('first_name') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-4 form-group">
                    {!! Form::label('last_name', 'Last Name', ['class' => 'control-label']) !!}
                    {!! Form::text('last_name', old('last_name'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('last_name'))
                        <p class="help-block">
                            {{ $errors->first('last_name') }}
                        </p>
                    @endif
                </div>
                @if($user->role_id == 1 || $user->role_id == 2 || $user->role_id == 4 )

                <div class="col-xs-4 form-group">
                    {!! Form::label('dob', 'Date of Birth*', ['class' => 'control-label']) !!}
                      <div class='input-group date'>
                          <input type='text' value="{{ old('dob') ? old('dob') : date('d-m-Y',strtotime($user->dob))}}"  name="dob" class="form-control" id="dob"/>
                          <span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                      </div>
                      <p class="help-block"></p>
                      @if($errors->has('dob'))
                          <p class="help-block">
                              {{ $errors->first('dob') }}
                          </p>
                      @endif
                </div>
                @endif

                @if($user->role_id == 5 )
                <div class="col-xs-4 form-group">
                    {!! Form::label('established_date', 'Established Date*', ['class' => 'control-label']) !!}
                      <div class='input-group date'>
                          <input type='text'  name="established_date" value="{{ old('established_date') ? old('established_date') : date('d-m-Y',strtotime($user->established_date))}}" class="form-control" id="established_date" required/>
                          <span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                      </div>
                      <p class="help-block"></p>
                      @if($errors->has('established_date'))
                          <p class="help-block">
                              {{ $errors->first('established_date') }}
                          </p>
                      @endif
                </div>
                @endif
            </div>
            <div class="row">
                <div class="col-xs-4 form-group">
                    {!! Form::label('phone_no', 'Phone No*', ['class' => 'control-label']) !!}
                    {!! Form::number('phone_no', old('phone_no'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('phone_no'))
                        <p class="help-block">
                            {{ $errors->first('phone_no') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-4 form-group">
                    {!! Form::label('alt_phone_no', 'Alternate Phone No', ['class' => 'control-label']) !!}
                    {!! Form::number('alt_phone_no', old('alt_phone_no'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('alt_phone_no'))
                        <p class="help-block">
                            {{ $errors->first('alt_phone_no') }}
                        </p>
                    @endif
                </div>

                @if($user->role_id == 2 )
                <div class="col-xs-4 form-group">
                    {!! Form::label('organization_id', 'Organization*', ['class' => 'control-label']) !!}
                    {!! Form::select('organization_id', $orgObj,old('organization_id') ? old('organization_id') : $user->organization_id,['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('organization_id'))
                        <p class="help-block">
                            {{ $errors->first('organization_id') }}
                        </p>
                    @endif
                </div>
                @endif
              </div>
              <div class="row">



            </div>
            @if($user->role_id == 2 )
              <div class="row">
                <div class="col-xs-8 form-group">
                  <div class="row">
                    <div class="col-xs-6 form-group">
                        {!! Form::label('education', 'Education*', ['class' => 'control-label']) !!}
                        {!! Form::text('education', old('education'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                        <p class="help-block"></p>
                        @if($errors->has('education'))
                            <p class="help-block">
                                {{ $errors->first('education') }}
                            </p>
                        @endif
                    </div>
                    <div class="col-xs-6 form-group">
                        {!! Form::label('experience', 'Experience*', ['class' => 'control-label']) !!}
                        {!! Form::number('experience', old('experience'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                        <p class="help-block"></p>
                        @if($errors->has('experience'))
                            <p class="help-block">
                                {{ $errors->first('experience') }}
                            </p>
                        @endif
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-xs-6 form-group">
                        {!! Form::label('specialties', 'Specialties *', ['class' => 'control-label']) !!}
                        {!! Form::text('specialties', old('specialties'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                        <p class="help-block"></p>
                        @if($errors->has('specialties'))
                            <p class="help-block">
                                {{ $errors->first('specialties') }}
                            </p>
                        @endif
                    </div>
                    <div class="col-xs-6 form-group">
                        {!! Form::label('website', 'Website', ['class' => 'control-label']) !!}
                        {!! Form::text('website', old('website'), ['class' => 'form-control', 'placeholder' => '']) !!}
                        <p class="help-block"></p>
                        @if($errors->has('website'))
                            <p class="help-block">
                                {{ $errors->first('website') }}
                            </p>
                        @endif
                    </div>

                </div>
                </div>
                <div class="col-xs-4 form-group">
                  {!! Form::label('address', 'Address*', ['class' => 'control-label']) !!}
                  {!! Form::text('address', old('address'),['class' => 'form-control', 'placeholder' => '','style'=>'margin: 0px 24.3281px 0px 0px; width: 307px; height: 118px;']) !!}
                  <p class="help-block"></p>
                  @if($errors->has('address'))
                      <p class="help-block">
                          {{ $errors->first('address') }}
                      </p>
                  @endif
                </div>
                </div>
                <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('overview', 'Overview*', ['class' => 'control-label']) !!}
                    {!! Form::textarea('overview', old('overview'),['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('overview'))
                        <p class="help-block">
                            {{ $errors->first('overview') }}
                        </p>
                    @endif
                </div>
              </div>

            @endif
            @if($user->role_id == 1 || $user->role_id == 4 )
            <div class="row">
              <div class="col-xs-12 form-group">
                  {!! Form::label('detail', 'About Admin *', ['class' => 'control-label']) !!}
                  {!! Form::textarea('detail', old('detail'),['class' => 'form-control', 'placeholder' => '']) !!}
                  <p class="help-block"></p>
                  @if($errors->has('detail'))
                      <p class="help-block">
                          {{ $errors->first('detail') }}
                      </p>
                  @endif
              </div>
            </div>
            @endif

            @if($user->role_id == 5)
              <div class="row">
                <div class="col-xs-8 form-group">
                  <div class="row">
                    <div class="col-xs-6 form-group">
                        {!! Form::label('teacher_strength', 'Strength of Teacher*', ['class' => 'control-label']) !!}
                        {!! Form::number('teacher_strength', old('teacher_strength'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                        <p class="help-block"></p>
                        @if($errors->has('teacher_strength'))
                            <p class="help-block">
                                {{ $errors->first('teacher_strength') }}
                            </p>
                        @endif
                    </div>
                    <div class="col-xs-6 form-group">
                        {!! Form::label('student_strength', 'Strength of Student*', ['class' => 'control-label']) !!}
                        {!! Form::number('student_strength', old('student_strength'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                        <p class="help-block"></p>
                        @if($errors->has('student_strength'))
                            <p class="help-block">
                                {{ $errors->first('student_strength') }}
                            </p>
                        @endif
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-xs-6 form-group">
                      {!! Form::label('specialties', 'Specialties *', ['class' => 'control-label']) !!}
                      {!! Form::text('specialties', old('specialties'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                      <p class="help-block"></p>
                      @if($errors->has('specialties'))
                          <p class="help-block">
                              {{ $errors->first('specialties') }}
                          </p>
                      @endif
                    </div>
                    <div class="col-xs-6 form-group">
                      {!! Form::label('website', 'Website', ['class' => 'control-label']) !!}
                      {!! Form::text('website', old('website'), ['class' => 'form-control', 'placeholder' => '']) !!}
                      <p class="help-block"></p>
                      @if($errors->has('website'))
                          <p class="help-block">
                              {{ $errors->first('website') }}
                          </p>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="col-xs-4 form-group">
                  {!! Form::label('address', 'Organization Address*', ['class' => 'control-label']) !!}
                  {!! Form::text('address', old('address'),['class' => 'form-control', 'placeholder' => '', 'style'=>'margin: 0px 29.3281px 0px 0px; height: 118px; width: 302px;', 'required' => '']) !!}
                  <p class="help-block"></p>
                  @if($errors->has('address'))
                      <p class="help-block">
                          {{ $errors->first('address') }}
                      </p>
                  @endif
                </div>
                </div>
              <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('overview', 'Organization Overview*', ['class' => 'control-label']) !!}
                    {!! Form::textarea('overview', old('overview'),['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('overview'))
                        <p class="help-block">
                            {{ $errors->first('overview') }}
                        </p>
                    @endif
                </div>
              </div>
            @endif
        </div>
    </div>

    {!! Form::submit(trans('global.app_update'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop
@section('javascript')

<script type="text/javascript">

    $(function(){
      $('#dob').datepicker({
        format: 'dd-mm-yyyy',
        endDate: '-1d',
      });
      $('#dob').datepicker({
        format: 'dd-mm-yyyy',
        endDate: '-1d',
      });
    });
</script>

@endsection

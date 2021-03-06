@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.exam-slider.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_view')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>Slider Photo</th>
                            <td>
                              <img src="{{ env('IMG_URL') }}/img/slider/{{ $slider->path }}" onerror="this.src='{{ env('IMG_URL') }}/img/default.png'" width="100" height="100"/>
                            </td>

                        </tr>
                        <tr>
                            <th>@lang('global.exam-slider.fields.name')</th>
                            <td>{{ $slider->title }}</td>

                        </tr>
                        <tr>
                            <th>@lang('global.exam-slider.fields.detail')</th>
                            <td>{!! $slider->detail !!}</td>

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

            <a href="{{ route('admin.exam-slider.index') }}" class="btn btn-default">@lang('global.app_back_to_list')</a>
        </div>
    </div>
@stop

@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.exam-schedule.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_view')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>Exam Logo</th>
                            <td>
                              @if($exam_schedule->exam_banner != "")
                                <img src="{{ env('IMG_URL') }}/img/exam_schedule/{{ $exam_schedule->id }}/logo/{{ $exam_schedule->exam_logo }}" onerror="this.src='{{ env('IMG_URL') }}/img/default.png'" width="100" height="100"/>
                              @else
                                NA
                              @endif

                            </td>
                            <th>Exam Banner</th>
                            <td>
                              @if($exam_schedule->exam_banner != "")
                                <img src="{{ env('IMG_URL') }}/img/exam_schedule/{{ $exam_schedule->id }}/banner/{{ $exam_schedule->exam_banner }}" onerror="this.src='{{ env('IMG_URL') }}/img/exam_schedule/banner-default.jpg'"  height="100"/>
                              @else
                                NA
                              @endif
                            </td>
                        </tr>
                        <tr>
                            <th>@lang('global.exam-schedule.fields.display')</th>
                            <td>{{ $exam_schedule->exam_display_name }}</td>
                            <th>@lang('global.exam-schedule.fields.name')</th>
                            <td>{{ $exam_schedule->exam_name }}</td>

                        </tr>
                        <tr>
                            <th>@lang('global.exam-schedule.fields.sponsored')</th>
                            <td>{{ $exam_schedule->first_name }} {{ $exam_schedule->last_name && $exam_schedule->last_name != null ? $exam_schedule->last_name : "" }}</td>
                            <th>@lang('global.exam-schedule.fields.date')</th>
                            <td>{{ date('d/m/Y  h:i a',strtotime( $exam_schedule->start_date)) }} to {{date('d/m/Y  h:i a',strtotime( $exam_schedule->end_date))}}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.exam-schedule.fields.result_date')</th>
                            <td>{{ date('d/m/Y h:i a',strtotime($exam_schedule->result_date)) }}</td>
                            <th>@lang('global.exam-schedule.fields.limit')</th>
                            <td>{{ $exam_schedule->user_limit }}</td>

                        </tr>
                        <tr>
                            <th>@lang('global.exam-schedule.fields.winner')</th>
                            <td>{{ $exam_schedule->no_of_winner }}</td>

                            <th>@lang('global.exam-schedule.fields.prize')</th>
                            <td>{{ $exam_schedule->prize_amount }}</td>

                        </tr>
                        <tr>
                            <th>@lang('global.exam-schedule.fields.reminder')</th>
                            <td>{{ $exam_schedule->reminder }}</td>

                            <th>@lang('global.exam-schedule.fields.status')</th>
                            <td>{{ $exam_schedule->status }}</td>

                        </tr>
                        <tr>
                            <th>@lang('global.exam-schedule.fields.detail')</th>
                            <td colspan="3">{!! $exam_schedule->exam_detail !!}</td>

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

            <a href="{{ route('admin.exam-schedule.index') }}" class="btn btn-default">@lang('global.app_back_to_list')</a>
        </div>
    </div>
@stop

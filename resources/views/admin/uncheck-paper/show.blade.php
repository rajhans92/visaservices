@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.exam-schedule.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_view') &nbsp;&nbsp;<a href="{{ route('admin.exam-schedule.index') }}" class="btn btn-default">@lang('global.app_back_to_list')</a>
        </div>

        <div class="panel-body">
          {!! $htmlString !!}
        </div>



            <p>&nbsp;</p>


        </div>
    </div>
@stop
@section('javascript')

<script type="text/javascript">

    $(function(){
       $( "#tabs" ).tabs();
     });
 </script>

 @endsection

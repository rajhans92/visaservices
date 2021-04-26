@extends('front.layouts.app')

@section('content')

<section class="error-section">
  <div class="container">
     <div class="row" style="padding: 102px 0;">

    <div class="col-md-12 col-middle" style="text-align:center">
        <img src="{{url('images/services/apply/'.(isset($applyData->thank_you_img) ? $applyData->thank_you_img :""))}}" width="8%">
      <span>
        @if(isset($applyData->thank_you_content))
        {!! $applyData->thank_you_content !!}
        @endif
      </span>
    </div>
  </div>
</div>
            </div>
            </div>
            </div>
</section>

@stop
@section('javascript')

<script type="text/javascript">

</script>
@endsection

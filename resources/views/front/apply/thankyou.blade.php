@extends('front.layouts.app')

@section('content')

<section class="error-section">
  <div class="container">
     <div class="row" style="padding: 102px 0;">

    <div class="col-md-12 col-middle" style="text-align:center">
        <img src="https://beachlineshuttle.com/wp-content/uploads/2019/10/Check-mark.png" width="8%">
      <h1 class="text-jumbo text-ginormous hide-sm">Thank You!</h1>
      <h3>Your reference id is {{$visaDetail->order_id}}. Kindly note for future reference.</h2>
      <h6>Lorem ipsum is placeholder text commonly used in the graphic, print, and publishing industries for previewing layouts and visual mockups.</h6>
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

@extends('front.layouts.app')

@section('content')
<section class="track-section">
  <div class="container">
    <div class="row">
        <h1 class="inner-head">Track your Application</h1>
        <div class="col-sm-10">
          <div class="row">
              <div class="col-sm-6">
                  <div class="form-content">
                      <form>
                         <input type="text" name="order_id" id="inputOrderNumber" placeholder="Order Number" required="">
                      </form>
                  </div>
              </div>
              <!-- <div class="col-sm-6">
                  <div class="form-content">
                      <form>
                         <input type="email" id="email" name="email" value="" placeholder="Email Address" aria-describedby="emailHelp" required="">
                      </form>
                  </div>
              </div> -->
              <!-- <span class="label-or">And</span> -->
              <button type="button" class="btn" id="submitBtn">Check Status</button>
          </div>
          <div class="row">
              <div class="col-sm-6">
                <div id="statusMsg">

                </div>
              </div>
            </div>
          <div class="track-bottom-links">
              <a href="#"><i class="far fa-file-alt"></i>Start New Application</a>
              <a href="#"><i class="far fa-user"></i>Refer Friend</a>
              <a href="#"><i class="far fa-comments"></i>Contact Us</a>
          </div>
        </div>
    </div>
  </div>
</section>


@stop
@section('javascript')

<script type="text/javascript">
$("#submitBtn").click(function(){
      let orderNumber = $("#inputOrderNumber").val();

      if(orderNumber.length > 0){
        $.ajax({
          type: "POST",
          url: '{{url("/tracking-status")}}',
          data: {
            "_token": "{{ csrf_token() }}",
            "orderNumber":orderNumber
          },
          success: function(data) {
            returnJsonData = JSON.parse(data);
            if(returnJsonData.status == true){
              $("#statusMsg").html("<div>Status : "+returnJsonData.data.tracking_status+"</div><div>Description : "+returnJsonData.data.tracking_status_desc+"</div>");

            }else {
              $("#statusMsg").html('Invalid order Number');
            }
          }
        });
      }else{
        $("#statusMsg").html('');
      }
});
</script>
@endsection

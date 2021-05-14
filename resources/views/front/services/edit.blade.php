@extends('front.layouts.app')

@section('content')

<h1 class="inner-head bg-heading" style="text-align:center;">Get Your Travel Document for India</h1>
<section class="apply-section">
  <div class="container">
    <div class="row d-flex justify-center">
      <div class="col-sm-12">
          <form method="POST" action="{{ route('services.save') }}" accept-charset="UTF-8" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <div class="apply-box">
              <div class="apply-box-header">
                  <h2>General Information</h2>

              </div>
              <div class="apply-box-form">
                  <div class="row d-flex">
                    <div class="col-sm-3">
                        <div class="from-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" required="" value="{{$servicesData->name}}">
                            <input type="hidden" name="services" value="{{$servicesData->services_name}}">
                        </div>
                    </div>
                      <div class="col-sm-3">
                          <div class="from-group">
                              <label>Email Address</label>
                              <input type="email" name="email" class="form-control" required="" value="{{$servicesData->email_id}}">
                          </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="from-group">
                            <label>Nationality</label>
                              <select name="nationality" class="nationality" required = "">
                                <option value="">Select</option>
                                @foreach($allServicesData as $key => $data)
                                  <option value="{{$key}}" {{$default_nationality == $key ? "selected":""}}>{{$key}}</option>
                                @endforeach
                              </select>
                        </div>
                      </div>
                      <div class="col-sm-3">
                          <div class="from-group">
                              <label>Country Living In</label>
                            <select name="livincountry" id="livincountry" required="" >
                                <option value="">Select</option>
                                @foreach($countryName as $key => $data)
                                  <option value="{{$data->country_name}}" {{$servicesData->country_live == $data->country_name ? "selected" : ""}}>{{$data->country_name}}</option>
                                @endforeach
                            </select>
                          </div>
                      </div>
                       <div class="col-sm-3">
                          <div class="from-group">
                              <label>Contact No ( With Country Code )</label>
                             <input type="text" name="phone" class="form-control" required = "" max="13" value="{{$servicesData->contact_no}}">
                          </div>
                      </div>

                  </div>
              </div>
          </div>

        <div class="apply-box-main apply-box applicant-box" >

            </div>
            <div class="process-time-box">
                <div class="apply-box-header">
                  <h2>PROCESSING TIME AND FEE</h2>
              </div>
              <div class="row d-flex">
                  <div class="col-sm-12">
                    <div class="processing-box">
                      <div class="processing-time">
                          <input type="radio" name="visa_process_type" checked="checked" class="visa_process_type" {{strtolower($servicesData->visa_process_type) == "standard" ? 'checked="checked"' :"" }} id="standard" value="standard">
              <span class="checkmark"></span>
                          <b>Standard <br><span>{{$servicesDetail->standard_time_duration}}</span></b>
                      </div>
                      <div class="processing-time">
                          <input type="radio" id="rush" class="visa_process_type" name="visa_process_type" {{strtolower($servicesData->visa_process_type) == "rush" ? 'checked="checked"' :"" }} value="rush">
              <span class="checkmark"></span>
                              <b>Rush <br><span>{{$servicesDetail->rush_time_duration}}</span></b>
                      </div>
                      <div class="processing-time">
                          <input type="radio" name="visa_process_type" class="visa_process_type" value="express" {{strtolower($servicesData->visa_process_type) == "express" ? 'checked="checked"' :"" }}>
              <span class="checkmark"></span>
                              <b>Express <br><span>{{$servicesDetail->express_time_duration}}</span></b>
                      </div>
                      </div>
                  </div>
              </div>
            </div>

            <div class="apply-box">
              <div class="apply-box-header">
                <h2>Order Details</h2>
              </div>
              <div class="order-total-sum">
                @if(isset($servicesDetail->is_govt_apply) && $servicesDetail->is_govt_apply == 1)
                  <div class="sum-info">
                  <div>Government Fees (Pay on Arrival)</div>
                  <div><span class="currencyShow">{{$default_currency}}</span> <span id="totalGovtAmount">{{$servicesData->govt_fee}}</span></div>
                </div>
                @endif
                <div class="sum-info">
                  <div>Service Fee</div>
                  <div><span class="currencyShow">{{$default_currency}}</span> <span id="totalApplicantAmount">{{$servicesData->service_fee}}</span></div>
                </div>
              </div>
            </div>
            <div class="total-sum">
                <h4>Total:
                <span>
                    <select id="currencyChange">
                      <option value="USD">USD</option>
                      @foreach($currencyRate as $key => $value)
                        <option value="{{strtoupper($value->code)}}">{{strtoupper($value->code)}}</option>
                      @endforeach
                    </select>
                      <span id="totalAmount">{{$servicesData->total_payment}}</span></span></h4>
                <button class="btn" type="submit">Save & Continue</button>
                <p>*terms and conditions apply</p>
            </div>

          </form>
      </div>
    </div>
    </div>
  </div>
</section>


@stop
@section('javascript')

<script type="text/javascript">
function feeCalculate() {
  $('#feeModal').modal('show');
}
function closeModal() {
  $('#feeModal').modal('hide');
}
$(function(){
  let countryNameList = <?php echo json_encode($countryName)?>;
  let allServicesData = <?php echo json_encode($allServicesData)?>;
  let isGovtFee = "{{$servicesDetail->is_govt_apply}}";
  let default_currency = "{{$default_currency}}";


  $("#currencyChange").change(function(){
      let currencyCode = $(this).val();
      if(currencyCode.length > 0){
        default_currency = currencyCode;
        $(".currencyShow").text(default_currency);
      }
      calculateApplicant();
  });

  $(document).on("change",".nationality",function(){
      calculateApplicant();
  });
  $(document).on("change",".visa_process_type",function(){
      calculateApplicant();
  });
  function calculateApplicant(){
    let visaProcessingType = $('input[name="visa_process_type"]:checked').val();
    let totalAmount = 0.00;
    let totalApplicantAmount = 0.00;
    let totalGovtAmount = 0.00;
    let nationality = $(".nationality").val();

    if(nationality.length >0 && visaProcessingType.length > 0){
         totalApplicantAmount += parseFloat(allServicesData[nationality.toLowerCase()][default_currency][visaProcessingType.toLowerCase()]);
         totalGovtAmount += parseFloat(allServicesData[nationality.toLowerCase()][default_currency]['govt']);
    }
    $("#totalApplicantAmount").text(totalApplicantAmount.toFixed(2));
    if(isGovtFee == 1){
      $("#totalGovtAmount").text(totalGovtAmount.toFixed(2));
      totalAmount = parseFloat(totalApplicantAmount) + parseFloat(totalGovtAmount);
    }else{
      totalAmount = parseFloat(totalApplicantAmount);
    }
    $("#totalAmount").text(totalAmount.toFixed(2));

  }
});

</script>
@endsection

@extends('front.layouts.app')

@section('content')

<h1 class="inner-head  bg-heading" style="text-align:center;">Get Your Travel Document for India</h1>
<section class="apply-section apply-info-section">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <form method="POST" action="{{ route('services.reviewSave',[$slug]) }}" accept-charset="UTF-8" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <div class="apply-box">
          <div class="apply-box-header">
            <h2>General Information</h2>
            <a href="{{route('services.edit',[$servicesPages->visa_url,$slug])}}" class="edit">
              <i class="fas fa-pencil-alt"></i>
            </a>
          </div>
          <div class="apply-box-form">
            <div class="row d-flex">
              <div class="col-sm-3">
                <div class="from-group">
                  <label>Email Address</label>
                  <div class="apply-info-value">{{$servicesDetail->email_id}}</div>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="from-group">
                  <label>Name</label>
                  <div class="date-box d-flex">
                    <div class="apply-info-value">{{$servicesDetail->name}}</div>
                  </div>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="from-group">
                  <label>Nationality</label>
                  <div class="date-box d-flex">
                    <div class="apply-info-value">{{$servicesDetail->nationality}}</div>
                  </div>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="from-group">
                  <label>Contact No ( With Country Code )</label>
                  <div class="apply-info-value">{{$servicesDetail->contact_no}}</div>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="from-group">
                  <label>Country Living In</label>
                  <div class="apply-info-value">{{$servicesDetail->country_live}}</div>
                </div>
              </div>
              <div class="col-sm-3">
                    <div class="from-group">
                        <label>Upload Passport</label>
                        <input type="file" {{$servicesPages->isPassportDocRequired == 1 ? "required":""}} name="upload_passport">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="from-group">
                        <label>Upload Photo</label>
                        <input type="file" {{$servicesPages->isApplicantPhotoRequired == 1 ? "required":""}} name="upload_photo">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="from-group" >
                        <label>Upload Any Other</label>
                        <input type="file" {{$servicesPages->isOtherDocRequired == 1 ? "required":""}} name="upload_other">
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
            @if(isset($servicesDetail->govt_fee) && $servicesDetail->govt_fee > 0)
              <div class="sum-info">
                <div>Government Fees (Pay on Arrival)</div>
                <div><span class="currencyShow">{{$default_currency}}</span> <span id="totalGovtAmount">{{floatval($servicesDetail->govt_fee)}}</span></div>
              </div>
            @endif
            <div class="sum-info">
              <div>Service Fee</div>
              <div><span class="currencyShow">{{$default_currency}}</span> <span id="totalApplicantAmount">{{floatval($servicesDetail->service_fee)}}</span></div>
            </div>
          </div>
        </div>
        <div class="total-sum">
            <h4>Total:
            <span>
                <select id="currencyChange">
                  @foreach($currencyRate as $key => $value)
                    <option value="{{strtoupper($key)}}">{{strtoupper($key)}}</option>
                  @endforeach
                </select>
            <span id="totalAmount">{{floatval($servicesDetail->total_payment)}}</span></span></h4>
            <button class="btn" type="submit">{{isset($servicesPages->payment_method) && $servicesPages->payment_method == 1 ? "Online Pay" : "Contact Us"}}</button>
        </div>
        <input type="hidden" name="payment_method" value="{{isset($servicesPages->payment_method) ? $servicesPages->payment_method : 0}}"/>
      </form>
      </div>
    </div>
  </div>
</div>
</section>
@stop
@section('javascript')

<script type="text/javascript">
$(function(){
  let currencyRate = <?php echo json_encode($currencyRate)?>;
  let default_currency = "{{$default_currency}}";
  let totalApplicantAmount = "{{floatval($servicesDetail->service_fee)}}";
  let totalGovtAmount = "{{floatval($servicesDetail->govt_fee)}}";
  let totalAmount = "{{$servicesDetail->total_payment}}";
  $("#currencyChange").change(function(){
      let currencyCode = $(this).val();
      if(currencyCode.length > 0){
        default_currency = currencyCode;
        $(".currencyShow").text(default_currency);
      }
      $("#totalApplicantAmount").text(parseFloat(totalApplicantAmount*currencyRate[default_currency]).toFixed(2));
      $("#totalGovtAmount").text(parseFloat(totalGovtAmount*currencyRate[default_currency]).toFixed(2));
      $("#totalAmount").text(parseFloat(totalAmount*currencyRate[default_currency]).toFixed(2));
  });
});
</script>
@endsection

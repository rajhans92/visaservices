@extends('front.layouts.app')

@section('content')

<h1 class="inner-head  bg-heading" style="text-align:center;">Get Your Travel Document for India</h1>
<section class="apply-section apply-info-section">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <form method="POST" action="{{ route('apply.reviewSave',[$slug]) }}" accept-charset="UTF-8" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <div class="apply-box">
          <div class="apply-box-header">
            <h2>General Information</h2>
            <a href="{{ route('apply.edit',[$visaPages->visa_url,$slug]) }}" class="edit">
              <i class="fas fa-pencil-alt"></i>
            </a>
          </div>
          <div class="apply-box-form">
            <div class="row d-flex">
              <div class="col-sm-3">
                <div class="from-group">
                  <label>Email Address</label>
                  <div class="apply-info-value">{{$visaDetail->email_id}}</div>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="from-group">
                  <label>Arrival Date In India</label>
                  <div class="date-box d-flex">
                    <div class="apply-info-value">{{date('F d, Y',strtotime($visaDetail->arrival_date))}}</div>
                  </div>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="from-group">
                  <label>Departure Date from India</label>
                  <div class="date-box d-flex">
                    <div class="apply-info-value">{{date('F d, Y',strtotime($visaDetail->departure_date))}}</div>
                  </div>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="from-group">
                  <label>Type of Visa</label>
                  <div class="apply-info-value">{{$visaDetail->type_of_visa}}</div>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="from-group">
                  <label>Port of Arrival</label>
                  <div class="apply-info-value">{{$visaDetail->port_of_arrival}}</div>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="from-group">
                  <label>Contact No ( With Country Code )</label>
                  <div class="apply-info-value">{{$visaDetail->contact_no}}</div>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="from-group">
                  <label>Country Living In</label>
                  <div class="apply-info-value">{{$visaDetail->country_live}}</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php $count=1; $totalGovtAmount=0.0;$totalApplicantAmount=0.0;?>
        @foreach($visaApplicantDetail as $key => $val)
        <?php
          $totalGovtAmount += floatval($val->govt_fee);
          $totalApplicantAmount += floatval($val->applicant_payment);
        ?>
        <div class="apply-box applicant-box">
          <div class="apply-box-header">
            <h2>APPLICANT #{{$count++}}</h2>
            <a href="{{ route('apply.edit',[$visaPages->visa_url,$slug]) }}" class="edit">
              <i class="fas fa-pencil-alt"></i>
            </a>
          </div>
          <div class="apply-box-form">
            <div class="row d-flex">
              <div class="col-sm-3">
                <div class="from-group">
                  <label>First and Middle Name</label>
                  <div class="apply-info-value">{{$val->first_name}}</div>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="from-group">
                  <label>Last Name</label>
                  <div class="apply-info-value">{{$val->last_name}}</div>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="from-group">
                  <label>Gender</label>
                  <div class="apply-info-value">{{$val->gender == 1 ? "Male": $val->gender == 2 ? "Female" : ""}}</div>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="from-group">
                  <label>Nationality (as in Passport)</label>
                  <div class="apply-info-value">{{$val->nationality}}</div>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="from-group">
                  <label>Birthday</label>
                  <div class="date-box d-flex">
                    <div class="apply-info-value">{{date('F d, Y',strtotime($val->date_of_birth))}}</div>
                  </div>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="from-group">
                  <label>Country of Birth</label>
                  <div class="apply-info-value">{{$val->applicant_country_birth}}</div>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="from-group">
                  <label>Country of Residence</label>
                  <div class="apply-info-value">{{$val->applicant_country_residence}}</div>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="from-group">
                  <label>Contact No ( With Country Code )</label>
                  <div class="apply-info-value">{{$val->applicant_phone}}</div>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="from-group">
                  <label>Passport Issue Date</label>
                  <div class="date-box d-flex">
                    <div class="apply-info-value">{{date('F d, Y',strtotime($val->passport_issue_date))}}</div>
                  </div>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="from-group">
                  <label>Passport Expiry Date</label>
                  <div class="date-box d-flex">
                    <div class="apply-info-value">{{date('F d, Y',strtotime($val->passport_expiry_date))}}</div>
                  </div>
                </div>
              </div>
              <div class="col-sm-3">
                    <div class="from-group">
                        <label>Upload Passport</label>
                        <input type="file" {{$visaPages->isPassportDocRequired == 1 ? "required":""}} name="upload_passport{{$val->id}}">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="from-group">
                        <label>Upload Photo</label>
                        <input type="file" {{$visaPages->isApplicantPhotoRequired == 1 ? "required":""}} name="upload_photo{{$val->id}}">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="from-group" >
                        <label>Upload Any Other</label>
                        <input type="file" {{$visaPages->isOtherDocRequired == 1 ? "required":""}} name="upload_other{{$val->id}}">
                    </div>
                </div>
            </div>
          </div>
        </div>
        @endforeach
        <div class="apply-box">
          <div class="apply-box-header">
            <h2>Order Details</h2>
          </div>
          <div class="order-total-sum">
            @if(isset($visaPages->is_govt_apply) && $visaPages->is_govt_apply == 1)
              <div class="sum-info">
                <div>Government Fees (Pay on Arrival)</div>
                <div><span class="currencyShow">{{$default_currency}}</span> <span id="totalGovtAmount">{{$totalGovtAmount}}</span></div>
              </div>
            @endif
            <div class="sum-info">
              <div>Service Fee</div>
              <div><span class="currencyShow">{{$default_currency}}</span> <span id="totalApplicantAmount">{{$totalApplicantAmount}}</span></div>
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
            <span id="totalAmount">{{$visaDetail->total_payment}}</span></span></h4>
            <button class="btn" type="submit">{{isset($visaPages->payment_method) && $visaPages->payment_method == 1 ? "Online Pay" : "Contact Us"}}</button>
        </div>
        <input type="hidden" name="payment_method" value="{{isset($visaPages->payment_method) ? $visaPages->payment_method : 0}}"/>
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
  let totalApplicantAmount = "{{$totalApplicantAmount}}";
  let totalGovtAmount = "{{$totalGovtAmount}}";
  let totalAmount = "{{$visaDetail->total_payment}}";
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

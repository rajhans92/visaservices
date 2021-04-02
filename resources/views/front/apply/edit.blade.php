@extends('front.layouts.app')

@section('content')

<h1 class="inner-head bg-heading" style="text-align:center;">Get Your Travel Document for India</h1>
<section class="apply-section">
  <div class="container">
    <div class="row d-flex justify-center">
      <div class="col-sm-12">
        <?php
          $month = [
            1 => "January",
            2 => "February",
            3 => "March",
            4 => "April",
            5 => "May",
            6 => "June",
            7 => "July",
            8 => "August",
            9 => "September",
            10 => "October",
            11 => "November",
            12 => "December",
          ]
        ?>
          <form method="POST" action="{{ route('apply.onlineUpdate',[$url,$slug]) }}" accept-charset="UTF-8" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <div class="apply-box">
              <div class="apply-box-header">
                  <h2>General Information</h2>
                  <button type="button" data-toggle="modal" data-target="#feeModal" onClick="feeCalculate()"><i class="fas fa-calculator"></i>Calculate Fee</button>
                  <div class="modal" id="feeModal" tabindex="-1" role="dialog" aria-labelledby="feeModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="feeModalLabel"><i class="fas fa-calculator"></i>Calculate Fee Before Applying</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick="closeModal()">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <div class="calculator-main-content">
                                <h2>Calculator Tool:</h2>
                                <h4>Calculate Fee Before Applying</h4>
                                <div class="calculator-inner apply-box-form">
                                     <div class="from-group">
                                                  <label>Where am I From?</label>
                                                <select name="livincountry" id="livincountry_calculator" required="">
                                            @foreach($allVisaDataAlter as $key => $val)
                                              <option value="{{$key}}" {{$key == $default_nationality ? 'selected' : ''}}>{{$key}}</option>
                                            @endforeach
                                         </select>
                                              </div>
                                     <div class="row">
                                                  <div class="col-sm-2">
                                                      <div class="from-group">
                                                          <label>Travellers</label>
                                                          <div class="qty">
                                            <span class="minus">-</span>
                                            <input type="number" class="count" id="counter_calculator" name="qty" value="1">
                                            <span class="plus">+</span>
                                                       </div>
                                                      </div>
                                                  </div>
                                                  <div class="col-sm-4">
                                              <div class="from-group">
                                                  <label>Applying For</label>
                                                  <select name="reason" id="reasonid_calculator">
                                                    <option value="" >select</option>
                                                    @foreach($allVisaDataAlter[strtolower($default_nationality)] as $key => $val)
                                                    <option value="{{$key}}" >{{$key}}</option>
                                                  @endforeach

                                         </select>
                                              </div>
                                          </div>
                                          <div class="col-sm-6 from-group">
                                        <label>Processing Time</label>
                                        <div class="processing-box">
                                          <div class="processing-time">
                                              <input type="radio" name="visa_process_calculator" class="visa_process_calculator" id="standard" value="standard" checked>
                    						              <span class="checkmark"></span>
                                              <b>Standard <br><span>5 Days</span></b>
                                          </div>
                                          <div class="processing-time">
                                              <input type="radio" id="rush" name="visa_process_calculator" class="visa_process_calculator" value="rush" >
                    						                    <span class="checkmark"></span>
                                                  <b>Rush <br><span>48 Hours</span></b>
                                          </div>
                                          <div class="processing-time">
                                              <input type="radio" name="visa_process_calculator" class="visa_process_calculator" id="standard" value="express">
                    						                    <span class="checkmark"></span>
                                                  <b>Express <br><span>24 Hours</span></b>
                                          </div>
                                          </div>
                                      </div>
                                              </div>
                                     <div class="order-total-sum">
                    								    <div class="sum-info">
                    										<div>Government Fees (Pay on Arrival)</div>
                    										<div><span class="currencyRateCal">{{$default_currency}}</span> <span id="totalGovtCal">00.00<span></div>
                    									</div>
                    									<div class="sum-info">
                    										<div>Service Fee </div>
                    										<div><span class="currencyRateCal">{{$default_currency}}</span> <span id="totalSubCal">00.00</span></div>
                    									</div>
                    								</div>
                                </div>
                                <div class="total-sum">
                                    <h4>Total:
                                    <span>
                                        <select id="currencyRate_calculator">
                                          <option value="USD">USD</option>
                                          @foreach($currencyRate as $key => $value)
                                            <option value="{{strtoupper($value->code)}}">{{strtoupper($value->code)}}</option>
                                          @endforeach
                                        </select>
                                    <span id="totalAmountCal">00.00</span></span></h4>
                                </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

              </div>
              <div class="apply-box-form">
                  <div class="row d-flex">
                      <div class="col-sm-3">
                          <div class="from-group">
                              <label>Email Address</label>
                              <input type="email" name="email" class="form-control" required="" value="{{$visaDetail->email_id}}">
                          </div>
                      </div>
                      <div class="col-sm-3">
                          <div class="from-group">
                              <label>Arrival Date</label>
                              <div class="date-box d-flex">
                                  <select class="month" name="arrival_month" id="general_arrival_month" required = "">
                                      <option value="">Month</option>
                                      @foreach($month as $key => $val)
                                        <option value="{{$key}}" {{date('m',strtotime($visaDetail->arrival_date)) == $key ? "selected": ""}}>{{$val}}</option>
                                      @endforeach
                                  </select>
                                  <select class="date" name="arrival_date" id="general_arrival_date" required = "">
                                      <option value="">Day</option>
                                      <?php for($j=1;$j<=31;$j++){ ?>
                                        <option value="{{$j}}" {{date('d',strtotime($visaDetail->arrival_date)) == $j ? "selected": ""}}>{{$j}}</option>
                                      <?php } ?>
                                  </select>
                                  <select class="year" name="arrival_year" id="general_arrival_year" required = "">
                                      <option value="">Year</option>
                                      <option value="{{date('Y', strtotime(date('Y-m-d')))}}" {{date('Y', strtotime(date('Y-m-d'))) == date('Y',strtotime($visaDetail->arrival_date)) ? "selected" : ""}}>{{date("Y", strtotime(date('Y-m-d')))}}</option>
                                      <option value="{{date('Y', strtotime('+1 years', strtotime(date('Y-m-d'))))}}" {{date('Y', strtotime('+1 years', strtotime(date('Y-m-d')))) == date('Y',strtotime($visaDetail->arrival_date)) ? "selected" : ""}}>{{date("Y", strtotime("+1 years", strtotime(date('Y-m-d'))))}}</option>
                                      <option value="{{date('Y', strtotime('+2 years', strtotime(date('Y-m-d'))))}}" {{date('Y', strtotime('+2 years', strtotime(date('Y-m-d')))) == date('Y',strtotime($visaDetail->arrival_date)) ? "selected" : ""}}>{{date("Y", strtotime("+2 years", strtotime(date('Y-m-d'))))}}</option>
                                      <option value="{{date('Y', strtotime('+3 years', strtotime(date('Y-m-d'))))}}" {{date('Y', strtotime('+3 years', strtotime(date('Y-m-d')))) == date('Y',strtotime($visaDetail->arrival_date)) ? "selected" : ""}}>{{date("Y", strtotime("+3 years", strtotime(date('Y-m-d'))))}}</option>
                                  </select>
                              </div>

                          </div>
                      </div>
                      <div class="col-sm-3">
                          <div class="from-group">
                              <label>Departure Date</label>
                              <div class="date-box d-flex">
                                  <select class="month" name="departure_month" id="general_departure_month" required = "">
                                    <option value="">Month</option>
                                    @foreach($month as $key => $val)
                                      <option value="{{$key}}" {{date('m',strtotime($visaDetail->departure_date)) == $key ? "selected": ""}}>{{$val}}</option>
                                    @endforeach
                                  </select>
                                  <select class="date" name="departure_date" id="general_departure_date" required = "">
                                    <option value="">Day</option>
                                    <?php for($j=1;$j<=31;$j++){ ?>
                                      <option value="{{$j}}" {{date('d',strtotime($visaDetail->departure_date)) == $j ? "selected": ""}}>{{$j}}</option>
                                    <?php } ?>
                                  </select>
                                  <select class="year" name="departure_year" id="general_departure_year" required = "">
                                    <option value="">Year</option>
                                    <option value="{{date('Y', strtotime(date('Y-m-d')))}}" {{date('Y', strtotime(date('Y-m-d'))) == date('Y',strtotime($visaDetail->departure_date)) ? "selected" : ""}}>{{date("Y", strtotime(date('Y-m-d')))}}</option>
                                    <option value="{{date('Y', strtotime('+1 years', strtotime(date('Y-m-d'))))}}" {{date('Y', strtotime('+1 years', strtotime(date('Y-m-d')))) == date('Y',strtotime($visaDetail->departure_date)) ? "selected" : ""}}>{{date("Y", strtotime("+1 years", strtotime(date('Y-m-d'))))}}</option>
                                    <option value="{{date('Y', strtotime('+2 years', strtotime(date('Y-m-d'))))}}" {{date('Y', strtotime('+2 years', strtotime(date('Y-m-d')))) == date('Y',strtotime($visaDetail->departure_date)) ? "selected" : ""}}>{{date("Y", strtotime("+2 years", strtotime(date('Y-m-d'))))}}</option>
                                    <option value="{{date('Y', strtotime('+3 years', strtotime(date('Y-m-d'))))}}" {{date('Y', strtotime('+3 years', strtotime(date('Y-m-d')))) == date('Y',strtotime($visaDetail->departure_date)) ? "selected" : ""}}>{{date("Y", strtotime("+3 years", strtotime(date('Y-m-d'))))}}</option>
                                  </select>
                              </div>

                          </div>
                      </div>
                      <div class="col-sm-3">
                          <div class="from-group">
                              <label>Type of Visa</label>
                              <select name="visaType" id="visaType" required = "">
                                  <option value="">Select</option>
                                  @foreach($allVisaData as $key => $data)
                                    <option value="{{$key}}" {{$key == $default_visa_type ? "selected" : ""}}>{{$key}}</option>
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
                                  <option value="{{$data->country_name}}" {{strtolower($data->country_name) == strtolower($visaDetail->country_live) ? "selected":""}}>{{$data->country_name}}</option>
                                @endforeach
                            </select>
                          </div>
                      </div>
                       <div class="col-sm-3">
                          <div class="from-group">
                              <label>Port of Arrival</label>
                              <select name="port_arrival" id="port_arrival" required="">
                                <option value="">Select </option>
                                @foreach($portOfArrival as $key => $data)
                                  <option value="{{$data->port_name}}" {{strtolower($data->port_name) == strtolower($visaDetail->port_of_arrival) ? "selected":""}}>{{$data->port_name}}</option>
                                @endforeach
                              </select>
                          </div>
                      </div>
                       <div class="col-sm-3">
                          <div class="from-group">
                              <label>Contact No ( With Country Code )</label>
                             <input type="text" name="phone" class="form-control" required = "" max="13" value="{{$visaDetail->contact_no}}">
                          </div>
                      </div>

                  </div>
              </div>
          </div>
          <?php
           $count=0;
           $tempCount = 1;
           $dob=[];
           $passportDate=[];
           for($i=0;$i<50;$i++) {
            $dob[date('Y', strtotime('-'.$i.' years', strtotime(date('Y-m-d'))))] = date('Y', strtotime('-'.$i.' years', strtotime(date('Y-m-d'))));
           }
           for($i=0;$i<10;$i++) {
            $passportDate[date('Y', strtotime('+'.$i.' years', strtotime(date('Y-m-d'))))] = date('Y', strtotime('+'.$i.' years', strtotime(date('Y-m-d'))));
           }
           $govtFees = 00.00;
           $totalApplicant = 00.00;
           ?>
        <div class="apply-box-main apply-box applicant-box" >
          <span id="applicantArea">
          @foreach($visaApplicantDetail as $key => $val)
          <?php
            $govtFees += $val->govt_fee;
            $totalApplicant += $val->applicant_payment;
            $count++;
          ?>
          <div class="apply-box applicant-box" id="applicantSection{{$count}}">
              <div class="apply-box-header">
                  <h2 class="applicantTitle">APPLICANT #{{$tempCount++}}</h2>
                  <a href="#" class="remove-applicant removeApplicant" data="{{$count}}"><i class="fas fa-minus-circle"></i>Remove Applicant</a>
              </div>
              <div class="apply-box-form">
                  <div class="row d-flex">
                      <div class="col-sm-3">
                          <div class="from-group">
                              <label>First Name</label>
                              <input type="text" required="" name="applicant_first_name_update{{$val->id}}" value="{{$val->first_name}}" class="form-control">
                          </div>
                      </div>
                      <div class="col-sm-3">
                          <div class="from-group">
                              <label>Last Name</label>
                              <input type="text" required="" name="applicant_last_name_update{{$val->id}}" value="{{$val->last_name}}" class="form-control">
                          </div>
                      </div>
                      <div class="col-sm-3">
                          <div class="from-group">
                              <label>Gender</label>
                              <select name="applicant_gender_update{{$val->id}}" class="applicant_gender" id="gender" required = "">
                                  <option value="1" {{$val->gender == 1 ? "selected" : ""}}>Male</option>
                                  <option value="2" {{$val->gender == 2 ? "selected" : ""}}>Female</option>
                               </select>
                          </div>
                      </div>

                      <div class="col-sm-3">
                          <div class="from-group">
                              <label>Nationality (as in Passport)</label>
                                <select name="applicant_nationality_update{{$val->id}}" class="applicant_nationality" required = "">
                                  <option value="">Select</option>
                                  @foreach($allVisaData[$default_visa_type]['country'] as $key => $data)
                                    <option value="{{$key}}" {{strtolower($val->nationality) == strtolower($key) ? "selected" : ""}}>{{$key}}</option>
                                  @endforeach
                                </select>
                          </div>
                      </div>
                      <div class="col-sm-3">
                          <div class="from-group">
                              <label>Date of Birth</label>
                              <div class="date-box d-flex">
                                  <select class="month applicant_dob_month" name="applicant_dob_month_update{{$val->id}}" required = "">
                                      <option value="">Month</option>
                                      @foreach($month as $key => $value)
                                        <option value="{{$key}}" {{date('m',strtotime($val->date_of_birth)) == $key ? "selected": ""}}>{{$value}}</option>
                                      @endforeach
                                  </select>
                                  <select class="date applicant_dob_date" name="applicant_dob_date_update{{$val->id}}" required = "">
                                      <option>Date</option>
                                      <?php for($j=1;$j<=31;$j++){ ?>
                                        <option value="{{$j}}" {{date('d',strtotime($val->date_of_birth)) == $j ? "selected": ""}}>{{$j}}</option>
                                      <?php } ?>
                                  </select>
                                  <select class="year applicant_dob_year" name="applicant_dob_year_update{{$val->id}}" required = "">
                                      <option>Year</option>
                                      @foreach($dob as $key => $value)
                                        <option value="{{$value}}" {{date('Y',strtotime($val->date_of_birth)) == $value ? "selected": ""}}>{{$value}}</option>
                                      @endforeach
                                  </select>
                              </div>

                          </div>
                      </div>
                      <div class="col-sm-3">
                          <div class="from-group">
                              <label>Country of Birth</label>
                            <select name="applicant_country_birth_update{{$val->id}}"  required="" >
                                <option value="">Select</option>
                                @foreach($countryName as $key => $data)
                                  <option value="{{$data->country_name}}" {{$data->country_name==$val->applicant_country_birth ?"selected":"" }}>{{$data->country_name}}</option>
                                @endforeach
                            </select>
                          </div>
                      </div>
                      <div class="col-sm-3">
                          <div class="from-group">
                              <label>Country of Residence</label>
                            <select name="applicant_country_residence_update{{$val->id}}"  required="" >
                                <option value="">Select</option>
                                @foreach($countryName as $key => $data)
                                  <option value="{{$data->country_name}}" {{$data->country_name==$val->applicant_country_residence ?"selected":"" }}>{{$data->country_name}}</option>
                                @endforeach
                            </select>
                          </div>
                      </div>
                      <div class="col-sm-3">
                         <div class="from-group">
                             <label>Contact No(With Country Code)</label>
                            <input type="text" name="applicant_phone_update{{$val->id}}" class="form-control applicant_phone" required = "" max="13" value="{{$val->applicant_phone}}">
                         </div>
                      </div>
                      <div class="col-sm-3">
                          <div class="from-group">
                              <label>Passport issue Date</label>
                              <div class="date-box d-flex">
                                <select class="month applicant_passport_issue_month" name="applicant_passport_issue_month_update{{$val->id}}" data="{{$count}}" required = "">
                                    <option value="">Month</option>
                                    @foreach($month as $key => $value)
                                      <option value="{{$key}}" {{date('m',strtotime($val->passport_issue_date)) == $key ? "selected": ""}}>{{$value}}</option>
                                    @endforeach
                                </select>
                                <select class="date applicant_passport_issue_date" name="applicant_passport_issue_date_update{{$val->id}}" data="{{$count}}" required = "">
                                    <option>Date</option>
                                    <?php for($j=1;$j<=31;$j++){ ?>
                                      <option value="{{$j}}" {{date('d',strtotime($val->passport_issue_date)) == $j ? "selected": ""}}>{{$j}}</option>
                                    <?php } ?>
                                </select>
                                <select class="year applicant_passport_issue_year" name="applicant_passport_issue_year_update{{$val->id}}" data="{{$count}}" required = "">
                                    <option>Year</option>
                                    @foreach($dob as $key => $value)
                                      <option value="{{$value}}" {{date('Y',strtotime($val->passport_issue_date)) == $value ? "selected": ""}}>{{$value}}</option>
                                    @endforeach
                                </select>
                              </div>

                          </div>
                      </div>

                      <div class="col-sm-3">
                          <div class="from-group">
                              <label>Passport Expiry Date</label>
                              <div class="date-box d-flex">
                                <select class="month applicant_passport_month" name="applicant_passport_month_update{{$val->id}}" required = "">
                                    <option value="">Month</option>
                                    @foreach($month as $key => $value)
                                      <option value="{{$key}}" {{date('m',strtotime($val->passport_expiry_date)) == $key ? "selected": ""}}>{{$value}}</option>
                                    @endforeach
                                </select>
                                <select class="date applicant_passport_date" name="applicant_passport_date_update{{$val->id}}" required = "">
                                    <option>Date</option>
                                    <?php for($j=1;$j<=31;$j++){ ?>
                                      <option value="{{$j}}" {{date('d',strtotime($val->passport_expiry_date)) == $j ? "selected": ""}}>{{$j}}</option>
                                    <?php } ?>
                                </select>
                                <select class="year applicant_passport_year" name="applicant_passport_year_update{{$val->id}}" required = "">
                                    <option>Year</option>
                                    @foreach($passportDate as $key => $value)
                                      <option value="{{$value}}" {{date('Y',strtotime($val->passport_expiry_date)) == $value ? "selected": ""}}>{{$value}}</option>
                                    @endforeach
                                </select>
                              </div>

                          </div>
                      </div>
                  </div>
              </div>
          </div>
          @endforeach
          </span>

           <div class="add-applicant-box">
              <p>Click below to add more applicants within your order:</p>
              <button class="btn" id="addApplicant" type="button"><i class="fa fa-user-plus"></i>Add new applicant</button>
            </div>
            </div>
            <div class="process-time-box">
                <div class="apply-box-header">
                  <h2>PROCESSING TIME AND FEE</h2>
              </div>
              <div class="row d-flex">
                  <div class="col-sm-12">
                    <div class="processing-box">
                      <div class="processing-time">
                          <input type="radio" name="visa_process_type"  class="visa_process_type" {{strtolower($visaDetail->visa_process_type) == "standard" ? 'checked="checked"' :"" }} id="standard" value="standard">
              <span class="checkmark"></span>
                          <b>Standard <br><span>5 Days</span></b>
                      </div>
                      <div class="processing-time">
                          <input type="radio" id="rush" class="visa_process_type" name="visa_process_type" {{strtolower($visaDetail->visa_process_type) == "rush" ? 'checked="checked"' :"" }} value="rush">
              <span class="checkmark"></span>
                              <b>Rush <br><span>48 Hours</span></b>
                      </div>
                      <div class="processing-time">
                          <input type="radio" name="visa_process_type" class="visa_process_type" {{strtolower($visaDetail->visa_process_type) == "express" ? 'checked="checked"' :"" }} value="express">
              <span class="checkmark"></span>
                              <b>Express <br><span>24 Hours</span></b>
                      </div>
                      </div>
                  </div>
              </div>
            </div>

            <input type="hidden" name="totalCount" value="{{$count}}" id="totalCount"/>
            <input type="hidden" name="order_id" value="{{$visaDetail->order_id}}" />
            <div class="apply-box">
              <div class="apply-box-header">
                <h2>Order Details</h2>
              </div>
              <div class="order-total-sum">
                  <div class="sum-info">
                  <div>Government Fees (Pay on Arrival)</div>
                  <div><span class="currencyShow">{{$default_currency}}</span> <span id="totalGovtAmount">{{number_format($govtFees,2)}}</span></div>
                </div>
                <div class="sum-info">
                  <div>Service Fee</div>
                  <div><span class="currencyShow">{{$default_currency}}</span> <span id="totalApplicantAmount">{{number_format($totalApplicant,2)}}</span></div>
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
                <span id="totalAmount">{{number_format($visaDetail->total_payment,2)}}</span></span></h4>
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
  let count = {{++$count}};
  let dob = <?php echo json_encode($dob)?>;
  let passportDate = <?php echo json_encode($passportDate)?>;
  let allVisaData = <?php echo json_encode($allVisaData)?>;
  let countryNameList = <?php echo json_encode($countryName)?>;
  let allVisaDataAlter = <?php echo json_encode($allVisaDataAlter)?>;
  let default_currency = "{{$default_currency}}";
  let default_currency_cal = "{{$default_currency}}";
  $("#addApplicant").click(function(){
      let nationalityVal = $("#visaType").val();
      let nationality = "";
      let dobset = "";
      let dates = "";
      let passportList = "";
      let countryList = "";
      let passportIssueYear = "";
      for(let i =1 ; i<=31;i++){
        dates+= '<option value="'+i+'">'+i+'</option>';
      }
      for(let key in dob){
        dobset+= '<option value="'+key+'">'+key+'</option>';
      }
      for(let key in passportDate){
        passportList+= '<option value="'+key+'">'+key+'</option>';
      }
      if(nationalityVal.length > 0){
          for (var variable in allVisaData[nationalityVal]['country']) {
            nationality += '<option value="'+variable.toLowerCase()+'">'+variable+'</option>'
          }
      }
      for(let key in countryNameList){
        countryList+= '<option value="'+countryNameList[key]["country_name"]+'">'+countryNameList[key]["country_name"]+'</option>';
      }
      let temStr = '<div class="apply-box applicant-box" id="applicantSection'+count+'"> <div class="apply-box-header"> <h2 class="applicantTitle">APPLICANT #'+count+'</h2> <a href="#" class="remove-applicant removeApplicant" data="'+count+'"><i class="fas fa-minus-circle"></i>Remove Applicant</a> </div> <div class="apply-box-form"> <div class="row d-flex"> <div class="col-sm-3"> <div class="from-group"> <label>First Name</label> <input type="text" required="" name="applicant_first_name'+count+'" class="form-control"> </div> </div> <div class="col-sm-3"> <div class="from-group"> <label>Last Name</label> <input type="text" required="" name="applicant_last_name'+count+'" class="form-control"> </div> </div> <div class="col-sm-3"> <div class="from-group"> <label>Gender</label> <select name="applicant_gender'+count+'" data="'+count+'" class="applicant_gender" id="gender" required = ""> <option value="1">Male</option> <option value="2">Female</option> </select> </div> </div> <div class="col-sm-3"> <div class="from-group"> <label>Nationality (as in Passport)</label> <select name="applicant_nationality'+count+'" class="applicant_nationality" data="'+count+'" required = ""><option value="">Select</option>'+nationality+'</select> </div> </div> <div class="col-sm-3"> <div class="from-group"> <label>Date of Birth</label> <div class="date-box d-flex"> <select class="month applicant_dob_month" name="applicant_dob_month'+count+'" data="'+count+'" required = ""> <option value="">Month</option> <option value="1">January</option> <option value="2">February</option> <option value="3">March</option> <option value="4">April</option> <option value="5">May</option> <option value="6">June</option> <option value="7">July</option> <option value="8">August</option> <option value="9">September</option> <option value="10">October</option> <option value="11">November</option> <option value="12">December</option> </select> <select class="date applicant_dob_date" name="applicant_dob_date'+count+'" data="'+count+'" required = ""> <option>Date</option>'+dates+'</select> <select class="year applicant_dob_year" name="applicant_dob_year'+count+'" data="'+count+'" required = ""><option>Year</option>'+dobset+'</select> </div> </div> </div> <div class="col-sm-3"> <div class="from-group"> <label>Country of Birth</label> <select name="applicant_country_birth'+count+'"  required="" > <option value="">Select</option>'+countryList+'</select> </div> </div> <div class="col-sm-3"> <div class="from-group"> <label>Country of Residence</label> <select name="applicant_country_residence'+count+'"  required="" ><option value="">Select</option>'+countryList+'</select> </div> </div> <div class="col-sm-3"> <div class="from-group"> <label>Contact No(With Country Code)</label> <input type="text" name="applicant_phone'+count+'" class="form-control applicant_phone" required = "" max="13"> </div> </div> <div class="col-sm-3"> <div class="from-group"> <label>Passport issue Date</label> <div class="date-box d-flex"> <select class="month applicant_passport_issue_month" name="applicant_passport_issue_month'+count+'" data="'+count+'" required = ""> <option value="">Month</option> <option value="1">January</option> <option value="2">February</option> <option value="3">March</option> <option value="4">April</option> <option value="5">May</option> <option value="6">June</option> <option value="7">July</option> <option value="8">August</option> <option value="9">September</option> <option value="10">October</option> <option value="11">November</option> <option value="12">December</option> </select> <select class="date applicant_passport_issue_date" name="applicant_passport_issue_date'+count+'" data="'+count+'" required = ""> <option>Date</option>'+dates+'</select> <select class="year applicant_passport_issue_year" name="applicant_passport_issue_year'+count+'" data="'+count+'" required = ""> <option>Year</option>'+dobset+' </select> </div> </div> </div> <div class="col-sm-3"> <div class="from-group"> <label>Passport Expiry Date</label> <div class="date-box d-flex"> <select class="month applicant_passport_month" name="applicant_passport_month'+count+'" data="'+count+'" required = ""> <option value="">Month</option> <option value="1">January</option> <option value="2">February</option> <option value="3">March</option> <option value="4">April</option> <option value="5">May</option> <option value="6">June</option> <option value="7">July</option> <option value="8">August</option> <option value="9">September</option> <option value="10">October</option> <option value="11">November</option> <option value="12">December</option> </select> <select class="date applicant_passport_date" name="applicant_passport_date'+count+'" data="'+count+'" required = ""> <option>Date</option>'+dates+'</select> <select class="year applicant_passport_year" name="applicant_passport_year'+count+'" data="'+count+'" required = ""> <option>Year</option>'+passportList+'</select> </div> </div> </div> </div> </div> </div>';

      $("#applicantArea").append(temStr);
      $("#totalCount").val(count);
      count++;
      let tempCount =1;
      $('.applicantTitle').each(function(i, obj) {
          $(this).text('APPLICANT #'+tempCount++);
      });

  });
  $(document).on("click",".removeApplicant",function(){
      let id = $(this).attr('data');
      if(id.length > 0 && $(".applicantTitle").length > 1){
          $("#applicantSection"+id).remove();
          let tempCount = 1;
          $('.applicantTitle').each(function(i, obj) {
              $(this).text('APPLICANT #'+tempCount++);
          });
          calculateApplicant();
      }

  });

  $("#visaType").change(function(){
      let visaTypeId = $(this).val();
      let nationality = "<option value=''>Select</option>";
      if(visaTypeId.length > 0){
        for (var variable in allVisaData[visaTypeId]['country']) {
          nationality += '<option value="'+variable.toLowerCase()+'">'+variable+'</option>'
        }
      }
      $(".applicant_nationality").html(nationality);
      $("#totalAmount").text("00.00");
      $("#totalGovtAmount").text("00.00");
      $("#totalApplicantAmount").text("00.00");
  });

  $("#currencyChange").change(function(){
      let currencyCode = $(this).val();
      if(currencyCode.length > 0){
        default_currency = currencyCode;
        $(".currencyShow").text(default_currency);
      }
      calculateApplicant();
  });

  $(document).on("change",".applicant_nationality",function(){
      calculateApplicant();
  });
  $(document).on("change",".visa_process_type",function(){
      calculateApplicant();
  });
  function calculateApplicant(){
    let visaTypeId = $("#visaType").val();
    let visaProcessingType = $('input[name="visa_process_type"]:checked').val();
    let totalAmount = 0.00;
    let totalApplicantAmount = 0.00;
    let totalGovtAmount = 0.00;

    if(visaTypeId.length > 0 && visaProcessingType.length > 0){

        $('.applicant_nationality').each(function(i, obj) {
             let nationality = $(this).val();
             if(nationality.length > 0){
               totalApplicantAmount += parseFloat(allVisaData[visaTypeId]['country'][nationality.toLowerCase()][default_currency][visaProcessingType.toLowerCase()]);
               totalGovtAmount += parseFloat(allVisaData[visaTypeId]['country'][nationality.toLowerCase()][default_currency]['govt']);
             }
        });
    }
    $("#totalApplicantAmount").text(totalApplicantAmount.toFixed(2));
    $("#totalGovtAmount").text(totalGovtAmount.toFixed(2));
    totalAmount = parseFloat(totalApplicantAmount) + parseFloat(totalGovtAmount);
    $("#totalAmount").text(totalAmount.toFixed(2));

  }
  //---------------------------------------------------------------------------------------------
  //              calculator code
  //---------------------------------------------------------------------------------------------

    $('.count').prop('disabled', true);
    $(document).on('click','.plus',function(){
      $('.count').val(parseInt($('.count').val()) + 1 );
      calculateApplicantCal()
    });
    $(document).on('click','.minus',function(){
      $('.count').val(parseInt($('.count').val()) - 1 );
      if ($('.count').val() == 0) {
        $('.count').val(1);
      }
      calculateApplicantCal()
    });

    $(document).on("change","#livincountry_calculator",function(){
       let nationality = $(this).val();
       if(nationality.length > 0){
         let strTemp = "<option value=''>Select</option>";
          for (var key in allVisaDataAlter[nationality.toLowerCase()]) {
            strTemp += '<option value="'+key+'">'+key+'</option>';
          }
          $("#reasonid_calculator").html(strTemp);

          $("#totalGovtCal").text('00.00');
          $("#totalSubCal").text('00.00');
          $("#totalAmountCal").text('00.00');
       }
    });
    $(document).on("change","#reasonid_calculator",function(){
      calculateApplicantCal();
    });
    $(document).on("change",".visa_process_calculator",function(){
        calculateApplicantCal();
    });
    $("#currencyRate_calculator").change(function(){
        let currencyCode = $(this).val();
        if(currencyCode.length > 0){
          default_currency_cal = currencyCode;
          $(".currencyRateCal").text(default_currency_cal);
        }
        calculateApplicantCal();
    });
    function calculateApplicantCal(){
      let visaTypeId = $("#reasonid_calculator").val();
      let nationality = $("#livincountry_calculator").val();
      let countCal = $('.count').val();
      let visaProcessingType = $('input[name="visa_process_calculator"]:checked').val();
      let totalAmount = 0.00;
      let totalApplicantAmount = 0.00;
      let totalGovtAmount = 0.00;

      // console.log(visaTypeId,nationality,countCal,visaProcessingType);
      if(visaTypeId.length > 0 && nationality.length >0){
        totalApplicantAmount = parseFloat(allVisaDataAlter[nationality.toLowerCase()][visaTypeId][default_currency_cal][visaProcessingType.toLowerCase()]) * countCal;

        totalGovtAmount = parseFloat(allVisaDataAlter[nationality.toLowerCase()][visaTypeId][default_currency_cal]['govt']) * countCal;
      }

      $("#totalSubCal").text(totalApplicantAmount.toFixed(2));
      $("#totalGovtCal").text(totalGovtAmount.toFixed(2));
      totalAmount = parseFloat(totalApplicantAmount) + parseFloat(totalGovtAmount);
      $("#totalAmountCal").text(totalAmount.toFixed(2));

    }
});

</script>
@endsection

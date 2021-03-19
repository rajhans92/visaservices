@extends('front.layouts.app')

@section('content')

<section class="apply-section">
  <div class="container">
    <h1 class="inner-head">Get Your Travel Document for India</h1>
    <div class="row d-flex justify-center">
      <div class="col-sm-9">
          <form method="POST" action="{{ route('apply.save') }}" accept-charset="UTF-8" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <div class="apply-box">
              <div class="apply-box-header">
                  <h2>General Information</h2>
                  <a href="#"><i class="fas fa-calculator"></i>Calculate Fee</a>
              </div>
              <div class="apply-box-form">
                  <div class="row d-flex">
                      <div class="col-sm-4">
                          <div class="from-group">
                              <label>Email Address</label>
                              <input type="email" name="email" class="form-control" required="">
                          </div>
                      </div>
                      <div class="col-sm-4">
                          <div class="from-group">
                              <label>Arrival Date</label>
                              <div class="date-box d-flex">
                                  <select class="month" name="arrival_month" id="general_arrival_month" required = "">
                                      <option value="">Month</option>
                                      <option value="1">January</option>
                                      <option value="2">February</option>
                                      <option value="3">March</option>
                                      <option value="4">April</option>
                                      <option value="5">May</option>
                                      <option value="6">June</option>
                                      <option value="7">July</option>
                                      <option value="8">August</option>
                                      <option value="9">September</option>
                                      <option value="10">October</option>
                                      <option value="11">November</option>
                                      <option value="12">December</option>
                                  </select>
                                  <select class="date" name="arrival_date" id="general_arrival_date" required = "">
                                      <option value="">Day</option>
                                      <option value="1">1</option>
                                      <option value="2">2</option>
                                      <option value="3">3</option>
                                      <option value="4">4</option>
                                      <option value="5">5</option>
                                      <option value="6">6</option>
                                      <option value="7">7</option>
                                      <option value="8">8</option>
                                      <option value="9">9</option>
                                      <option value="10">10</option>
                                      <option value="11">11</option>
                                      <option value="12">12</option>
                                      <option value="13">13</option>
                                      <option value="14">14</option>
                                      <option value="15">15</option>
                                      <option value="16">16</option>
                                      <option value="17">17</option>
                                      <option value="18">18</option>
                                      <option value="19">19</option>
                                      <option value="20">20</option>
                                      <option value="21">21</option>
                                      <option value="22">22</option>
                                      <option value="23">23</option>
                                      <option value="24">24</option>
                                      <option value="25">25</option>
                                      <option value="26">26</option>
                                      <option value="27">27</option>
                                      <option value="28">28</option>
                                      <option value="29">29</option>
                                      <option value="30">30</option>
                                      <option value="31">31</option>
                                  </select>
                                  <select class="year" name="arrival_year" id="general_arrival_year" required = "">
                                      <option value="">Year</option>
                                      <option value="{{date('Y', strtotime(date('Y-m-d')))}}">{{date("Y", strtotime(date('Y-m-d')))}}</option>
                                      <option value="{{date('Y', strtotime('+1 years', strtotime(date('Y-m-d'))))}}">{{date("Y", strtotime("+1 years", strtotime(date('Y-m-d'))))}}</option>
                                      <option value="{{date('Y', strtotime('+2 years', strtotime(date('Y-m-d'))))}}">{{date("Y", strtotime("+2 years", strtotime(date('Y-m-d'))))}}</option>
                                      <option value="{{date('Y', strtotime('+3 years', strtotime(date('Y-m-d'))))}}">{{date("Y", strtotime("+3 years", strtotime(date('Y-m-d'))))}}</option>
                                  </select>
                              </div>

                          </div>
                      </div>
                      <div class="col-sm-4">
                          <div class="from-group">
                              <label>Departure Date</label>
                              <div class="date-box d-flex">
                                  <select class="month" name="departure_month" id="general_departure_month" required = "">
                                    <option value="">Month</option>
                                    <option value="1">January</option>
                                    <option value="2">February</option>
                                    <option value="3">March</option>
                                    <option value="4">April</option>
                                    <option value="5">May</option>
                                    <option value="6">June</option>
                                    <option value="7">July</option>
                                    <option value="8">August</option>
                                    <option value="9">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                  </select>
                                  <select class="date" name="departure_date" id="general_departure_date" required = "">
                                    <option value="">Day</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                    <option value="23">23</option>
                                    <option value="24">24</option>
                                    <option value="25">25</option>
                                    <option value="26">26</option>
                                    <option value="27">27</option>
                                    <option value="28">28</option>
                                    <option value="29">29</option>
                                    <option value="30">30</option>
                                    <option value="31">31</option>
                                  </select>
                                  <select class="year" name="departure_year" id="general_departure_year" required = "">
                                    <option value="">Year</option>
                                    <option value="{{date('Y', strtotime(date('Y-m-d')))}}">{{date("Y", strtotime(date('Y-m-d')))}}</option>
                                    <option value="{{date('Y', strtotime('+1 years', strtotime(date('Y-m-d'))))}}">{{date("Y", strtotime("+1 years", strtotime(date('Y-m-d'))))}}</option>
                                    <option value="{{date('Y', strtotime('+2 years', strtotime(date('Y-m-d'))))}}">{{date("Y", strtotime("+2 years", strtotime(date('Y-m-d'))))}}</option>
                                    <option value="{{date('Y', strtotime('+3 years', strtotime(date('Y-m-d'))))}}">{{date("Y", strtotime("+3 years", strtotime(date('Y-m-d'))))}}</option>
                                  </select>
                              </div>

                          </div>
                      </div>
                      <div class="col-sm-4">
                          <div class="from-group">
                              <label>Type of Visa</label>
                              <select name="visaTypeId" id="visaType" required = "">
                                  <option value="">Select</option>
                                  @foreach($allVisaData as $key => $data)
                                    <option value="{{$key}}">{{$data['name']}}</option>
                                  @endforeach
                              </select>
                          </div>
                      </div>
                      <div class="col-sm-4">
                          <div class="from-group">
                              <label>Country Living In</label>
                            <select name="livincountry" id="livincountry" required="" >
                                <option value="">Select</option>
                                @foreach($countryName as $key => $data)
                                  <option value="{{$data->country_name}}">{{$data->country_name}}</option>
                                @endforeach
                            </select>
                          </div>
                      </div>
                       <div class="col-sm-4">
                          <div class="from-group">
                              <label>Port of Arrival</label>
                              <select name="port_arrival" id="port_arrival" required="">
                                <option value="">Select </option>
                                @foreach($portOfArrival as $key => $data)
                                  <option value="{{$data->port_name}}">{{$data->port_name}}</option>
                                @endforeach
                              </select>
                          </div>
                      </div>
                       <div class="col-sm-4">
                          <div class="from-group">
                              <label>Contact No ( With Country Code )</label>
                             <input type="text" name="phone" class="form-control" required = "" max="13">
                          </div>
                      </div>

                  </div>
              </div>
          </div>
          <?php
           $count=1;
           $dob=[];
           $passportDate=[];
           for($i=0;$i<50;$i++) {
            $dob[date('Y', strtotime('-'.$i.' years', strtotime(date('Y-m-d'))))] = date('Y', strtotime('-'.$i.' years', strtotime(date('Y-m-d'))));
           }
           for($i=0;$i<10;$i++) {
            $passportDate[date('Y', strtotime('+'.$i.' years', strtotime(date('Y-m-d'))))] = date('Y', strtotime('+'.$i.' years', strtotime(date('Y-m-d'))));
           }
           ?>
        <div class="apply-box-main apply-box applicant-box" >
          <span id="applicantArea">
          <div class="apply-box applicant-box" id="applicantSection{{$count}}">
              <div class="apply-box-header">
                  <h2 class="applicantTitle">APPLICANT #1</h2>
                  <a href="#" class="remove-applicant removeApplicant" data="{{$count}}"><i class="fas fa-minus-circle"></i>Remove Applicant</a>
              </div>
              <div class="apply-box-form">
                  <div class="row d-flex">
                      <div class="col-sm-4">
                          <div class="from-group">
                              <label>First Name</label>
                              <input type="text" required="" name="applicant_first_name{{$count}}" class="form-control">
                          </div>
                      </div>
                      <div class="col-sm-4">
                          <div class="from-group">
                              <label>Last Name</label>
                              <input type="text" required="" name="applicant_last_name{{$count}}" class="form-control">
                          </div>
                      </div>
                      <div class="col-sm-4">
                          <div class="from-group">
                              <label>Nationality (as in Passport)</label>
                                <select name="applicant_nationality{{$count}}" class="applicant_nationality" data="{{$count}}" required = "">
                                  <option value="">Select</option>
                                </select>
                          </div>
                      </div>
                      <div class="col-sm-4">
                          <div class="from-group">
                              <label>Date of Birth</label>
                              <div class="date-box d-flex">
                                  <select class="month applicant_dob_month" name="applicant_dob_month{{$count}}" data="{{$count}}" required = "">
                                      <option value="">Month</option>
                                      <option value="1">January</option>
                                      <option value="2">February</option>
                                      <option value="3">March</option>
                                      <option value="4">April</option>
                                      <option value="5">May</option>
                                      <option value="6">June</option>
                                      <option value="7">July</option>
                                      <option value="8">August</option>
                                      <option value="9">September</option>
                                      <option value="10">October</option>
                                      <option value="11">November</option>
                                      <option value="12">December</option>
                                  </select>
                                  <select class="date applicant_dob_date" name="applicant_dob_date{{$count}}" data="{{$count}}" required = "">
                                      <option>Date</option>
                                      <?php for($j=1;$j<=31;$j++){ ?>
                                        <option value="{{$j}}">{{$j}}</option>
                                      <?php } ?>
                                  </select>
                                  <select class="year applicant_dob_year" name="applicant_dob_year{{$count}}" data="{{$count}}" required = "">
                                      <option>Year</option>
                                      @foreach($dob as $key => $val)
                                        <option value="{{$val}}">{{$val}}</option>
                                      @endforeach
                                  </select>
                              </div>

                          </div>
                      </div>
                      <div class="col-sm-4">
                          <div class="from-group">
                              <label>Gender</label>
                              <select name="applicant_gender{{$count}}" data="{{$count}}" class="applicant_gender" id="gender" required = "">
                                  <option value="1">Male</option>
                                  <option value="2">Female</option>
                               </select>
                          </div>
                      </div>
                      <div class="col-sm-4">
                          <div class="from-group">
                              <label>Passport Expiry Date</label>
                              <div class="date-box d-flex">
                                <select class="month applicant_passport_month" name="applicant_passport_month{{$count}}" data="{{$count}}" required = "">
                                    <option value="">Month</option>
                                    <option value="1">January</option>
                                    <option value="2">February</option>
                                    <option value="3">March</option>
                                    <option value="4">April</option>
                                    <option value="5">May</option>
                                    <option value="6">June</option>
                                    <option value="7">July</option>
                                    <option value="8">August</option>
                                    <option value="9">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                                <select class="date applicant_passport_date" name="applicant_passport_date{{$count}}" data="{{$count}}" required = "">
                                    <option>Date</option>
                                    <?php for($j=1;$j<=31;$j++){ ?>
                                      <option value="{{$j}}">{{$j}}</option>
                                    <?php } ?>
                                </select>
                                <select class="year applicant_passport_year" name="applicant_passport_year{{$count}}" data="{{$count}}" required = "">
                                    <option>Year</option>
                                    @foreach($passportDate as $key => $val)
                                      <option value="{{$val}}">{{$val}}</option>
                                    @endforeach
                                </select>
                              </div>

                          </div>
                      </div>
                  </div>
              </div>
          </div>
          </span>

           <div class="add-applicant-box">
              <p>Click below to add more applicants within your order:</p>
              <button class="btn" id="addApplicant" type="button"><i class="fa fa-user-plus"></i>Add new applicant</button>
            </div>
            </div>
            <div class="process-time-box">
                <div class="apply-box-header">
                  <h2>PROCESSING TIME</h2>
              </div>
              <div class="row d-flex">
                  <div class="col-sm-4">
                      <div class="processing-time">
                          <input type="radio" checked="checked" name="visa_process_type" class="visa_process_type" value="standard">
                          <div>
                              Standard Processing
                              <b>5 -7 Working Days</b>
                          </div>
                      </div>
                  </div>
                  <div class="col-sm-4">
                      <div class="processing-time">
                          <input type="radio" class="visa_process_type" name="visa_process_type" value="rush">
                          <div>
                              Rush Processing
                              <b>With in 4 Working Days</b>
                          </div>
                      </div>
                  </div>
                  <div class="col-sm-4">
                      <div class="processing-time">
                          <input type="radio" checked="checked" name="visa_process_type" class="visa_process_type" value="superrush">
                          <div>
                              Standard Processing
                              <b>5 -7 Working Days</b>
                          </div>
                      </div>
                  </div>
              </div>
            </div>
            <input type="hidden" name="totalCount" value="{{$count}}" id="totalCount"/>
            <div class="total-sum">
                <h4>Total: USD <span id="totalAmount">00.00</span></h4>
                <button class="btn" type="submit">Save & Continue</button>
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
$(function(){
  let count = {{++$count}};
  let dob = <?php echo json_encode($dob)?>;
  let passportDate = <?php echo json_encode($passportDate)?>;
  let allVisaData = <?php echo json_encode($allVisaData)?>;
  $("#addApplicant").click(function(){
      let nationalityVal = $("#visaType").val();
      let nationality = "";
      let dobset = "";
      let dates = "";
      let passportList = "";
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
      let temStr = '<div class="apply-box applicant-box" id="applicantSection'+count+'"> <div class="apply-box-header"> <h2 class="applicantTitle">APPLICANT #'+count+'</h2> <a href="#" class="remove-applicant removeApplicant" data="'+count+'"><i class="fas fa-minus-circle"></i>Remove Applicant</a> </div> <div class="apply-box-form"> <div class="row d-flex"> <div class="col-sm-4"> <div class="from-group"> <label>First Name</label> <input type="text" required="" name="applicant_first_name'+count+'" class="form-control"> </div> </div> <div class="col-sm-4"> <div class="from-group"> <label>Last Name</label> <input type="text" required="" name="applicant_last_name'+count+'" class="form-control"> </div> </div> <div class="col-sm-4"> <div class="from-group"> <label>Nationality (as in Passport)</label> <select name="applicant_nationality'+count+'" class="applicant_nationality" data="'+count+'" required=""> <option value="">Select</option> '+nationality+' </select> </div> </div> <div class="col-sm-4"> <div class="from-group"> <label>Date of Birth</label> <div class="date-box d-flex"> <select class="month applicant_dob_month" required = "" name="applicant_dob_month'+count+'" data="'+count+'"> <option value="">Month</option> <option value="1">January</option> <option value="2">February</option> <option value="3">March</option> <option value="4">April</option> <option value="5">May</option> <option value="6">June</option> <option value="7">July</option> <option value="8">August</option> <option value="9">September</option> <option value="10">October</option> <option value="11">November</option> <option value="12">December</option> </select> <select class="date applicant_dob_date" name="applicant_dob_date'+count+'" data="'+count+'" required = ""> <option>Date</option> '+dates+' </select> <select class="year applicant_dob_year" name="applicant_dob_year'+count+'" data="'+count+'" required = ""> <option>Year</option> '+dobset+' </select> </div> </div> </div> <div class="col-sm-4"> <div class="from-group"> <label>Gender</label> <select name="applicant_gender'+count+'" data="'+count+'" class="applicant_gender" id="gender" required = ""> <option value="1">Male</option> <option value="2">Female</option> </select> </div> </div> <div class="col-sm-4"> <div class="from-group"> <label>Passport Expiry Date</label> <div class="date-box d-flex"> <select class="month applicant_passport_month" name="applicant_passport_month'+count+'" data="'+count+'" required = ""> <option value="">Month</option> <option value="1">January</option> <option value="2">February</option> <option value="3">March</option> <option value="4">April</option> <option value="5">May</option> <option value="6">June</option> <option value="7">July</option> <option value="8">August</option> <option value="9">September</option> <option value="10">October</option> <option value="11">November</option> <option value="12">December</option> </select> <select class="date applicant_passport_date" name="applicant_passport_date'+count+'" data="'+count+'" required = ""> <option>Date</option> '+dates+' </select> <select class="year applicant_passport_year" name="applicant_passport_year'+count+'" data="'+count+'" required = ""> <option>Year</option> '+passportList+' </select> </div> </div> </div> </div> </div> </div>';

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
      if(id.length > 0){
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
    if(visaTypeId.length > 0 && visaProcessingType.length > 0){

        $('.applicant_nationality').each(function(i, obj) {
             let nationality = $(this).val();
             if(nationality.length > 0){
               totalAmount += parseFloat(allVisaData[visaTypeId]['country'][nationality.toLowerCase()]['USD'][visaProcessingType.toLowerCase()]);
             }
        });
    }
    $("#totalAmount").text(totalAmount);
  }

});

</script>
@endsection

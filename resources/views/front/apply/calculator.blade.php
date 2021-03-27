@extends('front.layouts.app')

@section('content')

<h1 class="inner-head bg-heading" style="text-align:center;">Get Your Travel Document for India</h1>
<section class="apply-section">
  <div class="container">
    <div class="row d-flex justify-center">
      <div class="col-sm-12">
          <form method="POST" action="{{ route('apply.save') }}" accept-charset="UTF-8" enctype="multipart/form-data">
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
                                                <select name="livincountry" id="livincountry" required="">
                                            <option value="">Select</option>
                                                                           <option value="2">Afghanistan</option>
                                                                           <option value="3">Albania</option>
                                                                           <option value="4">Algeria</option>
                                                                           <option value="5">Andorra</option>
                                                                           <option value="6">Angola</option>
                                                                           <option value="7">Antigua and Barbuda</option>
                                                                           <option value="8">Argentina</option>
                                                                           <option value="9">Armenia</option>
                                                                           <option value="10">Australia</option>
                                                                           <option value="11">Austria</option>
                                                                           <option value="12">Azerbaijan</option>
                                                                           <option value="13">Bahamas</option>
                                                                           <option value="14">Bahrain</option>
                                                                           <option value="15">Bangladesh</option>
                                                                           <option value="16">Barbados</option>
                                                                           <option value="17">Belarus</option>
                                                                           <option value="18">Belgium</option>
                                                                           <option value="19">Belize</option>
                                                                           <option value="20">Benin</option>
                                                                           <option value="21">Bhutan</option>
                                                                           <option value="22">Bolivia</option>
                                                                           <option value="23">Bosnia and Herzegovina</option>
                                                                           <option value="24">Botswana</option>
                                                                           <option value="25">Brazil</option>
                                                                           <option value="26">Brunei</option>
                                                                           <option value="27">Bulgaria</option>
                                                                           <option value="28">Burkina Faso</option>
                                                                           <option value="29">Burma</option>
                                                                           <option value="30">Burundi</option>
                                                                           <option value="31">Cambodia</option>
                                                                           <option value="32">Cameroon</option>
                                                                           <option value="33">Canada</option>
                                                                           <option value="34">Cape Verde</option>
                                                                           <option value="35">Central African Republic</option>
                                                                           <option value="36">Chad</option>
                                                                           <option value="37">Chile</option>
                                                                           <option value="38">China</option>
                                                                           <option value="39">Colombia</option>
                                                                           <option value="40">Comoros</option>
                                                                           <option value="41">Congo</option>
                                                                           <option value="42">Cook Islands</option>
                                                                           <option value="43">Costa Rica</option>
                                                                           <option value="44">Croatia</option>
                                                                           <option value="45">Cuba</option>
                                                                           <option value="46">Cyprus</option>
                                                                           <option value="47">Czech Republic</option>
                                                                           <option value="48">C?te d'Ivoire</option>
                                                                           <option value="49">Denmark</option>
                                                                           <option value="50">Djibouti</option>
                                                                           <option value="51">Dominica</option>
                                                                           <option value="52">Dominican Republic</option>
                                                                           <option value="53">East Timor</option>
                                                                           <option value="54">Ecuador</option>
                                                                           <option value="55">Egypt</option>
                                                                           <option value="56">El Salvador</option>
                                                                           <option value="57">Equatorial Guinea</option>
                                                                           <option value="58">Eritrea</option>
                                                                           <option value="59">Estonia</option>
                                                                           <option value="60">Ethiopia</option>
                                                                           <option value="61">Fiji</option>
                                                                           <option value="62">Finland</option>
                                                                           <option value="63">France</option>
                                                                           <option value="64">Gabon</option>
                                                                           <option value="65">Gambia</option>
                                                                           <option value="66">Georgia</option>
                                                                           <option value="67">Germany</option>
                                                                           <option value="68">Ghana</option>
                                                                           <option value="69">Greece</option>
                                                                           <option value="70">Grenada</option>
                                                                           <option value="71">Guatemala</option>
                                                                           <option value="72">Guinea</option>
                                                                           <option value="73">Guinea-Bissau</option>
                                                                           <option value="74">Guyana</option>
                                                                           <option value="75">Haiti</option>
                                                                           <option value="76">Honduras</option>
                                                                           <option value="77">Hungary</option>
                                                                           <option value="78">Iceland</option>
                                                                           <option value="79">India</option>
                                                                           <option value="80">Indonesia</option>
                                                                           <option value="81">Iran</option>
                                                                           <option value="82">Iraq</option>
                                                                           <option value="83">Ireland</option>
                                                                           <option value="84">Israel</option>
                                                                           <option value="85">Italy</option>
                                                                           <option value="86">Ivory Coast</option>
                                                                           <option value="87">Jamaica</option>
                                                                           <option value="88">Japan</option>
                                                                           <option value="89">Jordan</option>
                                                                           <option value="90">Kazakhstan</option>
                                                                           <option value="91">Kenya</option>
                                                                           <option value="92">Kiribati</option>
                                                                           <option value="93">Korea, North</option>
                                                                           <option value="94">Korea, South</option>
                                                                           <option value="95">Kosovo</option>
                                                                           <option value="96">Kuwait</option>
                                                                           <option value="97">Kyrgyzstan</option>
                                                                           <option value="98">Laos</option>
                                                                           <option value="99">Latvia</option>
                                                                           <option value="100">Lebanon</option>
                                                                           <option value="101">Lesotho</option>
                                                                           <option value="102">Liberia</option>
                                                                           <option value="103">Libya</option>
                                                                           <option value="104">Liechtenstein</option>
                                                                           <option value="105">Lithuania</option>
                                                                           <option value="106">Luxembourg</option>
                                                                           <option value="107">Macedonia</option>
                                                                           <option value="108">Madagascar</option>
                                                                           <option value="109">Malawi</option>
                                                                           <option value="110">Malaysia</option>
                                                                           <option value="111">Maldives</option>
                                                                           <option value="112">Mali</option>
                                                                           <option value="113">Malta</option>
                                                                           <option value="114">Marshall Islands</option>
                                                                           <option value="115">Mauritania</option>
                                                                           <option value="116">Mauritius</option>
                                                                           <option value="117">Mexico</option>
                                                                           <option value="118">Micronesia</option>
                                                                           <option value="119">Moldova</option>
                                                                           <option value="120">Monaco</option>
                                                                           <option value="121">Mongolia</option>
                                                                           <option value="122">Montenegro</option>
                                                                           <option value="123">Morocco</option>
                                                                           <option value="124">Mozambique</option>
                                                                           <option value="125">Myanmar / Burma</option>
                                                                           <option value="126">Nagorno-Karabakh</option>
                                                                           <option value="127">Namibia</option>
                                                                           <option value="128">Nauru</option>
                                                                           <option value="129">Nepal</option>
                                                                           <option value="130">Netherlands</option>
                                                                           <option value="131">New Zealand</option>
                                                                           <option value="132">Nicaragua</option>
                                                                           <option value="133">Niger</option>
                                                                           <option value="134">Nigeria</option>
                                                                           <option value="135">Niue</option>
                                                                           <option value="136">Northern Cyprus</option>
                                                                           <option value="137">Norway</option>
                                                                           <option value="138">Oman</option>
                                                                           <option value="139">Pakistan</option>
                                                                           <option value="140">Palau</option>
                                                                           <option value="141">Palestine</option>
                                                                           <option value="142">Panama</option>
                                                                           <option value="143">Papua New Guinea</option>
                                                                           <option value="144">Paraguay</option>
                                                                           <option value="145">Peru</option>
                                                                           <option value="146">Philippines</option>
                                                                           <option value="147">Poland</option>
                                                                           <option value="148">Portugal</option>
                                                                           <option value="149">Qatar</option>
                                                                           <option value="150">Romania</option>
                                                                           <option value="151">Russia</option>
                                                                           <option value="152">Rwanda</option>
                                                                           <option value="153">Sahrawi Arab Democratic Republic</option>
                                                                           <option value="154">Saint Kitts and Nevis</option>
                                                                           <option value="155">Saint Lucia</option>
                                                                           <option value="156">Saint Vincent and the Grenadines</option>
                                                                           <option value="157">Samoa</option>
                                                                           <option value="158">San Marino</option>
                                                                           <option value="159">Saudi Arabia</option>
                                                                           <option value="160">Senegal</option>
                                                                           <option value="161">Serbia</option>
                                                                           <option value="162">Seychelles</option>
                                                                           <option value="163">Sierra Leone</option>
                                                                           <option value="164">Singapore</option>
                                                                           <option value="165">Slovakia</option>
                                                                           <option value="166">Slovenia</option>
                                                                           <option value="167">Solomon Islands</option>
                                                                           <option value="168">Somalia</option>
                                                                           <option value="169">Somaliland</option>
                                                                           <option value="170">South Africa</option>
                                                                           <option value="171">South Ossetia</option>
                                                                           <option value="172">Spain</option>
                                                                           <option value="173">Sri Lanka</option>
                                                                           <option value="174">Sudan</option>
                                                                           <option value="175">Suriname</option>
                                                                           <option value="176">Swaziland</option>
                                                                           <option value="177">Sweden</option>
                                                                           <option value="178">Switzerland</option>
                                                                           <option value="179">Syria</option>
                                                                           <option value="180">S?o Tom? and Pr?ncipe</option>
                                                                           <option value="181">Taiwan</option>
                                                                           <option value="182">Tajikistan</option>
                                                                           <option value="183">Tanzania</option>
                                                                           <option value="184">Thailand</option>
                                                                           <option value="185">Timor-Leste / East Timor</option>
                                                                           <option value="186">Togo</option>
                                                                           <option value="187">Tonga</option>
                                                                           <option value="188">Trinidad and Tobago</option>
                                                                           <option value="189">Tunisia</option>
                                                                           <option value="190">Turkey</option>
                                                                           <option value="191">Turkmenistan</option>
                                                                           <option value="192">Tuvalu</option>
                                                                           <option value="193">Uganda</option>
                                                                           <option value="194">Ukraine</option>
                                                                           <option value="195">United Arab Emirates</option>
                                                                           <option value="196">United Kingdom</option>
                                                                           <option value="197">United States</option>
                                                                           <option value="198">Uruguay</option>
                                                                           <option value="199">Uzbekistan</option>
                                                                           <option value="200">Vanuatu</option>
                                                                           <option value="201">Vatican City</option>
                                                                           <option value="202">Venezuela</option>
                                                                           <option value="203">Vietnam</option>
                                                                           <option value="204">Yemen</option>
                                                                           <option value="205">Zambia</option>
                                                                           <option value="206">Zimbabwe</option>

                                         </select>
                                              </div>
                                     <div class="row">
                                                  <div class="col-sm-2">
                                                      <div class="from-group">
                                                          <label>Travellers</label>
                                                          <div class="qty">
                                            <span class="minus">-</span>
                                            <input type="number" class="count" name="qty" value="1">
                                            <span class="plus">+</span>
                                                       </div>
                                                      </div>
                                                  </div>
                                                  <div class="col-sm-4">
                                              <div class="from-group">
                                                  <label>Applying For</label>
                                                  <select name="reason" id="reasonid">
                                            <option value="1">1 Month Tourist Visa (Double Entry)</option>
                                            <option value="2">1 Year Tourist Visa (Multiple Entry)</option>
                                            <option value="3">5 Years Tourist Visa (Multiple Entry)</option>
                                          <option value="4">1 Year Business Visa (Multiple Entry)</option>
                                          <option value="5">1 Month Conference Visa (Single Entry) </option>
                                          <option value="6">2 Months Medical Visa (Triple Entry)</option>
                                          <option value="7">2 Months Medical Attendant Visa (Triple Entry)</option>
                                         </select>
                                              </div>
                                          </div>
                                          <div class="col-sm-6 from-group">
                                                                      <label>Processing Time</label>
                                        <div class="processing-box">
                                          <div class="processing-time">
                                              <input type="radio" name="ivc" id="standard" value="standard">
                    						  <span class="checkmark"></span>
                                              <b>Standard <br><span>5 Days</span></b>
                                          </div>
                                          <div class="processing-time">
                                              <input type="radio" id="rush" name="ivc" value="rush" checked>
                    						  <span class="checkmark"></span>
                                                  <b>Rush <br><span>48 Hours</span></b>
                                          </div>
                                          <div class="processing-time">
                                              <input type="radio" name="ivc" id="standard" value="super">
                    						  <span class="checkmark"></span>
                                                  <b>Super Rush <br><span>24 Hours</span></b>
                                          </div>
                                          </div>
                                      </div>
                                              </div>
                                     <div class="order-total-sum">
                    								    <div class="sum-info">
                    										<div>Government Fees (Pay on Arrival)</div>
                    										<div>INR 1,000</div>
                    									</div>
                    									<div class="sum-info">
                    										<div>Service Fee (Standard)</div>
                    										<div>INR 1,000</div>
                    									</div>
                    								</div>
                                </div>
                                <div class="total-sum">
                                    <h4>Total:
                                    <span>
                                        <select>
                                            <option>INR</option>
                                            <option>USD</option>
                                        </select>
                                    25,000</span></h4>
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
                              <input type="email" name="email" class="form-control" required="">
                              <input type="hidden" name="visa_country_name" value="{{$default_visa}}">
                          </div>
                      </div>
                      <div class="col-sm-3">
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
                      <div class="col-sm-3">
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
                                  <option value="{{$data->country_name}}" {{strtolower($data->country_name) == $default_nationality ? "selected":""}}>{{$data->country_name}}</option>
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
                                  <option value="{{$data->port_name}}">{{$data->port_name}}</option>
                                @endforeach
                              </select>
                          </div>
                      </div>
                       <div class="col-sm-3">
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
                      <div class="col-sm-3">
                          <div class="from-group">
                              <label>First Name</label>
                              <input type="text" required="" name="applicant_first_name{{$count}}" class="form-control">
                          </div>
                      </div>
                      <div class="col-sm-3">
                          <div class="from-group">
                              <label>Last Name</label>
                              <input type="text" required="" name="applicant_last_name{{$count}}" class="form-control">
                          </div>
                      </div>
                      <div class="col-sm-3">
                          <div class="from-group">
                              <label>Gender</label>
                              <select name="applicant_gender{{$count}}" data="{{$count}}" class="applicant_gender" id="gender" required = "">
                                  <option value="1">Male</option>
                                  <option value="2">Female</option>
                               </select>
                          </div>
                      </div>

                      <div class="col-sm-3">
                          <div class="from-group">
                              <label>Nationality (as in Passport)</label>
                                <select name="applicant_nationality{{$count}}" class="applicant_nationality" data="{{$count}}" required = "">
                                  <option value="">Select</option>
                                  @foreach($allVisaData[$default_visa_type]['country'] as $key => $data)
                                    <option value="{{$key}}">{{$key}}</option>
                                  @endforeach
                                </select>
                          </div>
                      </div>
                      <div class="col-sm-3">
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
                      <div class="col-sm-3">
                          <div class="from-group">
                              <label>Country of Birth</label>
                            <select name="applicant_country_birth{{$count}}"  required="" >
                                <option value="">Select</option>
                                @foreach($countryName as $key => $data)
                                  <option value="{{$data->country_name}}">{{$data->country_name}}</option>
                                @endforeach
                            </select>
                          </div>
                      </div>
                      <div class="col-sm-3">
                          <div class="from-group">
                              <label>Country of Residence</label>
                            <select name="applicant_country_residence{{$count}}"  required="" >
                                <option value="">Select</option>
                                @foreach($countryName as $key => $data)
                                  <option value="{{$data->country_name}}">{{$data->country_name}}</option>
                                @endforeach
                            </select>
                          </div>
                      </div>
                      <div class="col-sm-3">
                         <div class="from-group">
                             <label>Contact No(With Country Code)</label>
                            <input type="text" name="applicant_phone{{$count}}" class="form-control applicant_phone" required = "" max="13">
                         </div>
                      </div>
                      <div class="col-sm-3">
                          <div class="from-group">
                              <label>Passport issue Date</label>
                              <div class="date-box d-flex">
                                <select class="month applicant_passport_issue_month" name="applicant_passport_issue_month{{$count}}" data="{{$count}}" required = "">
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
                                <select class="date applicant_passport_issue_date" name="applicant_passport_issue_date{{$count}}" data="{{$count}}" required = "">
                                    <option>Date</option>
                                    <?php for($j=1;$j<=31;$j++){ ?>
                                      <option value="{{$j}}">{{$j}}</option>
                                    <?php } ?>
                                </select>
                                <select class="year applicant_passport_issue_year" name="applicant_passport_issue_year{{$count}}" data="{{$count}}" required = "">
                                    <option>Year</option>
                                    @foreach($dob as $key => $val)
                                      <option value="{{$val}}">{{$val}}</option>
                                    @endforeach
                                </select>
                              </div>

                          </div>
                      </div>

                      <div class="col-sm-3">
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
                  <h2>PROCESSING TIME AND FEE</h2>
              </div>
              <div class="row d-flex">
                  <div class="col-sm-12">
                    <div class="processing-box">
                      <div class="processing-time">
                          <input type="radio" name="visa_process_type" checked="checked" class="visa_process_type" id="standard" value="standard">
              <span class="checkmark"></span>
                          <b>Standard <br><span>5 Days</span></b>
                      </div>
                      <div class="processing-time">
                          <input type="radio" id="rush" class="visa_process_type" name="visa_process_type" value="rush">
              <span class="checkmark"></span>
                              <b>Rush <br><span>48 Hours</span></b>
                      </div>
                      <div class="processing-time">
                          <input type="radio" name="visa_process_type" class="visa_process_type" value="express">
              <span class="checkmark"></span>
                              <b>Express <br><span>24 Hours</span></b>
                      </div>
                      </div>
                  </div>
              </div>
            </div>

            <input type="hidden" name="totalCount" value="{{$count}}" id="totalCount"/>
            <div class="apply-box">
              <div class="apply-box-header">
                <h2>Order Details</h2>
              </div>
              <div class="order-total-sum">
                  <div class="sum-info">
                  <div>Government Fees (Pay on Arrival)</div>
                  <div><span class="currencyShow">{{$default_currency}}</span> <span id="totalGovtAmount">00.00</span></div>
                </div>
                <div class="sum-info">
                  <div>Service Fee</div>
                  <div><span class="currencyShow">{{$default_currency}}</span> <span id="totalApplicantAmount">00.00</span></div>
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
                <span id="totalAmount">00.00</span></span></h4>
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
  let default_currency = "{{$default_currency}}";
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

});

</script>
@endsection

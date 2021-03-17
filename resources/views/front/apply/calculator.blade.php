@extends('front.layouts.app')

@section('content')

<section class="apply-section">
  <div class="container">
    <h1 class="inner-head">Get Your Travel Document for India</h1>
    <div class="row d-flex justify-center">
      <div class="col-sm-9">
          <form>
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
                              <label>Arrival Date In India</label>
                              <div class="date-box d-flex">
                                  <select class="month">
                                      <option>Month</option>
                                      <option>January</option>
                                      <option>February</option>
                                      <option>March</option>
                                      <option>April</option>
                                      <option>May</option>
                                      <option>June</option>
                                      <option>July</option>
                                      <option>August</option>
                                      <option>September</option>
                                      <option>October</option>
                                      <option>November</option>
                                      <option>December</option>
                                  </select>
                                  <select class="date">
                                      <option>Day</option>
                                      <option>1</option>
                                      <option>2</option>
                                      <option>3</option>
                                      <option>4</option>
                                      <option>5</option>
                                      <option>6</option>
                                      <option>7</option>
                                      <option>8</option>
                                      <option>9</option>
                                      <option>10</option>
                                  </select>
                                  <select class="year">
                                      <option>Year</option>
                                      <option>2021</option>
                                      <option>2022</option>
                                      <option>2023</option>
                                  </select>
                              </div>

                          </div>
                      </div>
                                           <div class="col-sm-4">
                          <div class="from-group">
                              <label>Departure Date from India</label>
                              <div class="date-box d-flex">
                                  <select class="month">
                                      <option>Month</option>
                                      <option>January</option>
                                      <option>February</option>
                                      <option>March</option>
                                      <option>April</option>
                                      <option>May</option>
                                      <option>June</option>
                                      <option>July</option>
                                      <option>August</option>
                                      <option>September</option>
                                      <option>October</option>
                                      <option>November</option>
                                      <option>December</option>
                                  </select>
                                  <select class="date">
                                      <option>Date</option>
                                      <option>1</option>
                                      <option>2</option>
                                      <option>3</option>
                                      <option>4</option>
                                      <option>5</option>
                                      <option>6</option>
                                      <option>7</option>
                                      <option>8</option>
                                      <option>9</option>
                                      <option>10</option>
                                  </select>
                                  <select class="year">
                                      <option>Year</option>
                                      <option>2021</option>
                                      <option>2022</option>
                                      <option>2023</option>
                                  </select>
                              </div>

                          </div>
                      </div>
                      <div class="col-sm-4">
                          <div class="from-group">
                              <label>Type of Visa</label>
                              <select name="reason" id="reasonid">
                        <option value="">Select</option>
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
                       <div class="col-sm-4">
                          <div class="from-group">
                              <label>Port of Arrival</label>
                              <select name="port_arrival" required="">
                        <option value="">Select </option>
                        <option value="Ahmedabad">AIR -Ahmedabad Airport</option>
                         <option value="Amritsar">AIR-Amritsar Airport</option>
                        <option value="Bagdogra">AIR - BagdograAirport, Nairobi</option>
                        <option value="Bengaluru">AIR - Bengaluru Airport</option>
                       <option value="Calicut">AIR - Calicut Airport</option>


                        <option value="Chennai">AIR - Chennai Airport</option>
                        <option value="Chandigarh">AIR - Chandigarh Airport</option>
                         <option value="Cochin">AIR - Cochin Airport </option>
                         <!--  -->

                        <option value="Coimbatore">AIR - Coimbatore Airport</option>
                        <option value="Delhi">AIR - Delhi Airport</option>





                         <option value="Gaya">AIR - Gaya Airport</option>
                        <option value="Goa">AIR - Goa Airport</option>
                        <!--  -->


                        <option value="Guwahati ">AIR - Guwahati Airport </option>
                        <option value="Hyderabad">AIR - Hyderabad Airport</option>
                        <option value="Jaipur">AIR - Jaipur Airport</option>

                         <option value="Kolkata">AIR - Kolkata Airport</option>
                        <option value="Lucknow">AIR - Lucknow Airport</option>
                        <!--  -->

                        <option value="Mangalore">AIR - Mangalore Airport </option>
                        <option value="Madurai">AIR - Madurai Airport </option>


                        <option value="Mumbai">AIR - Mumbai Airport</option>
                        <option value="Nagpur">AIR - Nagpur Airport</option>

                        <option value="Pune">AIR - Pune Airport</option>
                        <option value="Tiruchirapalli">AIR - Tiruchirapalli Airport</option>
                        <option value="Trivandrum">AIR - Trivandrum Airport</option>
                        <option value="Varanasi">AIR - Varanasi Airport</option>
                         <option value="Vishakhapatnam">AIR - Vishakhapatnam Airport</option>
                         <option value="sea_Chennai"> SEA - Chennai  </option>
                         <option value="Sea_Mumbai">SEA - Mumbai</option>
                         <option value="Sea_Goa">SEA - Goa </option>
                         <option value="Sea_Cochin"> SEA - Cochin  </option>
                     <option value="Sea_Mangalore">SEA - Mangalore</option>
                     </select>
                          </div>
                      </div>
                       <div class="col-sm-4">
                          <div class="from-group">
                              <label>Contact No ( With Country Code )</label>
                             <input type="text" name="phone" class="form-control">
                          </div>
                      </div>
                      <div class="col-sm-4">
                          <div class="from-group">
                              <label>Country Living In</label>
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
                      </div>
                  </div>
              </div>
          </div>
          <div class="apply-box-main apply-box applicant-box">
          <div class="apply-box applicant-box">
              <div class="apply-box-header">
                  <h2>APPLICANT #1</h2>
                  <a href="#" class="remove-applicant"><i class="fas fa-minus-circle"></i>Remove Applicant</a>
              </div>
              <div class="apply-box-form">
                  <div class="row d-flex">
                      <div class="col-sm-4">
                          <div class="from-group">
                              <label>First Name</label>
                              <input type="text" required="" name="firstname" class="form-control">
                          </div>
                      </div>
                      <div class="col-sm-4">
                          <div class="from-group">
                              <label>Last Name</label>
                              <input type="text" required="" name="lastname" class="form-control">
                          </div>
                      </div>
                                            <div class="col-sm-4">
                          <div class="from-group">
                              <label>Nationality (as in Passport)</label>
                            <select name="nationality" id="nationality" required="">
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
                      </div>
                      <div class="col-sm-4">
                          <div class="from-group">
                              <label>Date of Birth</label>
                              <div class="date-box d-flex">
                                  <select class="month">
                                      <option>Month</option>
                                      <option>January</option>
                                      <option>February</option>
                                      <option>March</option>
                                      <option>April</option>
                                      <option>May</option>
                                      <option>June</option>
                                      <option>July</option>
                                      <option>August</option>
                                      <option>September</option>
                                      <option>October</option>
                                      <option>November</option>
                                      <option>December</option>
                                  </select>
                                  <select class="date">
                                      <option>Date</option>
                                      <option>1</option>
                                      <option>2</option>
                                      <option>3</option>
                                      <option>4</option>
                                      <option>5</option>
                                      <option>6</option>
                                      <option>7</option>
                                      <option>8</option>
                                      <option>9</option>
                                      <option>10</option>
                                  </select>
                                  <select class="year">
                                      <option>Year</option>
                                      <option>2021</option>
                                      <option>2022</option>
                                      <option>2023</option>
                                  </select>
                              </div>

                          </div>
                      </div>
                      <div class="col-sm-4">
                          <div class="from-group">
                              <label>Gender</label>
                              <select name="gender" id="gender">

                        <option value="1">Male</option>
                        <option value="2">Female</option>
                     </select>
                          </div>
                      </div>
                      <div class="col-sm-4">
                          <div class="from-group">
                              <label>Passport Expiry Date</label>
                              <div class="date-box d-flex">
                                  <select class="month">
                                      <option>Month</option>
                                      <option>January</option>
                                      <option>February</option>
                                      <option>March</option>
                                      <option>April</option>
                                      <option>May</option>
                                      <option>June</option>
                                      <option>July</option>
                                      <option>August</option>
                                      <option>September</option>
                                      <option>October</option>
                                      <option>November</option>
                                      <option>December</option>
                                  </select>
                                  <select class="date">
                                      <option>Date</option>
                                      <option>1</option>
                                      <option>2</option>
                                      <option>3</option>
                                      <option>4</option>
                                      <option>5</option>
                                      <option>6</option>
                                      <option>7</option>
                                      <option>8</option>
                                      <option>9</option>
                                      <option>10</option>
                                  </select>
                                  <select class="year">
                                      <option>Year</option>
                                      <option>2021</option>
                                      <option>2022</option>
                                      <option>2023</option>
                                  </select>
                              </div>

                          </div>
                      </div>
                  </div>
              </div>
          </div>
           <div class="add-applicant-box">
              <p>Click below to add more applicants within your order:</p>
              <button class="btn"><i class="fa fa-user-plus"></i>Add new applicant</button>
            </div>
            </div>
            <div class="process-time-box">
                <div class="apply-box-header">
                  <h2>PROCESSING TIME</h2>
              </div>
              <div class="row d-flex">
                  <div class="col-sm-4">
                      <div class="processing-time">
                          <input type="radio" checked="checked" name="ivc" id="standard" onclick="tocheckprocess(this)" value="standard">
                          <div>
                              Standard Processing
                              <b>5 -7 Working Days</b>
                          </div>
                      </div>
                  </div>
                  <div class="col-sm-4">
                      <div class="processing-time">
                          <input type="radio" id="rush" onclick="tocheckprocess(this)" name="ivc" value="rush">
                          <div>
                              Rush Processing
                              <b>With in 4 Working Days</b>
                          </div>
                      </div>
                  </div>
                  <div class="col-sm-4">
                      <div class="processing-time">
                          <input type="radio" checked="checked" name="ivc" id="standard" onclick="tocheckprocess(this)" value="standard">
                          <div>
                              Standard Processing
                              <b>5 -7 Working Days</b>
                          </div>
                      </div>
                  </div>
              </div>
            </div>
            <div class="total-sum">
                <h4>Total: <span>25,000</span></h4>
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
});

</script>
@endsection

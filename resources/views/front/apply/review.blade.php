@extends('front.layouts.app')

@section('content')

<section class="info-section">
  <div class="container">
    <h1 class="inner-head">General Information</h1>
    <div class="row">
      <div class="col-sm-12">
	    <form>
		  <div class="general-info-main">
		    <div class="form-group">
			  <label>First Name</label>
			  <input type="text" placeholder="John" name="first-name">
			</div>
			<div class="form-group">
			  <label>Last Name</label>
			  <input type="text" placeholder="Doe" name="last-name">
			</div>
			<div class="form-group">
			  <label>Birth day</label>
			  <input type="date" value="01/01/2021" name="birth-date">
			</div>
			<div class="form-group">
			  <label>Nationality (as in passport)</label>
			  <select>
			    <option>Albania</option>
				<option>USA</option>
			  </select>
			</div>
			<div class="form-group">
			  <label>Gender</label>
			  <select>
			    <option>Male</option>
				<option>Female</option>
			  </select>
			</div>
			<div class="form-group">
			  <label>Email Address</label>
			  <input type="email" placeholder="abc@email.com" name="user-email">
			</div>
			<div class="form-group">
			  <label>Arrival Date in India</label>
			  <input type="date" value="01/01/2021" name="arrival-date">
			</div>
			<div class="form-group">
			  <label>Departure Date from India</label>
			  <input type="date" value="01/01/2021" name="departure-date">
			</div>
			<div class="form-group">
			  <label>Reason for Travel</label>
			  <select>
			    <option>1 month tourist Visa</option>
				<option>2 months tourist Visa</option>
			  </select>
			</div>
			<div class="form-group">
			  <label>Port of Arrival</label>
			  <select>
			    <option>AIR - Amritsar Airport</option>
				<option>IGI - Indira Gandhi International Airport</option>
			  </select>
			</div>
			<div class="form-group">
			  <label>Country Living in</label>
			  <select>
			    <option>Albania</option>
				<option>USA</option>
			  </select>
			</div>
			<div class="form-group">
			  <label>Passport Expiry Date</label>
			  <input type="date" value="01/01/2021" name="expiry-date">
			</div>
	      </div>
		</form>
      </div>
    </div>
    </div>
  </div>
</section>

<section class="upload-documents-section">
  <div class="container">
     <div class="row">
      <div class="col-sm-12">
	     <form>
		   <div class="upload-documents-inner">
		      <div class="document_box">
			    <h2 class="inner-head">Upload Documents</h2>
			  </div>
			  <div class="document_box">
			    <label>Passport</label>
				<input type="file" name="passport">
				<p class="hint">Clear Scan Copy of Bio-page of passport</p>
			  </div>
			  <div class="document_box">
			    <label>Photograph</label>
				<input type="file" name="photo">
				<p class="hint">Clear Scan of latest passport photo on white background</p>
			  </div>
			  <div class="document_box">
			    <label>Total</label>
				<label>SGD $70</label>
			  </div>
			  <div class="document_box">
			   <button type="submit">Next</button>
			  </div>
		   </div>
		 </form>
	  </div>
	 </div>
  </div>
</div>

@stop
@section('javascript')

<script type="text/javascript">

</script>
@endsection

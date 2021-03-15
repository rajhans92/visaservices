@extends('front.layouts.app')

@section('content')

<section class="register-section blogs-section">

  <div class="inner-content">
      <div class="right-content">
          <h1>{{$visaData->visa_heading}}</h1>
          <p class="slogan">{{$visaData->visa_content_1}}</p>
          @if($visaData->visa_landing_img != "")
            <div class="_img">
              <img src="{{url('images/visa/'.$visaData->visa_landing_img)}}" />
            </div>
          @endif
          <div class="_des">
          <p>{{$visaData->visa_content_2}}</p>
          <a href="#">{{$visaData->visa_main_button}}</a>
         </div>
         <h1 style="margin-top: 80px;">{{$visaData->visa_faqs}}</h1>
         <div class="accordion faq-section" id="accordionExample">
           @foreach($visaFaqs as $key => $val)
             <div class="accordion-item">
               <h2 class="accordion-header" id="heading{{$val->id}}">
                 <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$val->id}}" aria-expanded="false" aria-controls="collapseOne">
                  {{$val->question}}
                 </button>
               </h2>
               <div id="collapse{{$val->id}}" class="accordion-collapse collapse" aria-labelledby="heading{{$val->id}}" data-bs-parent="#accordionExample">
                 <div class="accordion-body">
                  {{$val->answer}}
                </div>
               </div>
             </div>
           @endforeach
         </div>
      </div>
      <div class="left-sidebar">
          <div class="box-content">
             <div class="form-group">
                 <label>{{$visaData->visa_nationality_title}}</label>
                 <select>
                     <option>India</option>
                     <option>Canada</option>
                 </select>
             </div>
              <div class="fees-box days-box">
                  <span><img src="images/rush.png">{{$visaData->visa_type_title}}:</span>
                  <span><b>2 Days</b></span>
            </div>
             <button class="btn">{{$visaData->visa_main_button}}</button>
          </div>
          <h5 class="top-articles-heading">{{$visaData->visa_popular_title}}</h5>
          <ul class="top-articles">
              <li><a href="#">Valid for Tourist eVisa <select><option>INR</option></select> 3300</a></li>
              <li><a href="#">Valid for Tourist eVisa <select><option>INR</option></select> 3300</a></li>
              <li><a href="#">Valid for Tourist eVisa <select><option>INR</option></select> 3300</a></li>
              <li><a href="#">Valid for Tourist eVisa <select><option>INR</option></select> 3300</a></li>
              <li><a href="#">Valid for Tourist eVisa <select><option>INR</option></select> 3300</a></li>
          </ul>
      </div>
  </div>

</section>

<!-- <div class="mobile-apply-btn">
    <span><b>2000</b> /Applicant</span>
    <button class="btn">Apply</button>
</div> -->


@stop
@section('javascript')

<script type="text/javascript">
$(function(){

});

</script>
@endsection

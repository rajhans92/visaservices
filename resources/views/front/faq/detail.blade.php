@extends('front.layouts.app')


@section('content')
<!-- Header -->
<section class="faq-section">
  <div class="container">
    <div class="row justify-center">
      <div class="col-sm-10">
        <h1 class="inner-head">Frequently Asked Questions</h1>
        <div class="row">
          <div class="col-sm-8">
            <div class="faqs-select">
              <div class="text">
                  Country Specific FAQs
              </div>
              <div class="select-country-dropdown">
                  <select id="country">
                      <option>Choose Country</option>
                      @foreach($secondDropdown as $key => $val)
                        <option value="{{$val->visa_url}}" data="{{$val->country_name}}">{{$val->country_name}} ({{$val->country_code}})</option>
                      @endforeach
                  </select>
              </div>
            </div>

            <div class="accordion" id="accordionExample">
              @if(isset($data[0]->id))
              @foreach($data as $key => $val)
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne{{$val->id}}">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne{{$val->id}}" aria-expanded="false" aria-controls="collapseOne">
                        {{$val->question}}
                      </button>
                    </h2>
                    <div id="collapseOne{{$val->id}}" class="accordion-collapse collapse" aria-labelledby="headingOne{{$val->id}}" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            {!! $val->answer !!}
                        </div>
                    </div>
                  </div>
                  <hr>
              @endforeach
              @endif
            </div>
            </div>
      <div class="col-sm-4">
          <div class="visachecker-box">
              <div class="intro-box" style="background-image:url(https://images.pexels.com/photos/210012/pexels-photo-210012.jpeg?auto=compress&cs=tinysrgb&h=750&w=1260);">
                  <img src="images/logo.png" />
                  <h3>Check Travel Requirements</h3>
              </div>
              <div class="sidebar-form">
             <form>
               <div class="form-group">
                 <label for="locationto" class="form-label">Where am I Going?</label>
                 <select class="form-select" aria-label="Where am I Going?" id="secondDropdown">
                   @foreach($secondDropdown as $key => $val)
                     <option value="{{$val->visa_url}}" data="{{$val->country_name}}">{{$val->country_name}} ({{$val->country_code}})</option>
                   @endforeach
                </select>
               </div>
               <div class="form-group">
                  <button type="button" class="btn apply-btn" id="applyBtn">Apply</button>
               </div>
             </form>
           </div>
          </div>
          <div class="side-links">
              <!--<a href="#"><i class="far fa-file-alt"></i>Start New Application</a>-->
              <a href="#"><i class="far fa-comments"></i>Contact Us</a>
              <a href="#"><i class="fa fa-headset"></i>Support</a>
              <a href="#"><i class="fa fa-search"></i>Check Status of Order</a>
          </div>
          <div class="faq-social-links">
              <ul>
                  <li><a href="{{$footerData->social_network_link1}}"><i class="fab fa-facebook-f"></i></a></li>
                  <li><a href="{{$footerData->social_network_link2}}"><i class="fab fa-twitter"></i></a></li>
                  <li><a href="{{$footerData->social_network_link3}}"><i class="fab fa-instagram"></i></a></li>
              </ul>
          </div>
      </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- REVIEWS -->
<section class="reviews-section section-spacing">
   <div class="container">
     <h2 class="section-head text-center">{{$homeData->section_4_title}}</h2>
     <div class="row">
       <div class="col-lg-6 col-md-6 col-sm-12">
         <div class="review-box">
           <div class="img">
             <img src="{{url('images/home/'.$homeData->client_img_1) }}" onerror="this.src='{{ url('images/default.png') }}'" />
           </div>
           <div class="info">
              <h4>{{$homeData->client_name_1}}</h4>
              <p>{{$homeData->client_review_1}}</p>
           </div>
       </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12">
         <div class="review-box">
           <div class="img">
             <img src="{{url('images/home/'.$homeData->client_img_2) }}" onerror="this.src='{{ url('images/default.png') }}'"  />
           </div>
           <div class="info">
             <h4>{{$homeData->client_name_2}}</h4>
             <p>{{$homeData->client_review_2}}</p>
           </div>
       </div>
      </div>
    </div>
    <div class="row">
       <div class="col-lg-6 col-md-6 col-sm-12">
         <div class="review-box">
           <div class="img">
             <img src="{{url('images/home/'.$homeData->client_img_3) }}" onerror="this.src='{{ url('images/default.png') }}'"  />
           </div>
           <div class="info">
             <h4>{{$homeData->client_name_3}}</h4>
             <p>{{$homeData->client_review_3}}</p>
           </div>
       </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12">
         <div class="review-box">
           <div class="img">
             <img src="{{url('images/home/'.$homeData->client_img_4) }}" onerror="this.src='{{ url('images/default.png') }}'"  />
           </div>
           <div class="info">
             <h4>{{$homeData->client_name_4}}</h4>
             <p>{{$homeData->client_review_4}}</p>
           </div>
       </div>
      </div>
    </div>
   </div>
</section>
@stop
@section('javascript')

<script type="text/javascript">
$(document).ready(function(){
  $("#applyBtn").click(function(){
      let url = $("#secondDropdown").val();

      var d = new Date();
      d.setTime(d.getTime() + (2*24*60*60*1000));
      var expires = "expires="+ d.toUTCString();

      let goname = "go_country";
      let fromname = "from_country";
      let govalue = $("#secondDropdown option").filter(":selected").attr("data");
      let fromvalue = '{{env("APP_DEFAULT_COUNTRY")}}';

      document.cookie = fromname + "=" + fromvalue + ";" + expires + ";path=/";
      document.cookie = goname + "=" + govalue + ";" + expires + ";path=/";
      if(url.length > 0)
        window.location = window.location.origin + '/'+ url;

  });
  $("#country").change(function(){
       let url = $(this).val();

       var d = new Date();
       d.setTime(d.getTime() + (2*24*60*60*1000));
       var expires = "expires="+ d.toUTCString();

       let goname = "go_country";
       let fromname = "from_country";
       let govalue = $("#secondDropdown option").filter(":selected").attr("data");
       let fromvalue = '{{env("APP_DEFAULT_COUNTRY")}}';

       document.cookie = fromname + "=" + fromvalue + ";" + expires + ";path=/";
       document.cookie = goname + "=" + govalue + ";" + expires + ";path=/";
       if(url.length > 0)
         window.location = window.location.origin + '/'+ url+'#faq-section';
  });
});
</script>
@endsection

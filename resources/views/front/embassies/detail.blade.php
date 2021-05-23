@extends('front.layouts.app')


@section('content')
<!-- Header -->
<section class="faq-section embassy-listing-section">
  <div class="container">
    <div class="row justify-center">
      <div class="col-sm-9">
        <h1 class="inner-head">Select an Embassy</h1>
        <div class="faqs-select">
          <div class="text">
              Embassy of
          </div>
          <div class="select-country-dropdown">
              <select id="embassy_of">
                @foreach($data as $key => $val)
                  <option value="{{$val->id}}" {{strtolower($val->name) == strtolower($embassy->name) ? "selected" : ""}}>{{$val->name}}</option>
                @endforeach
              </select>
          </div>
          <div class="in-text">In</div>
          <div class="select-country-dropdown">
              <select id="embassy_in">
                @foreach($embassyList as $key => $val)
                  <option value="{{$val->embassy_in}}">{{$val->embassy_in}}</option>
                @endforeach
              </select>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-8">

          @foreach($embassyList as $key => $val)
            <div class="apply-box">
              <div class="apply-box-header">
                  <h2>{{$val->heading}}</h2>
                  <a href="#">REPORT CHANGES</a>
              </div>
              <div class="apply-box-info">
                  <div class="_cont">
                      <span>Address</span>
                      <span>{{$val->address}}</span>
                  </div>
                  <div class="_cont">
                      <span>Contact Us</span>
                      <a href="tel:{{$val->contact_us}}">{{$val->contact_us}}</a>
                  </div>
                  <div class="_cont">
                      <span>Website</span>
                      <a href="{{$val->website}}">{{$val->website}}</a>
                  </div>
                  <div class="_cont">
                      <span>Email Address</span>
                      <a href="{{$val->email_id}}">{{$val->email_id}}</a>
                  </div>
                  <div class="_cont">
                      <span>Map location</span>
                      <a href="{{$val->map_location}}">click here</a>
                  </div>
              </div>
            </div>
          @endforeach

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
                 <select class="form-select" aria-label="Where am I Going?">
                  <option selected>INDIA (IN)</option>
                  <option value="1">EGYPT (EG)</option>
                  <option value="2">MEXICO (MX)</option>
                </select>
               </div>
               <div class="form-group">
                  <button type="button" class="btn apply-btn">Apply</button>
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
                  <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                  <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                  <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                  <li><a href="#"><i class="fab fa-pinterest-p"></i></a></li>
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
     <h2 class="section-head text-center">Our Customers Have Great Stories About Us</h2>
     <div class="row">
       <div class="col-lg-6 col-md-6 col-sm-12">
         <div class="review-box">
           <div class="img">
             <img src="https://preview.keenthemes.com/metronic-v4/theme/assets/pages/media/profile/profile_user.jpg" />
           </div>
           <div class="info">
              <h4>Alan</h4>
              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
           </div>
       </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12">
         <div class="review-box">
           <div class="img">
             <img src="https://preview.keenthemes.com/metronic-v4/theme/assets/pages/media/profile/profile_user.jpg" />
           </div>
           <div class="info">
              <h4>Alan</h4>
              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
           </div>
       </div>
      </div>
    </div>
    <div class="row">
       <div class="col-lg-6 col-md-6 col-sm-12">
         <div class="review-box">
           <div class="img">
             <img src="https://preview.keenthemes.com/metronic-v4/theme/assets/pages/media/profile/profile_user.jpg" />
           </div>
           <div class="info">
              <h4>Alan</h4>
              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
           </div>
       </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12">
         <div class="review-box">
           <div class="img">
             <img src="https://preview.keenthemes.com/metronic-v4/theme/assets/pages/media/profile/profile_user.jpg" />
           </div>
           <div class="info">
              <h4>Alan</h4>
              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
           </div>
       </div>
      </div>
    </div>
   </div>
</section>

@stop
@section('javascript')

<script type="text/javascript">

</script>
@endsection

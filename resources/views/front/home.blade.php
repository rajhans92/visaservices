@extends('front.layouts.app')

@section('content')
<!-- Banner Section -->
<section class="banner-section" style="background-image:url(images/banner.jpeg);">
   <div class="container">
     <div class="row">
        <div class="col-sm-12">
           <h1>Get your Visa Approved.<br> Simple & Reliable</h1>
           <!--<h4>Check Travel Requirements</h4>-->
           <div class="search-form">
             <form class="d-flex">
               <div class="form-group">
                 <label for="locationfrom" class="form-label">Where am I From?</label>
                 <select class="form-select" aria-label="Where am I From?">
                  <option selected>INDIA (IN)</option>
                  <option value="1">EGYPT (EG)</option>
                  <option value="2">MEXICO (MX)</option>
                </select>
               </div>
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
           <div class="popular">Popular:
           <ul>
           <li><a href="#">Web and Mobile Design</a></li>
           <li><a href="#">WordPress</a></li>
           <li><a href="#">Web and Mobile Design</a></li>
           <li><a href="#">WordPress</a></li>
           </ul>
           </div>
           <div class="google-ratings">
              <span><b>Excellent</b></span>
              <span class="star"><img src="images/4.5stars.png" /></span>
              <span><b>2441</b>&nbsp;reviews on</span>
              <span class="google-img"><img src="images/google.png" /></span>
           </div>
        </div>
     </div>
   </div>
</section>
<!-- VISA COUNTRY -->
<section class="visa-section">
   <div class="container">
     <div class="row">
        <div class="col-sm-12 text-center">
           <h2 class="section-head text-center">Popular Visa's</h2>
           <ul>
              <li>
                <div class="flag-main">
                 <div class="flag-image">
                    <img src="images/flags/1.png" />
                 </div>
                 <div class="cont">
                     <h6>Colombia</h6>
                     <a href="#">Apply</a>
                 </div>
                 </div>
                 <div class="flag-main">
                  <div class="flag-image">
                    <img src="images/flags/5.jpg" />
                 </div>
                 <div class="cont">
                     <h6>Turkey</h6>
                     <a href="#">Apply</a>
                 </div>
                 </div>
              </li>
              <li>
                 <div class="flag-main">
                 <div class="flag-image">
                    <img src="images/flags/2.png" />
                 </div>
                 <div class="cont">
                     <h6>India</h6>
                     <a href="#">Apply</a>
                 </div>
                 </div>
                 <div class="flag-main">
                    <div class="flag-image">
                    <img src="images/flags/5.jpg" />
                 </div>
                 <div class="cont">
                     <h6>Turkey</h6>
                     <a href="#">Apply</a>
                 </div>
                 </div>
              </li>
              <li>
                  <div class="flag-main">
                 <div class="flag-image">
                    <img src="images/flags/3.png" />
                 </div>
                 <div class="cont">
                     <h6>Egypt</h6>
                     <a href="#">Apply</a>
                 </div>
                 </div>
                 <div class="flag-main">
                 <div class="flag-image">
                    <img src="images/flags/5.jpg" />
                 </div>
                 <div class="cont">
                     <h6>Turkey</h6>
                     <a href="#">Apply</a>
                 </div>
                </div>
              </li>
              <li>
                <div class="flag-main">
                 <div class="flag-image">
                    <img src="images/flags/4.png" />
                 </div>
                 <div class="cont">
                     <h6>Mexico</h6>
                     <a href="#">Apply</a>
                 </div>
                </div>
                <div class="flag-main">
                 <div class="flag-image">
                    <img src="images/flags/5.jpg" />
                 </div>
                 <div class="cont">
                     <h6>Turkey</h6>
                     <a href="#">Apply</a>
                 </div>
                </div>
              </li>
           </ul>
        </div>
     </div>
   </div>
</section>
<!-- WHY CHOOSE US -->
<section class="why-choose-section section-spacing">
   <div class="container">
     <h2 class="section-head text-center">Why Choose Us</h2>
     <div class="row">
       <div class="col-lg-3 col-md-3 col-sm-12 text-center">
         <div class="img" style="background-image:url(https://images.pexels.com/photos/4067759/pexels-photo-4067759.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500);">
         </div>
         <h5>Title 1</h5>
       </div>
       <div class="col-lg-3 col-md-3 col-sm-12 text-center">
         <div class="img"  style="background-image:url(https://images.pexels.com/photos/4056463/pexels-photo-4056463.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500);">
         </div>
         <h5>Title 2</h5>
       </div>
       <div class="col-lg-3 col-md-3 col-sm-12 text-center">
         <div class="img" style="background-image:url(https://images.pexels.com/photos/221502/pexels-photo-221502.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500);">
         </div>
         <h5>Title 3</h5>
       </div>
       <div class="col-lg-3 col-md-3 col-sm-12 text-center">
         <div class="img" style="background-image:url(https://images.pexels.com/photos/1687845/pexels-photo-1687845.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500);">
         </div>
         <h5>Title 4</h5>
       </div>
     </div>
   </div>
</section>
<section class="finger-tips">
   <div class="container-fluid">
     <div class="row">
       <div class="col-lg-6 col-md-6 col-sm-12">
         <div class="selling-text">
             <h2>A whole world of freelance talent at your fingertips</h2>
             <ul>
                 <li><h6><span class="fit-icon" style="width: 24px; height: 24px; fill: rgb(122, 125, 133);"><svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"><path d="M8 1.75C4.54822 1.75 1.75 4.54822 1.75 8C1.75 11.4518 4.54822 14.25 8 14.25C11.4518 14.25 14.25 11.4518 14.25 8C14.25 4.54822 11.4518 1.75 8 1.75ZM0.25 8C0.25 3.71979 3.71979 0.25 8 0.25C12.2802 0.25 15.75 3.71979 15.75 8C15.75 12.2802 12.2802 15.75 8 15.75C3.71979 15.75 0.25 12.2802 0.25 8Z"></path><path d="M11.5303 5.46967C11.8232 5.76256 11.8232 6.23744 11.5303 6.53033L7.53033 10.5303C7.23744 10.8232 6.76256 10.8232 6.46967 10.5303L4.46967 8.53033C4.17678 8.23744 4.17678 7.76256 4.46967 7.46967C4.76256 7.17678 5.23744 7.17678 5.53033 7.46967L7 8.93934L10.4697 5.46967C10.7626 5.17678 11.2374 5.17678 11.5303 5.46967Z"></path></svg></span>The best for every budget</h6><p class="tbody-4">Find high-quality services at every price point. No hourly rates, just project-based pricing.</p></li>
                 <li><h6><span class="fit-icon" style="width: 24px; height: 24px; fill: rgb(122, 125, 133);"><svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"><path d="M8 1.75C4.54822 1.75 1.75 4.54822 1.75 8C1.75 11.4518 4.54822 14.25 8 14.25C11.4518 14.25 14.25 11.4518 14.25 8C14.25 4.54822 11.4518 1.75 8 1.75ZM0.25 8C0.25 3.71979 3.71979 0.25 8 0.25C12.2802 0.25 15.75 3.71979 15.75 8C15.75 12.2802 12.2802 15.75 8 15.75C3.71979 15.75 0.25 12.2802 0.25 8Z"></path><path d="M11.5303 5.46967C11.8232 5.76256 11.8232 6.23744 11.5303 6.53033L7.53033 10.5303C7.23744 10.8232 6.76256 10.8232 6.46967 10.5303L4.46967 8.53033C4.17678 8.23744 4.17678 7.76256 4.46967 7.46967C4.76256 7.17678 5.23744 7.17678 5.53033 7.46967L7 8.93934L10.4697 5.46967C10.7626 5.17678 11.2374 5.17678 11.5303 5.46967Z"></path></svg></span>Quality work done quickly</h6><p class="tbody-4">Find the right freelancer to begin working on your project within minutes.</p></li>
                 <li><h6><span class="fit-icon" style="width: 24px; height: 24px; fill: rgb(122, 125, 133);"><svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"><path d="M8 1.75C4.54822 1.75 1.75 4.54822 1.75 8C1.75 11.4518 4.54822 14.25 8 14.25C11.4518 14.25 14.25 11.4518 14.25 8C14.25 4.54822 11.4518 1.75 8 1.75ZM0.25 8C0.25 3.71979 3.71979 0.25 8 0.25C12.2802 0.25 15.75 3.71979 15.75 8C15.75 12.2802 12.2802 15.75 8 15.75C3.71979 15.75 0.25 12.2802 0.25 8Z"></path><path d="M11.5303 5.46967C11.8232 5.76256 11.8232 6.23744 11.5303 6.53033L7.53033 10.5303C7.23744 10.8232 6.76256 10.8232 6.46967 10.5303L4.46967 8.53033C4.17678 8.23744 4.17678 7.76256 4.46967 7.46967C4.76256 7.17678 5.23744 7.17678 5.53033 7.46967L7 8.93934L10.4697 5.46967C10.7626 5.17678 11.2374 5.17678 11.5303 5.46967Z"></path></svg></span>Protected payments, every time</h6><p class="tbody-4">Always know what you'll pay upfront. Your payment isn't released until you approve the work.</p></li>
                 <li><h6><span class="fit-icon" style="width: 24px; height: 24px; fill: rgb(122, 125, 133);"><svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"><path d="M8 1.75C4.54822 1.75 1.75 4.54822 1.75 8C1.75 11.4518 4.54822 14.25 8 14.25C11.4518 14.25 14.25 11.4518 14.25 8C14.25 4.54822 11.4518 1.75 8 1.75ZM0.25 8C0.25 3.71979 3.71979 0.25 8 0.25C12.2802 0.25 15.75 3.71979 15.75 8C15.75 12.2802 12.2802 15.75 8 15.75C3.71979 15.75 0.25 12.2802 0.25 8Z"></path><path d="M11.5303 5.46967C11.8232 5.76256 11.8232 6.23744 11.5303 6.53033L7.53033 10.5303C7.23744 10.8232 6.76256 10.8232 6.46967 10.5303L4.46967 8.53033C4.17678 8.23744 4.17678 7.76256 4.46967 7.46967C4.76256 7.17678 5.23744 7.17678 5.53033 7.46967L7 8.93934L10.4697 5.46967C10.7626 5.17678 11.2374 5.17678 11.5303 5.46967Z"></path></svg></span>24/7 support</h6><p class="tbody-4">Questions? Our round-the-clock support team is available to help anytime, anywhere.</p></li>
            </ul>
        </div>
       </div>
       <div class="col-lg-6 col-md-6 col-sm-12">
         <div class="img">
             <img src="images/banner.jpeg" />
         </div>
       </div>
     </div>
   </div>
</section>
<!-- APP PROCESS -->
<section class="app-section section-spacing pb-0">
   <div class="container">
     <h2 class="section-head text-center">Online Application Process</h2>
     <div class="row">
       <div class="col-lg-4 col-md-4 col-sm-12 text-center">
         <div class="img" style="background-image:url(https://images.pexels.com/photos/4067759/pexels-photo-4067759.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500);">
         </div>
         <h5>Title 1</h5>
       </div>
       <div class="col-lg-4 col-md-4 col-sm-12 text-center">
         <div class="img" style="background-image:url(https://images.pexels.com/photos/4056463/pexels-photo-4056463.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500);">
         </div>
         <h5>Title 2</h5>
       </div>
       <div class="col-lg-4 col-md-4 col-sm-12 text-center">
         <div class="img" style="background-image:url(https://images.pexels.com/photos/221502/pexels-photo-221502.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500);">
         </div>
         <h5>Title 3</h5>
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


@endsection

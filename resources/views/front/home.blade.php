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
              <span><b>{{$homeData->review_tag}}</b></span>
              @if($homeData->review_img_1 != "")
                <span class="star"><img src="{{ url('images/home/'.$homeData->review_img_1) }}" /></span>
              @endif
              <span><b>{{$homeData->review_detail}}</b></span>
              @if($homeData->review_img_2 != "")
                <span class="google-img"><img src="{{ url('images/home/'.$homeData->review_img_2) }}" /></span>
              @endif
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
           <h2 class="section-head text-center">{{$homeData->section_1_title}}</h2>
           <ul>
              <li>
                <div class="flag-main">
                 <div class="flag-image">
                    <img src="images/flags/1.png" />
                 </div>
                 <div class="cont">
                     <h6>Colombia</h6>
                     <a href="#">{{$homeData->section_button_name}}</a>
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
    <h2 class="section-head text-center">{{$section2Data->section_2_title}}</h2>
    <div class="row">
      @if($section2Data->img_1 != "" && $section2Data->title_1)
        <div class="col-lg-3 col-md-4 col-sm-12 text-center">
          <div class="img" style="background-image:url({{ url('images/home/'.$section2Data->img_1) }}?auto=compress&cs=tinysrgb&dpr=1&w=500);">
          </div>
          <h5>{{$section2Data->title_1}}</h5>
        </div>
     @endif
     @if($section2Data->img_2 != "" && $section2Data->title_2)
       <div class="col-lg-3 col-md-4 col-sm-12 text-center">
         <div class="img" style="background-image:url({{ url('images/home/'.$section2Data->img_2) }}?auto=compress&cs=tinysrgb&dpr=1&w=500);">
         </div>
         <h5>{{$section2Data->title_2}}</h5>
       </div>
    @endif
    @if($section2Data->img_3 != "" && $section2Data->title_3)
      <div class="col-lg-3 col-md-4 col-sm-12 text-center">
        <div class="img" style="background-image:url({{ url('images/home/'.$section2Data->img_3) }}?auto=compress&cs=tinysrgb&dpr=1&w=500);">
        </div>
        <h5>{{$section2Data->title_3}}</h5>
      </div>
   @endif
   @if($section2Data->img_4 != "" && $section2Data->title_4)
     <div class="col-lg-3 col-md-3 col-sm-12 text-center">
       <div class="img" style="background-image:url({{ url('images/home/'.$section2Data->img_4) }}?auto=compress&cs=tinysrgb&dpr=1&w=500);">
       </div>
       <h5>{{$section2Data->title_4}}</h5>
     </div>
  @endif
    </div>
  </div>
</section>
<section class="finger-tips">
   <div class="container-fluid">
     <div class="row">
       <div class="col-lg-6 col-md-6 col-sm-12">
         <div class="selling-text">
             <h2>{{$homeData->info_title}}</h2>
             <ul>
                 @if($homeData->title_1 != "" && $homeData->content_1)
                 <li><h6><span class="fit-icon" style="width: 24px; height: 24px; fill: rgb(122, 125, 133);"><svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"><path d="M8 1.75C4.54822 1.75 1.75 4.54822 1.75 8C1.75 11.4518 4.54822 14.25 8 14.25C11.4518 14.25 14.25 11.4518 14.25 8C14.25 4.54822 11.4518 1.75 8 1.75ZM0.25 8C0.25 3.71979 3.71979 0.25 8 0.25C12.2802 0.25 15.75 3.71979 15.75 8C15.75 12.2802 12.2802 15.75 8 15.75C3.71979 15.75 0.25 12.2802 0.25 8Z"></path><path d="M11.5303 5.46967C11.8232 5.76256 11.8232 6.23744 11.5303 6.53033L7.53033 10.5303C7.23744 10.8232 6.76256 10.8232 6.46967 10.5303L4.46967 8.53033C4.17678 8.23744 4.17678 7.76256 4.46967 7.46967C4.76256 7.17678 5.23744 7.17678 5.53033 7.46967L7 8.93934L10.4697 5.46967C10.7626 5.17678 11.2374 5.17678 11.5303 5.46967Z"></path></svg></span>{{$homeData->title_1}}</h6><p class="tbody-4">{{$homeData->content_1}}</p></li>
                 @endif
                 @if($homeData->title_2 != "" && $homeData->content_2)
                 <li><h6><span class="fit-icon" style="width: 24px; height: 24px; fill: rgb(122, 125, 133);"><svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"><path d="M8 1.75C4.54822 1.75 1.75 4.54822 1.75 8C1.75 11.4518 4.54822 14.25 8 14.25C11.4518 14.25 14.25 11.4518 14.25 8C14.25 4.54822 11.4518 1.75 8 1.75ZM0.25 8C0.25 3.71979 3.71979 0.25 8 0.25C12.2802 0.25 15.75 3.71979 15.75 8C15.75 12.2802 12.2802 15.75 8 15.75C3.71979 15.75 0.25 12.2802 0.25 8Z"></path><path d="M11.5303 5.46967C11.8232 5.76256 11.8232 6.23744 11.5303 6.53033L7.53033 10.5303C7.23744 10.8232 6.76256 10.8232 6.46967 10.5303L4.46967 8.53033C4.17678 8.23744 4.17678 7.76256 4.46967 7.46967C4.76256 7.17678 5.23744 7.17678 5.53033 7.46967L7 8.93934L10.4697 5.46967C10.7626 5.17678 11.2374 5.17678 11.5303 5.46967Z"></path></svg></span>{{$homeData->title_2}}</h6><p class="tbody-4">{{$homeData->content_2}}</p></li>
                 @endif
                 @if($homeData->title_3 != "" && $homeData->content_3)
                 <li><h6><span class="fit-icon" style="width: 24px; height: 24px; fill: rgb(122, 125, 133);"><svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"><path d="M8 1.75C4.54822 1.75 1.75 4.54822 1.75 8C1.75 11.4518 4.54822 14.25 8 14.25C11.4518 14.25 14.25 11.4518 14.25 8C14.25 4.54822 11.4518 1.75 8 1.75ZM0.25 8C0.25 3.71979 3.71979 0.25 8 0.25C12.2802 0.25 15.75 3.71979 15.75 8C15.75 12.2802 12.2802 15.75 8 15.75C3.71979 15.75 0.25 12.2802 0.25 8Z"></path><path d="M11.5303 5.46967C11.8232 5.76256 11.8232 6.23744 11.5303 6.53033L7.53033 10.5303C7.23744 10.8232 6.76256 10.8232 6.46967 10.5303L4.46967 8.53033C4.17678 8.23744 4.17678 7.76256 4.46967 7.46967C4.76256 7.17678 5.23744 7.17678 5.53033 7.46967L7 8.93934L10.4697 5.46967C10.7626 5.17678 11.2374 5.17678 11.5303 5.46967Z"></path></svg></span>{{$homeData->title_3}}</h6><p class="tbody-4">{{$homeData->content_3}}</p></li>
                 @endif
                 @if($homeData->title_4 != "" && $homeData->content_4)
                 <li><h6><span class="fit-icon" style="width: 24px; height: 24px; fill: rgb(122, 125, 133);"><svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"><path d="M8 1.75C4.54822 1.75 1.75 4.54822 1.75 8C1.75 11.4518 4.54822 14.25 8 14.25C11.4518 14.25 14.25 11.4518 14.25 8C14.25 4.54822 11.4518 1.75 8 1.75ZM0.25 8C0.25 3.71979 3.71979 0.25 8 0.25C12.2802 0.25 15.75 3.71979 15.75 8C15.75 12.2802 12.2802 15.75 8 15.75C3.71979 15.75 0.25 12.2802 0.25 8Z"></path><path d="M11.5303 5.46967C11.8232 5.76256 11.8232 6.23744 11.5303 6.53033L7.53033 10.5303C7.23744 10.8232 6.76256 10.8232 6.46967 10.5303L4.46967 8.53033C4.17678 8.23744 4.17678 7.76256 4.46967 7.46967C4.76256 7.17678 5.23744 7.17678 5.53033 7.46967L7 8.93934L10.4697 5.46967C10.7626 5.17678 11.2374 5.17678 11.5303 5.46967Z"></path></svg></span>{{$homeData->title_4}}</h6><p class="tbody-4">{{$homeData->content_4}}</p></li>
                 @endif
            </ul>
        </div>
       </div>
       <div class="col-lg-6 col-md-6 col-sm-12">
         @if($homeData->info_img)
         <div class="img">
             <img src="{{ url('images/home/'.$homeData->info_img) }}" />
         </div>
         @endif
       </div>
     </div>
   </div>
</section>
<!-- APP PROCESS -->
<section class="app-section section-spacing pb-0">
   <div class="container">
     <h2 class="section-head text-center">{{$homeData->section_3_title}}</h2>
     <div class="row">
       @if($homeData->img_1 != "" && $homeData->title_1)
         <div class="col-lg-4 col-md-4 col-sm-12 text-center">
           <div class="img" style="background-image:url({{ url('images/home/'.$homeData->img_1) }}?auto=compress&cs=tinysrgb&dpr=1&w=500);">
           </div>
           <h5>{{$homeData->title_1}}</h5>
         </div>
      @endif
      @if($homeData->img_2 != "" && $homeData->title_2)
        <div class="col-lg-4 col-md-4 col-sm-12 text-center">
          <div class="img" style="background-image:url({{ url('images/home/'.$homeData->img_2) }}?auto=compress&cs=tinysrgb&dpr=1&w=500);">
          </div>
          <h5>{{$homeData->title_2}}</h5>
        </div>
     @endif
     @if($homeData->img_3 != "" && $homeData->title_3)
       <div class="col-lg-4 col-md-4 col-sm-12 text-center">
         <div class="img" style="background-image:url({{ url('images/home/'.$homeData->img_3) }}?auto=compress&cs=tinysrgb&dpr=1&w=500);">
         </div>
         <h5>{{$homeData->title_3}}</h5>
       </div>
    @endif
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


@endsection

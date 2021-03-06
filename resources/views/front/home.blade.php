@extends('front.layouts.app')

@section('content')
<section class="cover-section">
   <section class="first-section">
      <div class="container">
         <div class="row">
            <div class="col-md-7 col-sm-12">
               <div class="banner">
                  <img src="{{env('IMG_URL')}}/assets/images/feature.png">
               </div>
            </div>
            <div class="col-md-5 col-sm-12">
               <div class="banner-cont">
                  <h3>Improve Your Skill Anytime And Everywhere</h3>
                  <p>Get started with just your name and your email adress . It’s as simple as that.</p>
                  <button class="btn get-btn" type="submit">Get Started </button>
               </div>
            </div>
         </div>
      </div>
   </section>

</section>

@endsection

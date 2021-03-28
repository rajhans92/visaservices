@extends('front.layouts.app')

@section('content')

<section class="error-section">
  <div class="container">
     <div class="row">
     <div class="col-md-1"></div>
    <div class="col-md-5 col-middle">
      <h1 class="text-jumbo text-ginormous hide-sm">Oops!</h1>
      <h2>We can't seem to find the page you're looking for.</h2>
      <h6>Error code: 404</h6>
      <ul class="list-unstyled">
        <li>Here are some helpful links instead:</li>
        <li><a href="/s/all" class="link-404">Visa</a></li>
        <li><a href="/help" class="link-404">About Us</a></li>
        <li><a href="/help/getting-started/how-to-travel" class="link-404">Contact Us</a></li>
      </ul>
    </div>
    <div class="col-md-5 col-middle text-center">
      <img src="https://i.pinimg.com/originals/4f/a2/3e/4fa23e83f695edd8881221896ef44c39.jpg"  height="428" class="hide-sm" alt="Girl has dropped her ice cream.">
    </div>
  </div>
</div>
            </div>
            </div>
            </div>
</section>

@endsection

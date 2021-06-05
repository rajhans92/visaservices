@extends('front.layouts.app')

@section('styles')

<style>
.ivc-shadow {
    border: 0 solid #f8fafc;
    box-shadow: 0 4px 8px 0 rgb(0 0 0 / 12%), 0 2px 4px 0 rgb(0 0 0 / 8%);
    border-radius: .365rem;
}
.ivc-blog-hedding{
padding: 24px 20px;
}
.accordion-button::after {
    background-image: none !important;
    content: "\f054";
    font-family: 'Font Awesome 5 Free';
}
.faq-section .accordion-button {
    font-weight: 600;
    background: none !important;
    border: 0 !important;
    border-radius: 0 !important;
    padding: 10px 32px;
    padding-right: 16px;
    box-shadow: none !important;
}
</style>
@endsection

@section('content')
<!-- Header -->
<section class="faq-section">
  <div class="container">
    <div class="row justify-center">
      <div class="col-sm-10">
        <h1 class="inner-head">Blogs</h1>
        <div class="faqs-select">
          <div class="text">
              Blog Categories
          </div>
          <div class="select-country-dropdown">
              <select id="category">
                  <option>Choose Category</option>
                  @foreach($blogCategory as $key => $val)
                    <option value="{{$val->id}}" data="{{$val->id}}">{{$val->name}}</option>
                  @endforeach
              </select>
          </div>
        </div>
        <div class="row">
            <div class="col-sm-8">
                <div class="accordion ivc-shadow" id="accordionExample">
                  <div class="ivc-blog-hedding">
                    <h2>
                      Recent Visa Blog Articles
                    </h2>

                  </div>
                  <hr>
                  @foreach($data[$blogCategory[0]->id] as $key => $val)
                      <div class="accordion-item">
                        <h2 class="accordion-header">
                          <a class="accordion-button collapsed" href="{{url($val['visa_url'])}}" >
                           {{$val['heading']}}
                          </a>
                        </h2>

                        </div>
                        <hr>
                  @endforeach
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
                   <label for="locationfrom" class="form-label">Where am I From?</label>
                   <select class="form-select" aria-label="Where am I From?" id="firstDropdown">
                     @foreach($countryData as $key => $val)
                       <option value="{{$val->country_name}}" data="{{$val->country_name}}">{{$val->country_name}} ({{$val->country_code}})</option>
                     @endforeach
                  </select>
                 </div>
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
  let mainData = <?php echo json_encode($data); ?>;

  $("#applyBtn").click(function(){
    let url = $("#secondDropdown").val();

    var d = new Date();
    d.setTime(d.getTime() + (2*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();

    let goname = "go_country";
    let fromname = "from_country";
    let govalue = $("#secondDropdown option").filter(":selected").attr("data");
    let fromvalue = $("#firstDropdown option").filter(":selected").attr("data");

    document.cookie = fromname + "=" + fromvalue + ";" + expires + ";path=/";
    document.cookie = goname + "=" + govalue + ";" + expires + ";path=/";
    if(url.length > 0)
      window.location = window.location.origin + '/'+ url;

  });
  $("#category").change(function(){
       let id = $(this).val();
       if(id.length > 0){
         let temp = '<div class="ivc-blog-hedding"> <h2> Recent Visa Blog Articles </h2> </div> <hr>';
       for (var key in mainData[id]) {
          temp += '<div class="accordion-item"> <h2 class="accordion-header"> <a class="accordion-button collapsed" href="'+window.location.origin+'/'+mainData[id][key]['visa_url']+'" >'+mainData[id][key]['heading']+'</a> </h2> </div> <hr>';
       }
       $("#accordionExample").html(temp);
     }

  });
});
</script>
@endsection

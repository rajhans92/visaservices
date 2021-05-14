@extends('front.layouts.app')

@section('title', $servicesData->meta_title)
@section('meta_keywords', $servicesData->meta_keywords)
@section('meta_description', $servicesData->meta_description)

@section('content')

<section class="register-section blogs-section">

  <div class="inner-content">
      <div class="right-content">
          <h1>{{$servicesData->services_heading}}</h1>
          <p class="slogan">{!! $servicesData->services_content_1 !!}</p>
          @if($servicesData->services_landing_img != "")
            <div class="_img">
              <img src="{{url('images/services/'.$servicesData->services_landing_img)}}" />
            </div>
          @endif
          <div class="_des">
          <p>{!! $servicesData->services_content_2 !!}</p>
          @if($isAvailable)
            @if(isset($servicesData->payment_method) && $servicesData->payment_method == 1)
              <a href="{{url('/services-online/'.$servicesData->visa_url)}}">{{$servicesData->services_main_button}}</a>
            @else
              <button class="btn" data-toggle="modal" data-target="#contactModal"  onClick="contactBox()"  style="margin-top:10px;">Contact Us</button>
            @endif
          @endif
         </div>
         <h1 style="margin-top: 80px;">{{$servicesData->services_faqs}}</h1>
         <div class="accordion faq-section" id="accordionExample">
           <?php
            $faq = [];
           ?>
           @foreach($servicesFaqs as $key => $val)
             <div class="accordion-item">
               <h2 class="accordion-header" id="heading{{$val->id}}">
                 <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$val->id}}" aria-expanded="false" aria-controls="collapseOne">
                  {{$val->question}}
                 </button>
               </h2>
               <div id="collapse{{$val->id}}" class="accordion-collapse collapse" aria-labelledby="heading{{$val->id}}" data-bs-parent="#accordionExample">
                 <div class="accordion-body">
                  {!! $val->answer !!}
                </div>
               </div>
             </div>
             <?php
              $faq[] = [
                 "@type"=>"Question",
                 "name"=>$val->question,
                 "acceptedAnswer"=>[
                   "@type"=>"Answer",
                   "text"=> $val->answer
                 ]
              ];
             ?>
           @endforeach
         </div>
      </div>
      @if($isAvailable && count($allServicesData))
      <div class="left-sidebar">
          <div class="box-content">
             <div class="form-group">
                 <label>{{$servicesData->services_nationality_title}}</label>
                 <select id="nationality" value="">
                   @foreach($allServicesData as $key => $val)
                     <option value="{{$key}}" >{{$key}}</option>
                   @endforeach
                 </select>
             </div>
             <div class="fees-box days-box">
                 <span><img src="images/rush.png">{{env('APP_VISA_TYPE')}}:</span>
                 <span><b>{{isset($servicesDurationData[strtolower(env('APP_VISA_TYPE'))]) ? $servicesDurationData[strtolower(env('APP_VISA_TYPE'))] : ""}}</b></span>
            </div>
            @if(isset($servicesData->payment_method) && $servicesData->payment_method == 1)
             <a href="{{url('/services-online/'.$servicesData->visa_url)}}">{{$servicesData->services_main_button}}</a>
            @else
              <button class="btn" data-toggle="modal" data-target="#contactModal"  onClick="contactBox()"  style="margin-top:10px;">Contact Us</button>
            @endif
          </div>
            @if($servicesData->is_price_show == 1)
            <h5 class="top-articles-heading">{{$servicesData->services_popular_title}}</h5>
            <ul class="top-articles" id="currency">
               <?php $count = 1; ?>
                @foreach($allServicesData[$default_country]['USD'] as $key => $val)
                <li>
                  <a>{{$key}}
                    <select class="currency" value="USD">
                      @foreach($allServicesData[$default_country] as $key1 => $val1)
                        <option value="{{$key1}}" table="{{$key}}" count="{{$count}}" {{$key1 == "USD" ? "selected" : ""}}>{{$key1}}</option>
                      @endforeach
                    </select>
                    <span id="{{$count++}}">{{$val}}</span>
                  </a>
                </li>
                @endforeach
            </ul>
            @endif
      </div>
      @endif
  </div>

</section>
<!-- Whatsapp Btn -->
@if(isset($servicesData->whatsapp_status) && $servicesData->whatsapp_status == 1 && isset($servicesData->whatsapp_number) && $servicesData->whatsapp_number != "")
  <div class="whatsapp-btn">
      <a href="https://api.whatsapp.com/send?phone={{$servicesData->whatsapp_number}}&text={{$servicesData->whatsapp_text}}"><i class="fab fa-whatsapp"></i></a>
  </div>
@endif
@if(isset($servicesData->call_status) && $servicesData->call_status == 1 && isset($servicesData->call_number) && $servicesData->call_number != "")
  <!-- <div class="whatsapp-btn">
      <a href="tel:9876543210"><i class="fab fa-call"></i></a>
  </div> -->
@endif
<!-- CONTACT MODAL -->
<div class="modal fade" id="contactModal" tabindex="-1" role="dialog" aria-labelledby="contactModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Contact Us</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick="closeModal()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body contact-form">
        <form>
            <div class="from-group">
                <label>Name</label>
                <input type="text" required  id="name"/>
            </div>
            <div class="from-group">
                <label>Email</label>
                <input type="email" required id="email"/>
            </div>
            <div class="from-group">
                <label>Mobile</label>
                <input type="text"  maxlength="14" id="mobile"/>
            </div>
            <div class="from-group">
                <label>Message</label>
                <textarea rows="1" columns="4" id="msg"></textarea>
            </div>
             <div class="from-group">
                 <input type="button" id="submitBtn" class="btn" value="Submit">
            </div>
            <div class="from-group" id="msgSection">

            </div>
        </form>
      </div>
    </div>
  </div>
</div>

@stop
@section('javascript')

<script type="text/javascript">
function contactBox() {
  $('#contactModal').modal('show');
}
function closeModal() {
  $('#contactModal').modal('hide');
}
let datSet = <?php echo json_encode($allServicesData); ?>;
let faq = <?php echo json_encode($faq); ?>;
let default_country = '{{$default_country}}';
var d = new Date();
d.setTime(d.getTime() + (2*24*60*60*1000));
var expires = "expires="+ d.toUTCString();

document.cookie = "nationality" + "=" + default_country + ";" + expires + ";path=/";
console.log("before = ",document.cookie);
$(function(){
  $("#submitBtn").click(function(){
        let name = $("#name").val();
        let email = $("#email").val();
        let mobile = $("#mobile").val();
        let msg = $("#msg").val();
        if(name.length > 0 && email.length > 0 && mobile.length > 0 && msg.length > 0){
          $.ajax({
            type: "POST",
            url: '{{url("/service-contact-us")}}',
            data: {
              "_token": "{{ csrf_token() }}",
              "name":name,"email":email,"mobile":mobile,"msg":msg,"country":default_country
            },
            success: function(data) {
              returnJsonData = JSON.parse(data);
              if(returnJsonData.status == true){
                $('#contactModal').modal('hide');
                  $("#name").val("");
                  $("#email").val("");
                  $("#mobile").val("");
                  $("#msg").val("");
                  alert("Thank You. We contact You Soon.");
              }else {
                $("#msgSection").html('<label style="text-align:center;color:red;">Something went wrong!</label>');
              }
            }
          });
        }else{
          $("#msgSection").html('<label style="text-align:center;color:red;">All fields are required.</label>');
        }
  });
  $(document).on("change","#nationality",function(){
     let nationality = $(this).val();
     if(nationality.length > 0){
       let strTemp = "";
       let count = 1;
       default_country = nationality;
        for (var key in datSet[default_country]['USD']) {
          let strTemp1 = "";
          for (var key1 in datSet[default_country]) {
              strTemp1 += "<option value="+key1+" "+(key1 == 'USD'? 'selected' : '')+" table='"+key+"' count='"+count+"' >"+key1+"</option>";
          }
          strTemp += "<li><a>"+key+'<select class="currency" value="USD">'+strTemp1+'</select><span id="'+(count++)+'">'+datSet[default_country]['USD'][key]+'</a></li>';
        }
        $("#currency").html(strTemp);

        document.cookie = "nationality" + "=" + default_country + ";" + expires + ";path=/";
        console.log("after = ",document.cookie);

     }
  });
  $(document).on("change",".currency",function(){
     let currency = $(this).val();
     let nationality = $("#nationality").val();
     let table = $('option:selected', this).attr('table');
     let count = $('option:selected', this).attr('count');
     if(nationality.length > 0 && currency.length > 0 && table.length > 0 && count.length > 0){
        $("#"+count).text(datSet[default_country][currency][table]);
     }
  });
});

</script>
<script type="application/ld+json">
   {
       "@context":"https://schema.org",
       "@type":"FAQPage",
       "mainEntity":faq

   }
</script>
@endsection

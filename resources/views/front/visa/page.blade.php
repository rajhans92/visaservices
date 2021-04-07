@extends('front.layouts.app')

@section('title', $visaData->meta_title)
@section('meta_keywords', $visaData->meta_keywords)
@section('meta_description', $visaData->meta_description)

@section('content')

<section class="register-section blogs-section">

  <div class="inner-content">
      <div class="right-content">
          <h1>{{$visaData->visa_heading}}</h1>
          <p class="slogan">{!! $visaData->visa_content_1 !!}</p>
          @if($visaData->visa_landing_img != "")
            <div class="_img">
              <img src="{{url('images/visa/'.$visaData->visa_landing_img)}}" />
            </div>
          @endif
          <div class="_des">
          <p>{!! $visaData->visa_content_2 !!}</p>
          @if($isAvailable)
            @if(isset($visaData->payment_method) && $visaData->payment_method == 1)
              <a href="{{url('/apply-online/'.$visaData->visa_url)}}">{{$visaData->visa_main_button}}</a>
            @else
              <button class="btn" data-toggle="modal" data-target="#contactModal"  onClick="contactBox()"  style="margin-top:10px;">Contact Us</button>
            @endif
          @endif
         </div>
         <h1 style="margin-top: 80px;">{{$visaData->visa_faqs}}</h1>
         <div class="accordion faq-section" id="accordionExample">
           <?php
            $faq = [];
           ?>
           @foreach($visaFaqs as $key => $val)
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
      @if($isAvailable && isset($allVisaData[strtolower($default_nationality)]))
      <div class="left-sidebar">
          <div class="box-content">
             <div class="form-group">
                 <label>{{$visaData->visa_nationality_title}}</label>
                 <select id="nationality" value={{$default_nationality}}>
                   @foreach($allVisaData as $key => $val)
                     <option value="{{$key}}" {{$key == $default_nationality ? 'selected' : ''}}>{{$key}}</option>
                   @endforeach
                 </select>
             </div>
              <div class="fees-box days-box">
                  <span><img src="images/rush.png">{{$visaData->visa_type_title}}:</span>
                  <span><b>{{$visaProcessingType->duration}} {{$visaProcessingType->duration_type}}</b></span>
            </div>
            @if(isset($visaData->payment_method) && $visaData->payment_method == 1)
             <a href="{{url('/apply-online/'.$visaData->visa_url)}}">{{$visaData->visa_main_button}}</a>
            @else
              <button class="btn" data-toggle="modal" data-target="#contactModal"  onClick="contactBox()"  style="margin-top:10px;">Contact Us</button>
            @endif
          </div>
          <h5 class="top-articles-heading">{{$visaData->visa_popular_title}}</h5>
          <ul class="top-articles" id="currency">
             <?php $count = 1; ?>
              @foreach($allVisaData[strtolower($default_nationality)] as $key => $val)
              <li><a>{{$key}}
                <select class="currency" value="USD">
                  @foreach($val as $key1 => $val1)
                    <option value="{{$key1}}" table="{{$key}}" count="{{$count}}" {{$key1 == "USD" ? "selected" : ""}}>{{$key1}}</option>
                  @endforeach
                </select>
                <span id="{{$count++}}">{{$val['USD'][strtolower(env('APP_VISA_TYPE'))]}}</span></a></li>
              @endforeach
          </ul>
      </div>
      @endif
  </div>

</section>
<!-- Whatsapp Btn -->
@if(isset($visaData->whatsapp_status) && $visaData->whatsapp_status == 1 && isset($visaData->whatsapp_number) && $visaData->whatsapp_number != "")
  <div class="whatsapp-btn">
      <a href="tel:https://api.whatsapp.com/send?phone={{$visaData->whatsapp_number}}&text=Hi, I contacted you Through your website."><i class="fab fa-whatsapp"></i></a>
  </div>
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
let datSet = <?php echo json_encode($allVisaData); ?>;
let faq = <?php echo json_encode($faq); ?>;
$(function(){
  $("#submitBtn").click(function(){
        let name = $("#name").val();
        let email = $("#email").val();
        let mobile = $("#mobile").val();
        let msg = $("#msg").val();
        let visa_country = "{{$default_visa}}";
        let nationality = "{{$default_nationality}}";
        if(name.length > 0 && email.length > 0 && mobile.length > 0 && msg.length > 0){
          $.ajax({
            type: "POST",
            url: '{{url("/apply-contact-us")}}',
            data: {
              "_token": "{{ csrf_token() }}",
              "name":name,"email":email,"mobile":mobile,"msg":msg,"visa_country":visa_country,"nationality":nationality
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
        for (var key in datSet[nationality.toLowerCase()]) {
          let strTemp1 = "";
          for (var key1 in datSet[nationality.toLowerCase()][key]) {
              strTemp1 += "<option value="+key1+" "+(key1 == 'USD'? 'selected' : '')+" table='"+key+"' count='"+count+"' >"+key1+"</option>";
          }
          strTemp += "<li><a>"+key+'<select class="currency" value="USD">'+strTemp1+'</select><span id="'+(count++)+'">'+datSet[nationality.toLowerCase()][key]['USD']['{{env("APP_VISA_TYPE")}}'.toLowerCase()]+'</a></li>';
        }
        $("#currency").html(strTemp);
     }
  });
  $(document).on("change",".currency",function(){
     let currency = $(this).val();
     let nationality = $("#nationality").val();
     let table = $('option:selected', this).attr('table');
     let count = $('option:selected', this).attr('count');
     if(nationality.length > 0 && currency.length > 0 && table.length > 0 && count.length > 0){
        $("#"+count).text(datSet[nationality.toLowerCase()][table][currency]['{{env("APP_VISA_TYPE")}}'.toLowerCase()]);
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

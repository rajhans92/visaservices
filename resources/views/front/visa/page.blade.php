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
          @if($isAvailable)
            <a href="{{url('/apply-online/'.$visaData->country_name)}}">{{$visaData->visa_main_button}}</a>
          @endif
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
      @if($isAvailable)
      <div class="left-sidebar">
          <div class="box-content">
             <div class="form-group">
                 <label>{{$visaData->visa_nationality_title}}</label>
                 <select id="nationality" value={{$visaData->country_name}}>
                   @foreach($allVisaData as $key => $val)
                     <option value="{{$key}}" {{$key == $visaData->country_name ? 'selected' : ''}}>{{$key}}</option>
                   @endforeach
                 </select>
             </div>
              <div class="fees-box days-box">
                  <span><img src="images/rush.png">{{$visaData->visa_type_title}}:</span>
                  <span><b>{{$visaProcessingType->duration}} {{$visaProcessingType->duration_type}}</b></span>
            </div>
             <a href="{{url('/apply-online/'.$visaData->country_name)}}">{{$visaData->visa_main_button}}</a>
          </div>
          <h5 class="top-articles-heading">{{$visaData->visa_popular_title}}</h5>
          <ul class="top-articles" id="currency">
             <?php $count = 1; ?>
              @foreach($allVisaData[strtolower($visaData->country_name)] as $key => $val)
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

<!-- <div class="mobile-apply-btn">
    <span><b>2000</b> /Applicant</span>
    <button class="btn">Apply</button>
</div> -->


@stop
@section('javascript')

<script type="text/javascript">
let datSet = <?php echo json_encode($allVisaData); ?>;
$(function(){
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
    console.log($(this).val());
     let currency = $(this).val();
     let nationality = $("#nationality").val();
     let table = $('option:selected', this).attr('table');
     let count = $('option:selected', this).attr('count');
     console.log(count,table,currency,nationality);
     if(nationality.length > 0 && currency.length > 0 && table.length > 0 && count.length > 0){
        $("#"+count).text(datSet[nationality.toLowerCase()][table][currency]['{{env("APP_VISA_TYPE")}}'.toLowerCase()]);
     }
  });
});

</script>
@endsection

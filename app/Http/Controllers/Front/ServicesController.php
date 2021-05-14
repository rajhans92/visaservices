<?php

namespace App\Http\Controllers\Front;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Mail\ApplyNotificationMail;

class ServicesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function pages(Request $request)
    {

      $uri = $request->path();
      $servicesData = DB::table('services_pages')
      ->select(
        'services_pages.id as id',
        'services_pages.services_name as services_name',
        'services_pages.services_heading as services_heading',
        'services_pages.services_landing_img as services_landing_img',
        'services_pages.services_content_1 as services_content_1',
        'services_pages.services_content_2 as services_content_2',
        'services_pages.services_main_button as services_main_button',
        'services_pages.services_faqs as services_faqs',
        'services_pages.payment_method as payment_method',
        'services_pages.services_nationality_title as services_nationality_title',
        'services_pages.services_type_title as services_type_title',
        'services_pages.services_popular_title as services_popular_title',
        'services_pages.whatsapp_number as whatsapp_number',
        'services_pages.whatsapp_status as whatsapp_status',
        'services_pages.call_number as call_number',
        'services_pages.call_status as call_status',
        'services_pages.meta_title as meta_title',
        'services_pages.meta_description as meta_description',
        'services_pages.meta_keywords as meta_keywords',
        'services_pages.standard_time_duration as standard_time_duration',
        'services_pages.rush_time_duration as rush_time_duration',
        'services_pages.express_time_duration as express_time_duration',
        'services_pages.whatsapp_text as whatsapp_text',
        'services_pages.is_price_show as is_price_show',
        'route_visa.visa_url as visa_url'
        )
      ->where('services_pages.language_id',env('APP_LANG'))
      ->where('route_visa.visa_url',$uri)
      ->where('route_visa.type_of_url',"services")
      ->join("route_visa","route_visa.visa_id","=","services_pages.id")
      ->first();

      $servicesFaqs = DB::table('services_faqs')
      ->where('services_faqs.language_id',env('APP_LANG'))
      ->where('services_faqs.services_id',$servicesData->id)
      ->get();

      $allServicesData = [];
      $currencyRate = DB::table('currency_rate')->where('language_id',env('APP_LANG'))->get();

      $servicesDurationData = [
        "standard" => $servicesData->standard_time_duration,
        "rush" => $servicesData->rush_time_duration,
        "express" => $servicesData->express_time_duration,
      ];

      $tempServicesTable = DB::table('services_country_price')
                      ->where('services_id',$servicesData->id)
                      ->where('language_id',env('APP_LANG'))
                      ->get();

      foreach ($tempServicesTable as $key => $value) {

        $allServicesData[strtolower($value->nationality)]['USD']['standard'] = sprintf("%.2f",$value->standard_usd_price);
        $allServicesData[strtolower($value->nationality)]['USD']['rush'] = sprintf("%.2f",$value->rush_usd_price);
        $allServicesData[strtolower($value->nationality)]['USD']['express'] = sprintf("%.2f",$value->express_usd_price);

        foreach ($currencyRate as $key2 => $value2) {

          $allServicesData[strtolower($value->nationality)][strtoupper($value2->code)]['standard'] = sprintf("%.2f",$value2->rate * $value->standard_usd_price);

          $allServicesData[strtolower($value->nationality)][strtoupper($value2->code)]['rush'] = sprintf("%.2f",$value2->rate * $value->rush_usd_price);

          $allServicesData[strtolower($value->nationality)][strtoupper($value2->code)]['express'] = sprintf("%.2f",$value2->rate * $value->express_usd_price);


        }
      }
      $default_country = "";
      if(count($allServicesData)){
        $default_country = array_keys($allServicesData);
        $default_country = isset($default_country[0]) ? $default_country[0] : "";
      }
      // exit(print_r($allServicesData[$default_country]));
      $isAvailable = false;
      if(isset($tempServicesTable[0])){
        $isAvailable = true;
      }
      return view('front.services.page',compact('servicesData','servicesFaqs','servicesDurationData','allServicesData','isAvailable','default_country'));

    }

    public function applyOnline($url)
    {
            $default_nationality = isset($_COOKIE['nationality']) ? strtolower($_COOKIE['nationality']) : "";

            $servicesData = DB::table('services_pages')
            ->select(
              'services_pages.id as id',
              'services_pages.services_name as services_name',
              'services_pages.services_heading as services_heading',
              'services_pages.services_landing_img as services_landing_img',
              'services_pages.services_content_1 as services_content_1',
              'services_pages.services_content_2 as services_content_2',
              'services_pages.services_main_button as services_main_button',
              'services_pages.services_faqs as services_faqs',
              'services_pages.payment_method as payment_method',
              'services_pages.services_nationality_title as services_nationality_title',
              'services_pages.services_type_title as services_type_title',
              'services_pages.services_popular_title as services_popular_title',
              'services_pages.whatsapp_number as whatsapp_number',
              'services_pages.whatsapp_status as whatsapp_status',
              'services_pages.call_number as call_number',
              'services_pages.call_status as call_status',
              'services_pages.is_govt_apply as is_govt_apply',
              'services_pages.meta_title as meta_title',
              'services_pages.meta_description as meta_description',
              'services_pages.meta_keywords as meta_keywords',
              'services_pages.standard_time_duration as standard_time_duration',
              'services_pages.rush_time_duration as rush_time_duration',
              'services_pages.express_time_duration as express_time_duration',
              'route_visa.visa_url as visa_url'
              )
            ->where('services_pages.language_id',env('APP_LANG'))
            ->where('route_visa.visa_url',$url)
            ->where('route_visa.type_of_url',"services")
            ->join("route_visa","route_visa.visa_id","=","services_pages.id")
            ->first();

            $servicesFaqs = DB::table('services_faqs')
            ->where('services_faqs.language_id',env('APP_LANG'))
            ->where('services_faqs.services_id',$servicesData->id)
            ->get();

            $allServicesData = [];
            $default_currency = env('APP_DEFAULT_CURRENCY');
            $currencyRate = DB::table('currency_rate')->where('language_id',env('APP_LANG'))->get();

            $tempServicesTable = DB::table('services_country_price')
                            ->where('services_id',$servicesData->id)
                            ->where('language_id',env('APP_LANG'))
                            ->get();
            $countryName = DB::table('country')
                                  ->where('country.language_id',env('APP_LANG'))
                                  ->get();
            foreach ($tempServicesTable as $key => $value) {

              $allServicesData[strtolower($value->nationality)]['USD']['standard'] = sprintf("%.2f",$value->standard_usd_price);
              $allServicesData[strtolower($value->nationality)]['USD']['rush'] = sprintf("%.2f",$value->rush_usd_price);
              $allServicesData[strtolower($value->nationality)]['USD']['express'] = sprintf("%.2f",$value->express_usd_price);
              $allServicesData[strtolower($value->nationality)]['USD']['govt'] = sprintf("%.2f",$value->govt_fee);

              foreach ($currencyRate as $key2 => $value2) {

                $allServicesData[strtolower($value->nationality)][strtoupper($value2->code)]['standard'] = sprintf("%.2f",$value2->rate * $value->standard_usd_price);

                $allServicesData[strtolower($value->nationality)][strtoupper($value2->code)]['rush'] = sprintf("%.2f",$value2->rate * $value->rush_usd_price);

                $allServicesData[strtolower($value->nationality)][strtoupper($value2->code)]['express'] = sprintf("%.2f",$value2->rate * $value->express_usd_price);

                $allServicesData[strtolower($value->nationality)][strtoupper($value2->code)]['govt'] = sprintf("%.2f",$value2->rate * $value->govt_fee);

              }
            }

            $default_country = "";
            if(count($allServicesData)){
              $default_country = array_keys($allServicesData);
              $default_country = isset($default_country[0]) ? $default_country[0] : "";
            }

        return view('front.services.calculator',compact('allServicesData','default_nationality','servicesData','countryName','default_country','default_currency','currencyRate'));

    }

    public function applyOnlineSave(Request $request){
        // exit(print_r($request->all()));
        $total_payment = 0.0;
        $allServicesData = [];
        $default_currency = env('APP_DEFAULT_CURRENCY');
        $currencyRate = DB::table('currency_rate')->where('language_id',env('APP_LANG'))->get();

        $servicesData = DB::table('services_pages')
             ->select(
               'services_pages.id as id',
               'services_pages.services_name as services_name',
               'services_pages.services_heading as services_heading',
               'services_pages.services_landing_img as services_landing_img',
               'services_pages.services_content_1 as services_content_1',
               'services_pages.services_content_2 as services_content_2',
               'services_pages.services_main_button as services_main_button',
               'services_pages.services_faqs as services_faqs',
               'services_pages.payment_method as payment_method',
               'services_pages.services_nationality_title as services_nationality_title',
               'services_pages.services_type_title as services_type_title',
               'services_pages.services_popular_title as services_popular_title',
               'services_pages.whatsapp_number as whatsapp_number',
               'services_pages.whatsapp_status as whatsapp_status',
               'services_pages.call_number as call_number',
               'services_pages.call_status as call_status',
               'services_pages.is_govt_apply as is_govt_apply',
               'services_pages.meta_title as meta_title',
               'services_pages.meta_description as meta_description',
               'services_pages.standard_time_duration as standard_time_duration',
               'services_pages.rush_time_duration as rush_time_duration',
               'services_pages.express_time_duration as express_time_duration',
               'services_pages.meta_keywords as meta_keywords'
               )
             ->where('services_pages.language_id',env('APP_LANG'))
             ->where('services_pages.services_name',$request['services'])
             ->first();

        $tempServicesTable = DB::table('services_country_price')
                        ->where('services_id',$servicesData->id)
                        ->where('language_id',env('APP_LANG'))
                        ->get();
        $countryName = DB::table('country')
                              ->where('country.language_id',env('APP_LANG'))
                              ->get();



        foreach ($tempServicesTable as $key => $value) {

          $allServicesData[strtolower($value->nationality)]['USD']['standard']= sprintf("%.2f",$value->standard_usd_price);
          $allServicesData[strtolower($value->nationality)]['USD']['rush']    = sprintf("%.2f",$value->rush_usd_price);
          $allServicesData[strtolower($value->nationality)]['USD']['express'] = sprintf("%.2f",$value->express_usd_price);
          $allServicesData[strtolower($value->nationality)]['USD']['govt']    = sprintf("%.2f",$value->govt_fee);

          foreach ($currencyRate as $key2 => $value2) {

            $allServicesData[strtolower($value->nationality)][strtoupper($value2->code)]['standard'] = sprintf("%.2f",$value2->rate * $value->standard_usd_price);

            $allServicesData[strtolower($value->nationality)][strtoupper($value2->code)]['rush'] = sprintf("%.2f",$value2->rate * $value->rush_usd_price);

            $allServicesData[strtolower($value->nationality)][strtoupper($value2->code)]['express'] = sprintf("%.2f",$value2->rate * $value->express_usd_price);

            $allServicesData[strtolower($value->nationality)][strtoupper($value2->code)]['govt'] = sprintf("%.2f",$value2->rate * $value->govt_fee);

          }
        }

        $temId = $this->generateBarcodeNumber();
        $orderId = env('APP_ORDER_PREFIX').$temId;
        $slug = Str::slug($orderId);

        $insertData = [
          "order_id" => $orderId,
          "services_name" => $request['services'],
          "name" => $request['name'],
          "email_id" => $request['email'],
          "nationality" => $request['nationality'],
          "visa_process_type" => $request['visa_process_type'],
          "contact_no" => $request['phone'],
          "country_live" => $request['livincountry'],
          "slug" => $slug,
          "service_fee" => floatval($allServicesData[$request['nationality']]['USD'][$request['visa_process_type']]) ,
          "govt_fee" => 0 ,
          "total_payment" => 0
        ];

        if(isset($servicesData->is_govt_apply) && $servicesData->is_govt_apply == 1){
          $insertData["govt_fee"] = floatval($allServicesData[$request['nationality']]['USD']['govt']);
          $insertData["total_payment"] = floatval($allServicesData[$request['nationality']]['USD']['govt']) + floatval($allServicesData[$request['nationality']]['USD'][$request['visa_process_type']]);
        }else{
          $insertData["total_payment"] = floatval($allServicesData[$request['nationality']]['USD'][$request['visa_process_type']]);
        }

        DB::table("services_apply_detail")->insert($insertData);

        $data = [
          'email' =>  $request['email'],
          'slug' => $slug
        ];
        $this->sendNotificationMail($data);

        return redirect()->route('services.review', ['slug' => $slug]);
    }

    private function generateBarcodeNumber() {
        $number = mt_rand(1000000000, 9999999999); // better than rand()

        // call the same function if the barcode exists already
        $count =DB::table('services_apply_detail')->where('order_id',env('APP_ORDER_PREFIX').$number)->count();
        if ($count) {
            return generateBarcodeNumber();
        }

        // otherwise, it's valid and can be used
        return $number;
    }

    private function sendNotificationMail($data){
        \Mail::to($data['email'])->send(new ApplyNotificationMail($data));
    }

    public function applyOnlineReview($slug){

      $servicesDetail = DB::table('services_apply_detail')->where('slug',$slug)->where('payment_status',0)->first();

      if(!isset($servicesDetail->id)){
        return redirect('/');
      }
      $default_currency = env('APP_DEFAULT_CURRENCY');

      $servicesPages =  DB::table('services_pages')
      ->select(
        'services_pages.id as id',
        'services_pages.services_name as services_name',
        'services_pages.services_heading as services_heading',
        'services_pages.services_landing_img as services_landing_img',
        'services_pages.services_content_1 as services_content_1',
        'services_pages.services_content_2 as services_content_2',
        'services_pages.services_main_button as services_main_button',
        'services_pages.services_faqs as services_faqs',
        'services_pages.payment_method as payment_method',
        'services_pages.services_nationality_title as services_nationality_title',
        'services_pages.services_type_title as services_type_title',
        'services_pages.services_popular_title as services_popular_title',
        'services_pages.whatsapp_number as whatsapp_number',
        'services_pages.whatsapp_status as whatsapp_status',
        'services_pages.call_number as call_number',
        'services_pages.call_status as call_status',
        'services_pages.is_govt_apply as is_govt_apply',
        'services_pages.meta_title as meta_title',
        'services_pages.meta_description as meta_description',
        'services_pages.meta_keywords as meta_keywords',
        'services_pages.isPassportDocRequired as isPassportDocRequired',
        'services_pages.isApplicantPhotoRequired as isApplicantPhotoRequired',
        'services_pages.isOtherDocRequired as isOtherDocRequired',
        'services_pages.standard_time_duration as standard_time_duration',
        'services_pages.rush_time_duration as rush_time_duration',
        'services_pages.express_time_duration as express_time_duration',
        'route_visa.visa_url as visa_url'
        )
      ->where('services_pages.language_id',env('APP_LANG'))
      ->where('services_pages.services_name',$servicesDetail->services_name)
      ->where('route_visa.type_of_url',"services")
      ->join("route_visa","route_visa.visa_id","=","services_pages.id")
      ->first();


      $currencyRateTemp = DB::table('currency_rate')->where('language_id',env('APP_LANG'))->get();

      $currencyRate = ["USD"=>1];

      foreach ($currencyRateTemp as $key => $value) {
         $currencyRate[strtoupper($value->code)] = $value->rate;
      }

      return view('front.services.review',compact('currencyRate','servicesDetail','servicesPages','slug','default_currency'));
    }


    public function applyOnlineReviewSave(Request $request,$slug){
      $servicesDetail = DB::table('services_apply_detail')->where('slug',$slug)->where('payment_status',0)->first();

      if(!isset($servicesDetail->id)){
        return redirect('/');
      }

        $passportDoc = "";
        $photoDoc = "";
        $otherDoc = "";
        if ($request->hasFile('upload_passport')) {
            $images = $request['upload_passport']->getClientOriginalName();
            $images = time().'_passport_'.$images; // Add current time before image name
            $request['upload_passport']->move(public_path('images/services/application/file'),$images);
            $passportDoc = $images;
        }
        if ($request->hasFile('upload_photo')) {
            $images = $request['upload_photo']->getClientOriginalName();
            $images = time().'_photo_'.$images; // Add current time before image name
            $request['upload_photo']->move(public_path('images/services/application/photo'),$images);
            $photoDoc = $images;
        }
        if ($request->hasFile('upload_other')) {
            $images = $request['upload_other']->getClientOriginalName();
            $images = time().'_photo_'.$images; // Add current time before image name
            $request['upload_other']->move(public_path('images/services/application/other'),$images);
            $otherDoc = $images;
        }


      DB::table('services_apply_detail')->where('order_id',$servicesDetail->order_id)->update([
        "upload_passport" => $passportDoc,
        "upload_photo" => $photoDoc,
        "upload_other" => $otherDoc,
        "payment_status" => isset($request['payment_method']) ? $request['payment_method'] : 0
      ]);

      $servicesPage = DB::table('services_pages')->where('services_name', strtolower($servicesDetail->services_name))->first();
      $applyData = DB::table('services_apply_page_content')->where('services_id', $servicesPage->id)->first();
      if(isset($applyData->id)){
        $applyData->thank_you_content = str_replace('{{order_id}}',$servicesDetail->order_id,$applyData->thank_you_content);
      }

      return view('front.services.thankyou',compact('applyData','slug'));
    }

    public function applyOnlineEdit(Request $request,$url,$slug)
    {
        $countryFound = false;

        $servicesData = DB::table('services_apply_detail')->where('slug',$slug)->where('payment_status',0)->first();
        if(!isset($servicesData->id)){
          return redirect('/');
        }

        $default_currency = env('APP_DEFAULT_CURRENCY');


         $servicesDetail= DB::table('services_pages')
        ->select(
          'services_pages.id as id',
          'services_pages.services_name as services_name',
          'services_pages.services_heading as services_heading',
          'services_pages.services_landing_img as services_landing_img',
          'services_pages.services_content_1 as services_content_1',
          'services_pages.services_content_2 as services_content_2',
          'services_pages.services_main_button as services_main_button',
          'services_pages.services_faqs as services_faqs',
          'services_pages.payment_method as payment_method',
          'services_pages.services_nationality_title as services_nationality_title',
          'services_pages.services_type_title as services_type_title',
          'services_pages.services_popular_title as services_popular_title',
          'services_pages.whatsapp_number as whatsapp_number',
          'services_pages.whatsapp_status as whatsapp_status',
          'services_pages.call_number as call_number',
          'services_pages.call_status as call_status',
          'services_pages.is_govt_apply as is_govt_apply',
          'services_pages.meta_title as meta_title',
          'services_pages.meta_description as meta_description',
          'services_pages.meta_keywords as meta_keywords',
          'services_pages.standard_time_duration as standard_time_duration',
          'services_pages.rush_time_duration as rush_time_duration',
          'services_pages.express_time_duration as express_time_duration',
          'route_visa.visa_url as visa_url'
          )
        ->where('services_pages.language_id',env('APP_LANG'))
        ->where('route_visa.visa_url',$url)
        ->where('route_visa.type_of_url',"services")
        ->join("route_visa","route_visa.visa_id","=","services_pages.id")
        ->first();

        $servicesFaqs = DB::table('services_faqs')
        ->where('services_faqs.language_id',env('APP_LANG'))
        ->where('services_faqs.services_id',$servicesDetail->id)
        ->get();

        $allServicesData = [];
        $default_currency = env('APP_DEFAULT_CURRENCY');
        $currencyRate = DB::table('currency_rate')->where('language_id',env('APP_LANG'))->get();

        $tempServicesTable = DB::table('services_country_price')
                        ->where('services_id',$servicesDetail->id)
                        ->where('language_id',env('APP_LANG'))
                        ->get();
        $countryName = DB::table('country')
                              ->where('country.language_id',env('APP_LANG'))
                              ->get();
        foreach ($tempServicesTable as $key => $value) {

          $allServicesData[strtolower($value->nationality)]['USD']['standard'] = sprintf("%.2f",$value->standard_usd_price);
          $allServicesData[strtolower($value->nationality)]['USD']['rush'] = sprintf("%.2f",$value->rush_usd_price);
          $allServicesData[strtolower($value->nationality)]['USD']['express'] = sprintf("%.2f",$value->express_usd_price);
          $allServicesData[strtolower($value->nationality)]['USD']['govt'] = sprintf("%.2f",$value->govt_fee);

          foreach ($currencyRate as $key2 => $value2) {

            $allServicesData[strtolower($value->nationality)][strtoupper($value2->code)]['standard'] = sprintf("%.2f",$value2->rate * $value->standard_usd_price);

            $allServicesData[strtolower($value->nationality)][strtoupper($value2->code)]['rush'] = sprintf("%.2f",$value2->rate * $value->rush_usd_price);

            $allServicesData[strtolower($value->nationality)][strtoupper($value2->code)]['express'] = sprintf("%.2f",$value2->rate * $value->express_usd_price);

            $allServicesData[strtolower($value->nationality)][strtoupper($value2->code)]['govt'] = sprintf("%.2f",$value2->rate * $value->govt_fee);

          }
        }

        $default_country = "";
        if(count($allServicesData)){
          $default_country = array_keys($allServicesData);
          $default_country = isset($default_country[0]) ? $default_country[0] : "";
        }
        $default_nationality = $servicesData->nationality;
        return view('front.services.edit',compact('allServicesData','servicesDetail','default_nationality','servicesData','countryName','default_country','default_currency','currencyRate','slug','url'));

    }

    public function applyOnlineUpdate(Request $request,$url,$slug){
        // exit(print_r($request->all()));
        $countryFound = false;

        $servicesDetail = DB::table('services_apply_detail')->where('slug',$slug)->where('payment_status',0)->first();
        if(!isset($servicesData->id)){
          return redirect('/');
        }

        $default_currency = env('APP_DEFAULT_CURRENCY');


         $servicesData= DB::table('services_pages')
        ->select(
          'services_pages.id as id',
          'services_pages.services_name as services_name',
          'services_pages.services_heading as services_heading',
          'services_pages.services_landing_img as services_landing_img',
          'services_pages.services_content_1 as services_content_1',
          'services_pages.services_content_2 as services_content_2',
          'services_pages.services_main_button as services_main_button',
          'services_pages.services_faqs as services_faqs',
          'services_pages.payment_method as payment_method',
          'services_pages.services_nationality_title as services_nationality_title',
          'services_pages.services_type_title as services_type_title',
          'services_pages.services_popular_title as services_popular_title',
          'services_pages.whatsapp_number as whatsapp_number',
          'services_pages.whatsapp_status as whatsapp_status',
          'services_pages.call_number as call_number',
          'services_pages.call_status as call_status',
          'services_pages.is_govt_apply as is_govt_apply',
          'services_pages.meta_title as meta_title',
          'services_pages.meta_description as meta_description',
          'services_pages.meta_keywords as meta_keywords',
          'services_pages.standard_time_duration as standard_time_duration',
          'services_pages.rush_time_duration as rush_time_duration',
          'services_pages.express_time_duration as express_time_duration',
          'route_visa.visa_url as visa_url'
          )
        ->where('services_pages.language_id',env('APP_LANG'))
        ->where('route_visa.visa_url',$url)
        ->where('route_visa.type_of_url',"services")
        ->join("route_visa","route_visa.visa_id","=","services_pages.id")
        ->first();


          $tempServicesTable = DB::table('services_country_price')
                          ->where('services_id',$servicesData->id)
                          ->where('language_id',env('APP_LANG'))
                          ->get();
          $countryName = DB::table('country')
                                ->where('country.language_id',env('APP_LANG'))
                                ->get();



          foreach ($tempServicesTable as $key => $value) {

            $allServicesData[strtolower($value->nationality)]['USD']['standard']= sprintf("%.2f",$value->standard_usd_price);
            $allServicesData[strtolower($value->nationality)]['USD']['rush']    = sprintf("%.2f",$value->rush_usd_price);
            $allServicesData[strtolower($value->nationality)]['USD']['express'] = sprintf("%.2f",$value->express_usd_price);
            $allServicesData[strtolower($value->nationality)]['USD']['govt']    = sprintf("%.2f",$value->govt_fee);

            foreach ($currencyRate as $key2 => $value2) {

              $allServicesData[strtolower($value->nationality)][strtoupper($value2->code)]['standard'] = sprintf("%.2f",$value2->rate * $value->standard_usd_price);

              $allServicesData[strtolower($value->nationality)][strtoupper($value2->code)]['rush'] = sprintf("%.2f",$value2->rate * $value->rush_usd_price);

              $allServicesData[strtolower($value->nationality)][strtoupper($value2->code)]['express'] = sprintf("%.2f",$value2->rate * $value->express_usd_price);

              $allServicesData[strtolower($value->nationality)][strtoupper($value2->code)]['govt'] = sprintf("%.2f",$value2->rate * $value->govt_fee);

            }
          }

        $orderId = $servicesDetail->order_id;
        $slug = $servicesDetail->slug;

        $insertData = [
          "order_id" => $orderId,
          "services_name" => $request['services'],
          "name" => $request['name'],
          "email_id" => $request['email'],
          "nationality" => $request['nationality'],
          "visa_process_type" => $request['visa_process_type'],
          "contact_no" => $request['phone'],
          "country_live" => $request['livincountry'],
          "slug" => $slug,
          "service_fee" => floatval($allServicesData[$request['nationality']]['USD'][$request['visa_process_type']]) ,
          "govt_fee" => 0 ,
          "total_payment" => 0
        ];

        if(isset($servicesData->is_govt_apply) && $servicesData->is_govt_apply == 1){
          $insertData["govt_fee"] = floatval($allServicesData[$request['nationality']]['USD']['govt']);
          $insertData["total_payment"] = floatval($allServicesData[$request['nationality']]['USD']['govt']) + floatval($allServicesData[$request['nationality']]['USD'][$request['visa_process_type']]);
        }else{
          $insertData["total_payment"] = floatval($allServicesData[$request['nationality']]['USD'][$request['visa_process_type']]);
        }

        DB::table("services_apply_detail")->update($insertData)->where("order_id",$orderId);

        $data = [
          'email' =>  $request['email'],
          'slug' => $slug
        ];
        $this->sendNotificationMail($data);

        return redirect()->route('services.review', ['slug' => $slug]);
    }


    public function serviceContactUs(Request $request){
        $data = ["status"=>true];
        DB::table('services_contact_us')->insert([
            'language_id' => env('APP_LANG'),
            'name' => $request['name'],
            'email' => $request['email'],
            'contact_number' => $request['mobile'],
            'message' => $request['msg'],
            'nationality' => strtolower($request['country']),
            'submission_date' => date('Y-m-d H:i:s')
        ]);
        return json_encode($data);
    }
}

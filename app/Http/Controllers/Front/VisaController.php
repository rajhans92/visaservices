<?php

namespace App\Http\Controllers\Front;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Mail\ApplyNotificationMail;

class VisaController extends Controller
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

      $visaData = DB::table('visa_pages')
      ->select(
        'visa_pages.id as id',
        'visa_pages.country_name as country_name',
        'visa_pages.visa_heading as visa_heading',
        'visa_pages.visa_landing_img as visa_landing_img',
        'visa_pages.visa_content_1 as visa_content_1',
        'visa_pages.visa_content_2 as visa_content_2',
        'visa_pages.visa_main_button as visa_main_button',
        'visa_pages.visa_faqs as visa_faqs',
        'visa_pages.payment_method as payment_method',
        'visa_pages.visa_nationality_title as visa_nationality_title',
        'visa_pages.visa_type_title as visa_type_title',
        'visa_pages.visa_popular_title as visa_popular_title',
        'visa_pages.is_price_show as is_price_show',
        'visa_pages.whatsapp_number as whatsapp_number',
        'visa_pages.whatsapp_text as whatsapp_text',
        'visa_pages.whatsapp_status as whatsapp_status',
        'visa_pages.call_number as call_number',
        'visa_pages.call_status as call_status',
        'visa_pages.meta_title as meta_title',
        'visa_pages.meta_description as meta_description',
        'visa_pages.meta_keywords as meta_keywords',
        'visa_pages.is_govt_apply as is_govt_apply',
        'visa_pages.standard_time_duration as standard_time_duration',
        'visa_pages.rush_time_duration as rush_time_duration',
        'visa_pages.express_time_duration as express_time_duration',
        'route_visa.visa_url as visa_url'
        )
      ->where('visa_pages.language_id',env('APP_LANG'))
      ->where('route_visa.visa_url',$uri)
      ->where('route_visa.type_of_url',"visa")
      ->join("route_visa","route_visa.visa_id","=","visa_pages.id")
      ->first();

      $default_visa = isset($_COOKIE['go_country']) ? strtolower($_COOKIE['go_country']) : $visaData->country_name;
      $default_nationality = isset($_COOKIE['from_country']) ? strtolower($_COOKIE['from_country']) : env('APP_DEFAULT_COUNTRY');

      $visaFaqs = DB::table('visa_faqs')
      ->where('visa_faqs.language_id',env('APP_LANG'))
      ->where('visa_faqs.visa_id',$visaData->id)
      ->get();

      $visaProcessingType = DB::table('visa_process_type')
                            ->select('visa_process_type.name as name','visa_process_type.duration as duration','duration_type.name as duration_type')
                            ->where('visa_process_type.language_id',env('APP_LANG'))
                            ->where('visa_process_type.name',env('APP_VISA_TYPE'))
                            ->join("duration_type","duration_type.id","=","visa_process_type.duration_type_id")
                            ->first();

      $visaDurationData = [
        "standard" => $visaData->standard_time_duration,
        "rush" => $visaData->rush_time_duration,
        "express" => $visaData->express_time_duration,
      ];

      $allVisaData = [];
      $currencyRate = DB::table('currency_rate')->where('language_id',env('APP_LANG'))->get();

      $tempVisaTable = DB::table('visa_type_detail')
                      ->where('visa_country_name',$visaData->country_name)
                      ->where('language_id',env('APP_LANG'))
                      ->get();

      foreach ($tempVisaTable as $key => $value) {
        $govt_fees = 0;
        if($visaData->is_govt_apply == 1){
          $govt_fees  =sprintf("%.2f",$value->govt_fee);
        }
        $allVisaData[strtolower($value->nationality_name)][$value->visa_type_name]['USD']['standard'] = $govt_fees + sprintf("%.2f",$value->standard_usd_price);
        $allVisaData[strtolower($value->nationality_name)][$value->visa_type_name]['USD']['rush'] = $govt_fees + sprintf("%.2f",$value->rush_usd_price);
        $allVisaData[strtolower($value->nationality_name)][$value->visa_type_name]['USD']['express'] = $govt_fees + sprintf("%.2f",$value->express_usd_price);
        $allVisaData[strtolower($value->nationality_name)][$value->visa_type_name]['USD']['govt'] = $govt_fees;

        foreach ($currencyRate as $key2 => $value2) {
          $allVisaData[strtolower($value->nationality_name)][$value->visa_type_name][strtoupper($value2->code)]['standard'] = sprintf("%.2f", $value2->rate * $value->standard_usd_price) + $govt_fees;

          $allVisaData[strtolower($value->nationality_name)][$value->visa_type_name][strtoupper($value2->code)]['rush'] =  sprintf("%.2f", $value2->rate * $value->rush_usd_price)+ $govt_fees;

          $allVisaData[strtolower($value->nationality_name)][$value->visa_type_name][strtoupper($value2->code)]['express'] = sprintf("%.2f", $value2->rate * $value->express_usd_price) + $govt_fees;

          $allVisaData[strtolower($value->nationality_name)][$value->visa_type_name][strtoupper($value2->code)]['govt'] = sprintf("%.2f", $value2->rate * $value->govt_fee);

        }

      }

      $isAvailable = false;
      if(isset($tempVisaTable[0])){
        $isAvailable = true;
      }
      return view('front.visa.page',compact('visaData','visaDurationData','visaFaqs','allVisaData','isAvailable','visaProcessingType','default_visa','default_nationality'));

    }

    public function applyOnline($url)
    {
        $countryFound = false;
        $default_currency = env('APP_DEFAULT_CURRENCY');

        $visaData = DB::table('visa_pages')
        ->select(
          'visa_pages.id as id',
          'visa_pages.country_name as country_name',
          'visa_pages.visa_heading as visa_heading',
          'visa_pages.visa_landing_img as visa_landing_img',
          'visa_pages.visa_content_1 as visa_content_1',
          'visa_pages.visa_content_2 as visa_content_2',
          'visa_pages.visa_main_button as visa_main_button',
          'visa_pages.visa_faqs as visa_faqs',
          'visa_pages.visa_nationality_title as visa_nationality_title',
          'visa_pages.visa_type_title as visa_type_title',
          'visa_pages.visa_popular_title as visa_popular_title',
          'visa_pages.is_govt_apply as is_govt_apply',
          'visa_pages.standard_time_duration as standard_time_duration',
          'visa_pages.rush_time_duration as rush_time_duration',
          'visa_pages.express_time_duration as express_time_duration',
          'route_visa.visa_url as visa_url'
          )
        ->where('visa_pages.language_id',env('APP_LANG'))
        ->where('route_visa.visa_url',$url)
        ->where('route_visa.type_of_url',"visa")
        ->join("route_visa","route_visa.visa_id","=","visa_pages.id")
        ->first();

        if(!isset($visaData->id)){
          return redirect('/');
        }
        $default_visa = isset($_COOKIE['go_country']) ? strtolower($_COOKIE['go_country']) : $visaData->country_name;
        $default_nationality = isset($_COOKIE['from_country']) ? strtolower($_COOKIE['from_country']) : env('APP_DEFAULT_COUNTRY');

        $visaFaqs = DB::table('visa_faqs')
        ->where('visa_faqs.language_id',env('APP_LANG'))
        ->where('visa_faqs.visa_id',$visaData->id)
        ->get();


        $visaProcessingType = DB::table('visa_process_type')
                              ->select('visa_process_type.name as name','visa_process_type.duration as duration','duration_type.name as duration_type')
                              ->where('visa_process_type.language_id',env('APP_LANG'))
                              ->where('visa_process_type.name',env('APP_VISA_TYPE'))
                              ->join("duration_type","duration_type.id","=","visa_process_type.duration_type_id")
                              ->get();

        $portOfArrival = DB::table('port_of_arrival')
                              ->where('port_of_arrival.language_id',env('APP_LANG'))
                              ->where('port_of_arrival.language_id',env('APP_LANG'))
                              ->where('country.country_name',strtolower($visaData->country_name))
                              ->join('country',"country.id","=","port_of_arrival.country_id")
                              ->get();

        $countryName = DB::table('country')
                              ->where('country.language_id',env('APP_LANG'))
                              ->get();

        $allVisaData = [];
        $allVisaDataAlter = [];

        $currencyRate = DB::table('currency_rate')->where('language_id',env('APP_LANG'))->get();
        $tempVisaTable = DB::table('visa_type_detail')
                        ->where('visa_country_name',$visaData->country_name)
                        ->where('language_id',env('APP_LANG'))
                        ->get();

        $tempCheck = false;
        $default_visa_type = "";
        foreach ($tempVisaTable as $key => $value) {

          if(!$tempCheck && $default_nationality == strtolower($value->nationality_name)){
              $tempCheck = true;
              $default_visa_type = $value->visa_type_name;
          }
          $allVisaData[$value->visa_type_name]['country'][strtolower($value->nationality_name)]['USD']['standard'] = sprintf("%.2f",$value->standard_usd_price);
          $allVisaData[$value->visa_type_name]['country'][strtolower($value->nationality_name)]['USD']['rush'] = sprintf("%.2f",$value->rush_usd_price);
          $allVisaData[$value->visa_type_name]['country'][strtolower($value->nationality_name)]['USD']['express'] = sprintf("%.2f",$value->express_usd_price);
          $allVisaData[$value->visa_type_name]['country'][strtolower($value->nationality_name)]['USD']['govt'] = sprintf("%.2f",$value->govt_fee);
          //-------------------------------------------------------------------------------------------------------------------

          $allVisaDataAlter[strtolower($value->nationality_name)][$value->visa_type_name]['USD']['standard'] = sprintf("%.2f",$value->standard_usd_price);
          $allVisaDataAlter[strtolower($value->nationality_name)][$value->visa_type_name]['USD']['rush'] = sprintf("%.2f",$value->rush_usd_price);
          $allVisaDataAlter[strtolower($value->nationality_name)][$value->visa_type_name]['USD']['express'] = sprintf("%.2f",$value->express_usd_price);
          $allVisaDataAlter[strtolower($value->nationality_name)][$value->visa_type_name]['USD']['govt'] = sprintf("%.2f",$value->govt_fee);


          foreach ($currencyRate as $key2 => $value2) {

            $allVisaData[$value->visa_type_name]['country'][strtolower($value->nationality_name)][strtoupper($value2->code)]['standard'] = sprintf("%.2f",$value2->rate * $value->standard_usd_price);

            $allVisaData[$value->visa_type_name]['country'][strtolower($value->nationality_name)][strtoupper($value2->code)]['rush'] = sprintf("%.2f",$value2->rate * $value->rush_usd_price);

            $allVisaData[$value->visa_type_name]['country'][strtolower($value->nationality_name)][strtoupper($value2->code)]['express'] = sprintf("%.2f",$value2->rate * $value->express_usd_price);

            $allVisaData[$value->visa_type_name]['country'][strtolower($value->nationality_name)][strtoupper($value2->code)]['govt'] = sprintf("%.2f",$value2->rate * $value->govt_fee);
            //-------------------------------------------------------------------------------------------------------------------
            $allVisaDataAlter[strtolower($value->nationality_name)][$value->visa_type_name][strtoupper($value2->code)]['standard'] = sprintf("%.2f",$value2->rate * $value->standard_usd_price);

            $allVisaDataAlter[strtolower($value->nationality_name)][$value->visa_type_name][strtoupper($value2->code)]['rush'] = sprintf("%.2f",$value2->rate * $value->rush_usd_price);

            $allVisaDataAlter[strtolower($value->nationality_name)][$value->visa_type_name][strtoupper($value2->code)]['express'] = sprintf("%.2f",$value2->rate * $value->express_usd_price);

            $allVisaDataAlter[strtolower($value->nationality_name)][$value->visa_type_name][strtoupper($value2->code)]['govt'] = sprintf("%.2f",$value2->rate * $value->govt_fee);
          }

        }

        return view('front.apply.calculator',compact('allVisaData','visaProcessingType','visaData','portOfArrival','countryName','default_visa_type','default_nationality','default_visa','default_currency','currencyRate','allVisaDataAlter'));

    }

    public function applyOnlineSave(Request $request){
        // exit(print_r($request->all()));
        $allVisaData = [];
        $total_payment = 0.0;
        $default_currency = env('APP_DEFAULT_CURRENCY');
        $default_visa = isset($_COOKIE['go_country']) ? strtolower($_COOKIE['go_country']) : $request['visa_country_name'];
        $default_nationality = isset($_COOKIE['from_country']) ? strtolower($_COOKIE['from_country']) : env('APP_DEFAULT_COUNTRY');

        $currencyRate = DB::table('currency_rate')->where('language_id',env('APP_LANG'))->get();

        $tempVisaTable = DB::table('visa_type_detail')
                        ->where('visa_country_name',strtolower($default_visa))
                        ->where('language_id',env('APP_LANG'))
                        ->get();

        $visaData = DB::table('visa_pages')
                        ->select(
                          'visa_pages.id as id',
                          'visa_pages.country_name as country_name',
                          'visa_pages.visa_heading as visa_heading',
                          'visa_pages.visa_landing_img as visa_landing_img',
                          'visa_pages.visa_content_1 as visa_content_1',
                          'visa_pages.visa_content_2 as visa_content_2',
                          'visa_pages.visa_main_button as visa_main_button',
                          'visa_pages.visa_faqs as visa_faqs',
                          'visa_pages.visa_nationality_title as visa_nationality_title',
                          'visa_pages.visa_type_title as visa_type_title',
                          'visa_pages.visa_popular_title as visa_popular_title',
                          'visa_pages.is_govt_apply as is_govt_apply',
                          'visa_pages.standard_time_duration as standard_time_duration',
                          'visa_pages.rush_time_duration as rush_time_duration',
                          'visa_pages.express_time_duration as express_time_duration',
                          'route_visa.visa_url as visa_url'
                          )
                        ->where('visa_pages.language_id',env('APP_LANG'))
                        ->where('visa_pages.country_name',strtolower($default_visa))
                        ->where('route_visa.type_of_url',"visa")
                        ->join("route_visa","route_visa.visa_id","=","visa_pages.id")
                        ->first();

        foreach ($tempVisaTable as $key => $value) {
          $allVisaData[strtolower($value->visa_type_name)]['country'][strtolower($value->nationality_name)]['USD']['standard'] = sprintf("%.2f",$value->standard_usd_price);
          $allVisaData[strtolower($value->visa_type_name)]['country'][strtolower($value->nationality_name)]['USD']['rush'] = sprintf("%.2f",$value->rush_usd_price);
          $allVisaData[strtolower($value->visa_type_name)]['country'][strtolower($value->nationality_name)]['USD']['express'] = sprintf("%.2f",$value->express_usd_price);
          $allVisaData[strtolower($value->visa_type_name)]['country'][strtolower($value->nationality_name)]['USD']['govt'] = sprintf("%.2f",$value->govt_fee);

          foreach ($currencyRate as $key2 => $value2) {

            $allVisaData[strtolower($value->visa_type_name)]['country'][strtolower($value->nationality_name)][strtoupper($value2->code)]['standard'] = sprintf("%.2f",$value2->rate * $value->standard_usd_price);

            $allVisaData[strtolower($value->visa_type_name)]['country'][strtolower($value->nationality_name)][strtoupper($value2->code)]['rush'] = sprintf("%.2f",$value2->rate * $value->rush_usd_price);

            $allVisaData[strtolower($value->visa_type_name)]['country'][strtolower($value->nationality_name)][strtoupper($value2->code)]['express'] = sprintf("%.2f",$value2->rate * $value->express_usd_price);

            $allVisaData[strtolower($value->visa_type_name)]['country'][strtolower($value->nationality_name)][strtoupper($value2->code)]['govt'] = sprintf("%.2f",$value2->rate * $value->govt_fee);

          }

        }

        $temId = $this->generateBarcodeNumber();
        $orderId = env('APP_ORDER_PREFIX').$temId;
        $slug = Str::slug($orderId);
        $visaDataSet = [];
        for ($i=1; $i <= $request['totalCount'] ; $i++) {
          if(isset($request['applicant_nationality'.$i])){
              $visaDataSet[] = [
                 "order_id" => $orderId,
                 "first_name" => $request['applicant_first_name'.$i],
                 "last_name" => $request['applicant_last_name'.$i],
                 "type_of_visa" => $request['visaType'],
                 "nationality" => $request['applicant_nationality'.$i],
                 "visa_process_type" => $request['visa_process_type'],
                 "date_of_birth" =>date('Y-m-d H:m:s',strtotime($request['applicant_dob_year'.$i].'-'.$request['applicant_dob_month'.$i].'-'.$request['applicant_dob_date'.$i])),
                 "gender" => $request['applicant_gender'.$i],
                 "applicant_country_birth" => $request['applicant_country_birth'.$i],
                 "applicant_country_residence" => $request['applicant_country_residence'.$i],
                 "applicant_phone" => $request['applicant_phone'.$i],
                 "passport_issue_date" => date('Y-m-d H:m:s',strtotime($request['applicant_passport_issue_year'.$i].'-'.$request['applicant_passport_issue_month'.$i].'-'.$request['applicant_passport_issue_date'.$i])),
                 "passport_expiry_date" => date('Y-m-d H:m:s',strtotime($request['applicant_passport_year'.$i].'-'.$request['applicant_passport_month'.$i].'-'.$request['applicant_passport_date'.$i])),
                 "applicant_payment" => floatval($allVisaData[strtolower($request['visaType'])]['country'][$request['applicant_nationality'.$i]]['USD'][$request['visa_process_type']]) ,
                 "govt_fee" => isset($visaData->is_govt_apply) && $visaData->is_govt_apply=='1' ? floatval($allVisaData[strtolower($request['visaType'])]['country'][$request['applicant_nationality'.$i]]['USD']['govt']):0.00 ,
              ];
              $total_payment += floatval($allVisaData[strtolower($request['visaType'])]['country'][$request['applicant_nationality'.$i]]['USD'][$request['visa_process_type']])+ (isset($visaData->is_govt_apply) && $visaData->is_govt_apply=='1' ? floatval($allVisaData[strtolower($request['visaType'])]['country'][$request['applicant_nationality'.$i]]['USD']['govt']):0.00);
            }
        }

        DB::table("visa_apply_detail")->insert([
          "order_id" => $orderId,
          "email_id" => $request['email'],
          "visa_country_name" => $request['visa_country_name'],
          "arrival_date" => date('Y-m-d',strtotime($request['arrival_year'].'-'.$request['arrival_month'].'-'.$request['arrival_date'])),
          "departure_date" => date('Y-m-d',strtotime($request['departure_year'].'-'.$request['departure_month'].'-'.$request['departure_date'])),
          "type_of_visa" => $request['visaType'],
          "visa_process_type" => $request['visa_process_type'],
          "port_of_arrival" =>$request['port_arrival'],
          "contact_no" => $request['phone'],
          "country_live" => $request['livincountry'],
          "slug" => $slug,
          "total_payment" => $total_payment,
        ]);
        DB::table("visa_apply_applicant")->insert($visaDataSet);

        $data = [
          'email' =>  $request['email'],
          'slug' => $slug
        ];
        $this->sendNotificationMail($data);

        return redirect()->route('apply.review', ['slug' => $slug]);
    }

    private function generateBarcodeNumber() {
        $number = mt_rand(1000000000, 9999999999); // better than rand()

        // call the same function if the barcode exists already
        $count =DB::table('visa_apply_detail')->where('order_id',env('APP_ORDER_PREFIX').$number)->count();
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

      $visaDetail = DB::table('visa_apply_detail')->where('slug',$slug)->where('payment_status',0)->first();

      if(!isset($visaDetail->id)){
        return redirect('/');
      }
      $default_currency = env('APP_DEFAULT_CURRENCY');

      $visaPages = DB::table('visa_pages')
                  ->select('visa_pages.*','route_visa.visa_url as visa_url')
                  ->where('visa_pages.country_name',$visaDetail->visa_country_name)
                  ->where('visa_pages.language_id',env('APP_LANG'))
                  ->where('route_visa.type_of_url',"visa")
                  ->join("route_visa","route_visa.visa_id","=","visa_pages.id")
                  ->first();

      $visaApplicantDetail = DB::table('visa_apply_applicant')->where('order_id',$visaDetail->order_id)->get();

      $currencyRateTemp = DB::table('currency_rate')->where('language_id',env('APP_LANG'))->get();
      $currencyRate = ["USD"=>1];
      foreach ($currencyRateTemp as $key => $value) {
         $currencyRate[strtoupper($value->code)] = $value->rate;
      }

      return view('front.apply.review',compact('currencyRate','visaDetail','visaPages','visaApplicantDetail','slug','default_currency'));
    }

    public function applyOnlineReviewSave(Request $request,$slug){
      $visaDetail = DB::table('visa_apply_detail')->where('slug',$slug)->where('payment_status',0)->first();
      // exit(print_r($request->all()));
      if(!isset($visaDetail->id)){
        return redirect('/');
      }
      $visaApplicantDetail = DB::table('visa_apply_applicant')->where('order_id',$visaDetail->order_id)->get();

      foreach ($visaApplicantDetail as $key => $value) {
          $passportDoc = "";
          $photoDoc = "";
          $otherDoc = "";
          if ($request->hasFile('upload_passport'.$value->id)) {
              $images = $request['upload_passport'.$value->id]->getClientOriginalName();
              $images = $value->id.time().'_passport_'.$images; // Add current time before image name
              $request['upload_passport'.$value->id]->move(public_path('images/application/file'),$images);
              $passportDoc = $images;
          }
          if ($request->hasFile('upload_photo'.$value->id)) {
              $images = $request['upload_photo'.$value->id]->getClientOriginalName();
              $images = $value->id.time().'_photo_'.$images; // Add current time before image name
              $request['upload_photo'.$value->id]->move(public_path('images/application/photo'),$images);
              $photoDoc = $images;
          }
          if ($request->hasFile('upload_other'.$value->id)) {
              $images = $request['upload_other'.$value->id]->getClientOriginalName();
              $images = $value->id.time().'_photo_'.$images; // Add current time before image name
              $request['upload_other'.$value->id]->move(public_path('images/application/other'),$images);
              $otherDoc = $images;
          }
          DB::table('visa_apply_applicant')->where('id',$value->id)->update([
              "passport_file" => $passportDoc,
              "applicant_photo" => $photoDoc,
              "other_files" => $otherDoc
          ]);
      }
      DB::table('visa_apply_detail')->where('order_id',$visaDetail->order_id)->update([
        "payment_status" => isset($request['payment_method']) ? $request['payment_method'] : 0
      ]);

      $visaPage = DB::table('visa_pages')->where('country_name', strtolower($visaDetail->visa_country_name))->first();
      $applyData = DB::table('visa_apply_page_content')->where('visa_id', $visaPage->id)->first();
      if(isset($applyData->id)){
        $applyData->thank_you_content = str_replace('{{order_id}}',$visaDetail->order_id,$applyData->thank_you_content);
      }

      return view('front.apply.thankyou',compact('applyData','slug'));
    }

    public function applyOnlineEdit(Request $request,$url,$slug)
    {
        $countryFound = false;

        $visaDetail = DB::table('visa_apply_detail')->where('slug',$slug)->where('payment_status',0)->first();

        if(!isset($visaDetail->id)){
          return redirect('/');
        }
        $default_currency = env('APP_DEFAULT_CURRENCY');


        $default_visa = $visaDetail->visa_country_name;
        $default_nationality = isset($_COOKIE['from_country']) ? strtolower($_COOKIE['from_country']) : env('APP_DEFAULT_COUNTRY');

        $visaApplicantDetail = DB::table('visa_apply_applicant')->where('order_id',$visaDetail->order_id)->get();

        $visaData = DB::table('visa_pages')
        ->select(
          'visa_pages.id as id',
          'visa_pages.country_name as country_name',
          'visa_pages.visa_heading as visa_heading',
          'visa_pages.visa_landing_img as visa_landing_img',
          'visa_pages.visa_content_1 as visa_content_1',
          'visa_pages.visa_content_2 as visa_content_2',
          'visa_pages.visa_main_button as visa_main_button',
          'visa_pages.visa_faqs as visa_faqs',
          'visa_pages.visa_nationality_title as visa_nationality_title',
          'visa_pages.visa_type_title as visa_type_title',
          'visa_pages.visa_popular_title as visa_popular_title',
          'visa_pages.is_govt_apply as is_govt_apply',
          'visa_pages.standard_time_duration as standard_time_duration',
          'visa_pages.rush_time_duration as rush_time_duration',
          'visa_pages.express_time_duration as express_time_duration',
          'route_visa.visa_url as visa_url'
          )
        ->where('visa_pages.language_id',env('APP_LANG'))
        ->where('visa_pages.country_name',$visaDetail->visa_country_name)
        ->where('route_visa.type_of_url',"visa")
        ->join("route_visa","route_visa.visa_id","=","visa_pages.id")
        ->first();

        $default_visa_type = $visaDetail->type_of_visa;
        $default_visa_processing_type = $visaDetail->visa_process_type;

        if(!isset($visaData->id)){
          return redirect('/');
        }

        $visaFaqs = DB::table('visa_faqs')
        ->where('visa_faqs.language_id',env('APP_LANG'))
        ->where('visa_faqs.visa_id',$visaData->id)
        ->get();


        $visaProcessingType = DB::table('visa_process_type')
                              ->select('visa_process_type.name as name','visa_process_type.duration as duration','duration_type.name as duration_type')
                              ->where('visa_process_type.language_id',env('APP_LANG'))
                              ->where('visa_process_type.name',env('APP_VISA_TYPE'))
                              ->join("duration_type","duration_type.id","=","visa_process_type.duration_type_id")
                              ->get();

        $portOfArrival = DB::table('port_of_arrival')
                              ->where('port_of_arrival.language_id',env('APP_LANG'))
                              ->where('port_of_arrival.language_id',env('APP_LANG'))
                              ->where('country.country_name',strtolower($visaData->country_name))
                              ->join('country',"country.id","=","port_of_arrival.country_id")
                              ->get();

        $countryName = DB::table('country')
                              ->where('country.language_id',env('APP_LANG'))
                              ->get();

        $allVisaData = [];
        $allVisaDataAlter = [];

        $currencyRate = DB::table('currency_rate')->where('language_id',env('APP_LANG'))->get();
        $tempVisaTable = DB::table('visa_type_detail')
                        ->where('visa_country_name',$visaData->country_name)
                        ->where('language_id',env('APP_LANG'))
                        ->get();

        $tempCheck = false;
        foreach ($tempVisaTable as $key => $value) {

          $allVisaData[$value->visa_type_name]['country'][strtolower($value->nationality_name)]['USD']['standard'] = sprintf("%.2f",$value->standard_usd_price);
          $allVisaData[$value->visa_type_name]['country'][strtolower($value->nationality_name)]['USD']['rush'] = sprintf("%.2f",$value->rush_usd_price);
          $allVisaData[$value->visa_type_name]['country'][strtolower($value->nationality_name)]['USD']['express'] = sprintf("%.2f",$value->express_usd_price);
          $allVisaData[$value->visa_type_name]['country'][strtolower($value->nationality_name)]['USD']['govt'] = sprintf("%.2f",$value->govt_fee);
          //-------------------------------------------------------------------------------------------------------------------

          $allVisaDataAlter[strtolower($value->nationality_name)][$value->visa_type_name]['USD']['standard'] = sprintf("%.2f",$value->standard_usd_price);
          $allVisaDataAlter[strtolower($value->nationality_name)][$value->visa_type_name]['USD']['rush'] = sprintf("%.2f",$value->rush_usd_price);
          $allVisaDataAlter[strtolower($value->nationality_name)][$value->visa_type_name]['USD']['express'] = sprintf("%.2f",$value->express_usd_price);
          $allVisaDataAlter[strtolower($value->nationality_name)][$value->visa_type_name]['USD']['govt'] = sprintf("%.2f",$value->govt_fee);


          foreach ($currencyRate as $key2 => $value2) {

            $allVisaData[$value->visa_type_name]['country'][strtolower($value->nationality_name)][strtoupper($value2->code)]['standard'] = sprintf("%.2f",$value2->rate * $value->standard_usd_price);

            $allVisaData[$value->visa_type_name]['country'][strtolower($value->nationality_name)][strtoupper($value2->code)]['rush'] = sprintf("%.2f",$value2->rate * $value->rush_usd_price);

            $allVisaData[$value->visa_type_name]['country'][strtolower($value->nationality_name)][strtoupper($value2->code)]['express'] = sprintf("%.2f",$value2->rate * $value->express_usd_price);

            $allVisaData[$value->visa_type_name]['country'][strtolower($value->nationality_name)][strtoupper($value2->code)]['govt'] = sprintf("%.2f",$value2->rate * $value->govt_fee);
            //-------------------------------------------------------------------------------------------------------------------
            $allVisaDataAlter[strtolower($value->nationality_name)][$value->visa_type_name][strtoupper($value2->code)]['standard'] = sprintf("%.2f",$value2->rate * $value->standard_usd_price);

            $allVisaDataAlter[strtolower($value->nationality_name)][$value->visa_type_name][strtoupper($value2->code)]['rush'] = sprintf("%.2f",$value2->rate * $value->rush_usd_price);

            $allVisaDataAlter[strtolower($value->nationality_name)][$value->visa_type_name][strtoupper($value2->code)]['express'] = sprintf("%.2f",$value2->rate * $value->express_usd_price);

            $allVisaDataAlter[strtolower($value->nationality_name)][$value->visa_type_name][strtoupper($value2->code)]['govt'] = sprintf("%.2f",$value2->rate * $value->govt_fee);
          }

        }

        return view('front.apply.edit',compact('allVisaData','visaData','visaProcessingType','portOfArrival','countryName','default_visa_type','default_nationality','default_visa','default_currency','currencyRate','allVisaDataAlter','visaDetail','visaApplicantDetail','default_visa_processing_type','slug','url'));

    }

    public function applyOnlineUpdate(Request $request){
        // exit(print_r($request->all()));
        $allVisaData = [];
        $total_payment = 0.0;
        $visaDetail = DB::table('visa_apply_detail')->where('order_id',$request->order_id)->where('payment_status',0)->first();

        if(!isset($visaDetail->id)){
          return redirect('/');
        }
        $visaApplicantDetail = DB::table('visa_apply_applicant')->where('order_id',$visaDetail->order_id)->get();

        $currencyRate = DB::table('currency_rate')->where('language_id',env('APP_LANG'))->get();

        $tempVisaTable = DB::table('visa_type_detail')
                        ->where('visa_country_name',strtolower($visaDetail->visa_country_name))
                        ->where('language_id',env('APP_LANG'))
                        ->get();

        $visaData = DB::table('visa_pages')
                        ->select(
                          'visa_pages.id as id',
                          'visa_pages.country_name as country_name',
                          'visa_pages.visa_heading as visa_heading',
                          'visa_pages.visa_landing_img as visa_landing_img',
                          'visa_pages.visa_content_1 as visa_content_1',
                          'visa_pages.visa_content_2 as visa_content_2',
                          'visa_pages.visa_main_button as visa_main_button',
                          'visa_pages.visa_faqs as visa_faqs',
                          'visa_pages.visa_nationality_title as visa_nationality_title',
                          'visa_pages.visa_type_title as visa_type_title',
                          'visa_pages.visa_popular_title as visa_popular_title',
                          'visa_pages.is_govt_apply as is_govt_apply',
                          'visa_pages.standard_time_duration as standard_time_duration',
                          'visa_pages.rush_time_duration as rush_time_duration',
                          'visa_pages.express_time_duration as express_time_duration',
                          'route_visa.visa_url as visa_url'
                          )
                        ->where('visa_pages.language_id',env('APP_LANG'))
                        ->where('visa_pages.country_name',strtolower($visaDetail->visa_country_name))
                        ->where('route_visa.type_of_url',"visa")
                        ->join("route_visa","route_visa.visa_id","=","visa_pages.id")
                        ->first();
        foreach ($tempVisaTable as $key => $value) {
          $allVisaData[$value->visa_type_name]['country'][strtolower($value->nationality_name)]['USD']['standard'] = sprintf("%.2f",$value->standard_usd_price);
          $allVisaData[$value->visa_type_name]['country'][strtolower($value->nationality_name)]['USD']['rush'] = sprintf("%.2f",$value->rush_usd_price);
          $allVisaData[$value->visa_type_name]['country'][strtolower($value->nationality_name)]['USD']['express'] = sprintf("%.2f",$value->express_usd_price);
          $allVisaData[$value->visa_type_name]['country'][strtolower($value->nationality_name)]['USD']['govt'] = sprintf("%.2f",$value->govt_fee);

          foreach ($currencyRate as $key2 => $value2) {

            $allVisaData[$value->visa_type_name]['country'][strtolower($value->nationality_name)][strtoupper($value2->code)]['standard'] = sprintf("%.2f",$value2->rate * $value->standard_usd_price);

            $allVisaData[$value->visa_type_name]['country'][strtolower($value->nationality_name)][strtoupper($value2->code)]['rush'] = sprintf("%.2f",$value2->rate * $value->rush_usd_price);

            $allVisaData[$value->visa_type_name]['country'][strtolower($value->nationality_name)][strtoupper($value2->code)]['express'] = sprintf("%.2f",$value2->rate * $value->express_usd_price);

            $allVisaData[$value->visa_type_name]['country'][strtolower($value->nationality_name)][strtoupper($value2->code)]['govt'] = sprintf("%.2f",$value2->rate * $value->govt_fee);

          }

        }

        $temId = $this->generateBarcodeNumber();
        $orderId = $visaDetail->order_id;
        $slug = $visaDetail->slug;
        $visaDataSet = [];

        foreach ($visaApplicantDetail as $key => $value) {
          if(isset($request['applicant_nationality_update'.$value->id])){
            DB::table("visa_apply_applicant")->where('id',$value->id)->update([
              "first_name" => $request['applicant_first_name_update'.$value->id],
              "last_name" => $request['applicant_last_name_update'.$value->id],
              "type_of_visa" => $request['visaType'],
              "nationality" => $request['applicant_nationality_update'.$value->id],
              "visa_process_type" => $request['visa_process_type'],
              "date_of_birth" =>date('Y-m-d H:m:s',strtotime($request['applicant_dob_year_update'.$value->id].'-'.$request['applicant_dob_month_update'.$value->id].'-'.$request['applicant_dob_date_update'.$value->id])),
              "gender" => $request['applicant_gender_update'.$value->id],
              "applicant_country_birth" => $request['applicant_country_birth_update'.$value->id],
              "applicant_country_residence" => $request['applicant_country_residence_update'.$value->id],
              "applicant_phone" => $request['applicant_phone_update'.$value->id],
              "passport_issue_date" => date('Y-m-d H:m:s',strtotime($request['applicant_passport_issue_year_update'.$value->id].'-'.$request['applicant_passport_issue_month_update'.$value->id].'-'.$request['applicant_passport_issue_date_update'.$value->id])),
              "passport_expiry_date" => date('Y-m-d H:m:s',strtotime($request['applicant_passport_year_update'.$value->id].'-'.$request['applicant_passport_month_update'.$value->id].'-'.$request['applicant_passport_date_update'.$value->id])),
              "applicant_payment" => floatval($allVisaData[$request['visaType']]['country'][$request['applicant_nationality_update'.$value->id]]['USD'][$request['visa_process_type']]) ,
              "govt_fee" => (isset($visaData->is_govt_apply) && $visaData->is_govt_apply =='1') ? floatval($allVisaData[$request['visaType']]['country'][$request['applicant_nationality_update'.$value->id]]['USD']['govt']) : 0.00
            ]);
            $total_payment += floatval($allVisaData[$request['visaType']]['country'][$request['applicant_nationality_update'.$value->id]]['USD'][$request['visa_process_type']])+ ((isset($visaData->is_govt_apply) && $visaData->is_govt_apply == '1') ? floatval($allVisaData[$request['visaType']]['country'][$request['applicant_nationality_update'.$value->id]]['USD']['govt']) : 0.00);

          }else{
            DB::table("visa_apply_applicant")->where('id',$value->id)->delete();
          }
        }

        for ($i=1; $i <= $request['totalCount'] ; $i++) {
          if(isset($request['applicant_nationality'.$i])){
              $visaDataSet[] = [
                 "order_id" => $orderId,
                 "first_name" => $request['applicant_first_name'.$i],
                 "last_name" => $request['applicant_last_name'.$i],
                 "type_of_visa" => $request['visaType'],
                 "nationality" => $request['applicant_nationality'.$i],
                 "visa_process_type" => $request['visa_process_type'],
                 "date_of_birth" =>date('Y-m-d H:m:s',strtotime($request['applicant_dob_year'.$i].'-'.$request['applicant_dob_month'.$i].'-'.$request['applicant_dob_date'.$i])),
                 "gender" => $request['applicant_gender'.$i],
                 "applicant_country_birth" => $request['applicant_country_birth'.$i],
                 "applicant_country_residence" => $request['applicant_country_residence'.$i],
                 "applicant_phone" => $request['applicant_phone'.$i],
                 "passport_issue_date" => date('Y-m-d H:m:s',strtotime($request['applicant_passport_issue_year'.$i].'-'.$request['applicant_passport_issue_month'.$i].'-'.$request['applicant_passport_issue_date'.$i])),
                 "passport_expiry_date" => date('Y-m-d H:m:s',strtotime($request['applicant_passport_year'.$i].'-'.$request['applicant_passport_month'.$i].'-'.$request['applicant_passport_date'.$i])),
                 "applicant_payment" => floatval($allVisaData[$request['visaType']]['country'][$request['applicant_nationality'.$i]]['USD'][$request['visa_process_type']]) ,
                 "govt_fee" => (isset($visaData->is_govt_apply) && $visaData->is_govt_apply == '1') ? floatval($allVisaData[$request['visaType']]['country'][$request['applicant_nationality'.$i]]['USD']['govt']) : 0.00 ,
              ];
              $total_payment += floatval($allVisaData[$request['visaType']]['country'][$request['applicant_nationality'.$i]]['USD'][$request['visa_process_type']])+ ((isset($visaData->is_govt_apply) && $visaData->is_govt_apply == '1') ? floatval($allVisaData[$request['visaType']]['country'][$request['applicant_nationality'.$i]]['USD']['govt']) : 0.00);
            }
        }

        DB::table("visa_apply_detail")->where('order_id',$request->order_id)->update([
          "order_id" => $orderId,
          "email_id" => $request['email'],
          "visa_country_name" => $visaDetail->visa_country_name,
          "arrival_date" => date('Y-m-d',strtotime($request['arrival_year'].'-'.$request['arrival_month'].'-'.$request['arrival_date'])),
          "departure_date" => date('Y-m-d',strtotime($request['departure_year'].'-'.$request['departure_month'].'-'.$request['departure_date'])),
          "type_of_visa" => $request['visaType'],
          "visa_process_type" => $request['visa_process_type'],
          "port_of_arrival" =>$request['port_arrival'],
          "contact_no" => $request['phone'],
          "country_live" => $request['livincountry'],
          "slug" => $slug,
          "total_payment" => $total_payment,
        ]);
        DB::table("visa_apply_applicant")->insert($visaDataSet);

        $data = [
          'email' =>  $request['email'],
          'slug' => $slug
        ];
        $this->sendNotificationMail($data);

        return redirect()->route('apply.review', ['slug' => $slug]);
    }


    public function applyContactUs(Request $request){
        $data = ["status"=>true];
        DB::table('visa_contact_us')->insert([
            'language_id' => env('APP_LANG'),
            'name' => $request['name'],
            'email' => $request['email'],
            'contact_number' => $request['mobile'],
            'message' => $request['msg'],
            'visa_country' => strtolower($request['visa_country']),
            'nationality' => strtolower($request['nationality']),
            'submission_date' => date('Y-m-d H:i:s')
        ]);
        return json_encode($data);
    }
}

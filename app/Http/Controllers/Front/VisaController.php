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

      $default_visa = isset($_COOKIE['go_country']) ? $_COOKIE['go_country'] : env('APP_DEFAULT_COUNTRY');
      $default_nationality = isset($_COOKIE['from_country']) ? $_COOKIE['from_country'] : env('APP_DEFAULT_COUNTRY');

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
        'visa_pages.visa_nationality_title as visa_nationality_title',
        'visa_pages.visa_type_title as visa_type_title',
        'visa_pages.visa_popular_title as visa_popular_title',
        'route_visa.visa_url as visa_url'
        )
      ->where('visa_pages.language_id',env('APP_LANG'))
      ->where('route_visa.visa_url',$uri)
      ->join("route_visa","route_visa.visa_id","=","visa_pages.id")
      ->first();

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
      $allVisaData = [];
      $currencyRate = DB::table('currency_rate')->where('language_id',env('APP_LANG'))->get();

      $tempVisaTable = DB::table('visa_type_detail')
                      ->where('visa_country_name',$visaData->country_name)
                      ->where('language_id',env('APP_LANG'))
                      ->get();

      foreach ($tempVisaTable as $key => $value) {

        $allVisaData[strtolower($value->nationality_name)][$value->visa_type_name]['USD']['standard'] = number_format($value->standard_usd_price,2);
        $allVisaData[strtolower($value->nationality_name)][$value->visa_type_name]['USD']['rush'] = number_format($value->rush_usd_price,2);
        $allVisaData[strtolower($value->nationality_name)][$value->visa_type_name]['USD']['express'] = number_format($value->express_usd_price,2);
        $allVisaData[strtolower($value->nationality_name)][$value->visa_type_name]['USD']['govt'] = number_format($value->govt_fee,2);

        foreach ($currencyRate as $key2 => $value2) {

          $allVisaData[strtolower($value->nationality_name)][$value->visa_type_name][strtoupper($value2->code)]['standard'] = number_format($value2->rate * $value->standard_usd_price,2);

          $allVisaData[strtolower($value->nationality_name)][$value->visa_type_name][strtoupper($value2->code)]['rush'] = number_format($value2->rate * $value->rush_usd_price,2);

          $allVisaData[strtolower($value->nationality_name)][$value->visa_type_name][strtoupper($value2->code)]['express'] = number_format($value2->rate * $value->express_usd_price,2);

          $allVisaData[strtolower($value->nationality_name)][$value->visa_type_name][strtoupper($value2->code)]['govt'] = number_format($value2->rate * $value->govt_fee,2);

        }

      }

      $isAvailable = false;
      if(isset($tempVisaTable[0])){
        $isAvailable = true;
      }

      return view('front.visa.page',compact('visaData','visaFaqs','allVisaData','isAvailable','visaProcessingType','default_visa','default_nationality'));

    }

    public function applyOnline($url)
    {
        $countryFound = false;
        $default_currency = env('APP_DEFAULT_CURRENCY');
        $default_visa = isset($_COOKIE['go_country']) ? strtolower($_COOKIE['go_country']) : env('APP_DEFAULT_COUNTRY');
        $default_nationality = isset($_COOKIE['from_country']) ? strtolower($_COOKIE['from_country']) : env('APP_DEFAULT_COUNTRY');

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
          'route_visa.visa_url as visa_url'
          )
        ->where('visa_pages.language_id',env('APP_LANG'))
        ->where('route_visa.visa_url',$url)
        ->join("route_visa","route_visa.visa_id","=","visa_pages.id")
        ->first();

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
        $default_visa_type = "";
        foreach ($tempVisaTable as $key => $value) {

          if(!$tempCheck && $default_nationality == strtolower($value->nationality_name)){
              $tempCheck = true;
              $default_visa_type = $value->visa_type_name;
          }
          $allVisaData[$value->visa_type_name]['country'][strtolower($value->nationality_name)]['USD']['standard'] = number_format($value->standard_usd_price,2);
          $allVisaData[$value->visa_type_name]['country'][strtolower($value->nationality_name)]['USD']['rush'] = number_format($value->rush_usd_price,2);
          $allVisaData[$value->visa_type_name]['country'][strtolower($value->nationality_name)]['USD']['express'] = number_format($value->express_usd_price,2);
          $allVisaData[$value->visa_type_name]['country'][strtolower($value->nationality_name)]['USD']['govt'] = number_format($value->govt_fee,2);
          //-------------------------------------------------------------------------------------------------------------------

          $allVisaDataAlter[strtolower($value->nationality_name)][$value->visa_type_name]['USD']['standard'] = number_format($value->standard_usd_price,2);
          $allVisaDataAlter[strtolower($value->nationality_name)][$value->visa_type_name]['USD']['rush'] = number_format($value->rush_usd_price,2);
          $allVisaDataAlter[strtolower($value->nationality_name)][$value->visa_type_name]['USD']['express'] = number_format($value->express_usd_price,2);
          $allVisaDataAlter[strtolower($value->nationality_name)][$value->visa_type_name]['USD']['govt'] = number_format($value->govt_fee,2);


          foreach ($currencyRate as $key2 => $value2) {

            $allVisaData[$value->visa_type_name]['country'][strtolower($value->nationality_name)][strtoupper($value2->code)]['standard'] = number_format($value2->rate * $value->standard_usd_price,2);

            $allVisaData[$value->visa_type_name]['country'][strtolower($value->nationality_name)][strtoupper($value2->code)]['rush'] = number_format($value2->rate * $value->rush_usd_price,2);

            $allVisaData[$value->visa_type_name]['country'][strtolower($value->nationality_name)][strtoupper($value2->code)]['express'] = number_format($value2->rate * $value->express_usd_price,2);

            $allVisaData[$value->visa_type_name]['country'][strtolower($value->nationality_name)][strtoupper($value2->code)]['govt'] = number_format($value2->rate * $value->govt_fee,2);
            //-------------------------------------------------------------------------------------------------------------------
            $allVisaDataAlter[strtolower($value->nationality_name)][$value->visa_type_name][strtoupper($value2->code)]['standard'] = number_format($value2->rate * $value->standard_usd_price,2);

            $allVisaDataAlter[strtolower($value->nationality_name)][$value->visa_type_name][strtoupper($value2->code)]['rush'] = number_format($value2->rate * $value->rush_usd_price,2);

            $allVisaDataAlter[strtolower($value->nationality_name)][$value->visa_type_name][strtoupper($value2->code)]['express'] = number_format($value2->rate * $value->express_usd_price,2);

            $allVisaDataAlter[strtolower($value->nationality_name)][$value->visa_type_name][strtoupper($value2->code)]['govt'] = number_format($value2->rate * $value->govt_fee,2);
          }

        }

        return view('front.apply.calculator',compact('allVisaData','visaProcessingType','portOfArrival','countryName','default_visa_type','default_nationality','default_visa','default_currency','currencyRate','allVisaDataAlter'));

    }

    public function applyOnlineSave(Request $request){
        // exit(print_r($request->all()));
        $allVisaData = [];
        $total_payment = 0.0;
        $default_currency = env('APP_DEFAULT_CURRENCY');
        $default_visa = isset($_COOKIE['go_country']) ? strtolower($_COOKIE['go_country']) : env('APP_DEFAULT_COUNTRY');
        $default_nationality = isset($_COOKIE['from_country']) ? strtolower($_COOKIE['from_country']) : env('APP_DEFAULT_COUNTRY');

        $currencyRate = DB::table('currency_rate')->where('language_id',env('APP_LANG'))->get();

        $tempVisaTable = DB::table('visa_type_detail')
                        ->where('visa_country_name',strtolower($default_visa))
                        ->where('language_id',env('APP_LANG'))
                        ->get();

        foreach ($tempVisaTable as $key => $value) {
          $allVisaData[$value->visa_type_name]['country'][strtolower($value->nationality_name)]['USD']['standard'] = number_format($value->standard_usd_price,2);
          $allVisaData[$value->visa_type_name]['country'][strtolower($value->nationality_name)]['USD']['rush'] = number_format($value->rush_usd_price,2);
          $allVisaData[$value->visa_type_name]['country'][strtolower($value->nationality_name)]['USD']['express'] = number_format($value->express_usd_price,2);
          $allVisaData[$value->visa_type_name]['country'][strtolower($value->nationality_name)]['USD']['govt'] = number_format($value->govt_fee,2);

          foreach ($currencyRate as $key2 => $value2) {

            $allVisaData[$value->visa_type_name]['country'][strtolower($value->nationality_name)][strtoupper($value2->code)]['standard'] = number_format($value2->rate * $value->standard_usd_price,2);

            $allVisaData[$value->visa_type_name]['country'][strtolower($value->nationality_name)][strtoupper($value2->code)]['rush'] = number_format($value2->rate * $value->rush_usd_price,2);

            $allVisaData[$value->visa_type_name]['country'][strtolower($value->nationality_name)][strtoupper($value2->code)]['express'] = number_format($value2->rate * $value->express_usd_price,2);

            $allVisaData[$value->visa_type_name]['country'][strtolower($value->nationality_name)][strtoupper($value2->code)]['govt'] = number_format($value2->rate * $value->govt_fee,2);

          }

        }

        $temId = $this->generateBarcodeNumber();
        $orderId = env('APP_ORDER_PREFIX').$temId;
        $slug = Str::slug($orderId);
        $visaData = [];
        for ($i=1; $i <= $request['totalCount'] ; $i++) {
          if(isset($request['applicant_nationality'.$i])){
              $visaData[] = [
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
                 "govt_fee" => floatval($allVisaData[$request['visaType']]['country'][$request['applicant_nationality'.$i]]['USD']['govt']) ,
              ];
              $total_payment += floatval($allVisaData[$request['visaType']]['country'][$request['applicant_nationality'.$i]]['USD'][$request['visa_process_type']])+ floatval($allVisaData[$request['visaType']]['country'][$request['applicant_nationality'.$i]]['USD']['govt']);
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
        DB::table("visa_apply_applicant")->insert($visaData);

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
        $count =DB::table('visa_apply_detail')->where('order_id',$number)->count();
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


      return view('front.apply.review');
    }
}

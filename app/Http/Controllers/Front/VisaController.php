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
      $tableName = DB::table('visa_type_name')->where('language_id',env('APP_LANG'))->get();
      $currencyRate = DB::table('currency_rate')->where('language_id',env('APP_LANG'))->get();
      foreach ($tableName as $key => $value) {
         $tempVisaTable = DB::table(strtolower($value->visa_type_table))->get();
         foreach ($tempVisaTable as $key1 => $value1) {
            $allVisaData[strtolower($value1->country_name)][$value->visa_type_name]['USD']['standard'] = number_format($value1->st_usd_price,2);
            $allVisaData[strtolower($value1->country_name)][$value->visa_type_name]['USD']['rush'] = number_format($value1->ru_usd_price,2);
            $allVisaData[strtolower($value1->country_name)][$value->visa_type_name]['USD']['superrush'] = number_format($value1->super_ru_usd_price,2);
            foreach ($currencyRate as $key2 => $value2) {
              $allVisaData[strtolower($value1->country_name)][$value->visa_type_name][strtoupper($value2->code)]['standard']   = number_format($value2->rate * $value1->st_usd_price,2);
              $allVisaData[strtolower($value1->country_name)][$value->visa_type_name][strtoupper($value2->code)]['rush']      = number_format($value2->rate * $value1->ru_usd_price,2);
              $allVisaData[strtolower($value1->country_name)][$value->visa_type_name][strtoupper($value2->code)]['superrush'] = number_format($value2->rate * $value1->super_ru_usd_price,2);

            }

         }
      }
      $isAvailable = false;
      if(array_key_exists(strtolower($visaData->country_name),$allVisaData)){
        $isAvailable = true;
      }
      // exit(print_r($allVisaData));
      return view('front.visa.page',compact('visaData','visaFaqs','allVisaData','isAvailable','visaProcessingType'));

    }

    public function applyOnline($country)
    {
        $countryFound = false;
        $visaProcessingType = DB::table('visa_process_type')
                              ->select('visa_process_type.name as name','visa_process_type.duration as duration','duration_type.name as duration_type')
                              ->where('visa_process_type.language_id',env('APP_LANG'))
                              ->where('visa_process_type.name',env('APP_VISA_TYPE'))
                              ->join("duration_type","duration_type.id","=","visa_process_type.duration_type_id")
                              ->get();

        $portOfArrival = DB::table('port_of_arrival')
                              ->where('port_of_arrival.language_id',env('APP_LANG'))
                              ->get();

        $countryName = DB::table('country')
                              ->where('country.language_id',env('APP_LANG'))
                              ->get();
        $allVisaData = [];
        $tableName = DB::table('visa_type_name')->where('language_id',env('APP_LANG'))->get();
        $currencyRate = DB::table('currency_rate')->where('language_id',env('APP_LANG'))->get();
        foreach ($tableName as $key => $value) {
           $tempVisaTable = DB::table(strtolower($value->visa_type_table))->get();
           $allVisaData[$value->id]['name'] = $value->visa_type_name;
           foreach ($tempVisaTable as $key1 => $value1) {
              $allVisaData[$value->id]['country'][strtolower($value1->country_name)]['USD']['standard'] = number_format($value1->st_usd_price,2);
              $allVisaData[$value->id]['country'][strtolower($value1->country_name)]['USD']['rush'] = number_format($value1->ru_usd_price,2);
              $allVisaData[$value->id]['country'][strtolower($value1->country_name)]['USD']['superrush'] = number_format($value1->super_ru_usd_price,2);
              foreach ($currencyRate as $key2 => $value2) {
                $allVisaData[$value->id]['country'][strtolower($value1->country_name)][strtoupper($value2->code)]['standard']   = number_format($value2->rate * $value1->st_usd_price,2);
                $allVisaData[$value->id]['country'][strtolower($value1->country_name)][strtoupper($value2->code)]['rush']      = number_format($value2->rate * $value1->ru_usd_price,2);
                $allVisaData[$value->id]['country'][strtolower($value1->country_name)][strtoupper($value2->code)]['superrush'] = number_format($value2->rate * $value1->super_ru_usd_price,2);
              }

           }
        }

        return view('front.apply.calculator',compact('allVisaData','visaProcessingType','portOfArrival','countryName'));

    }

    public function applyOnlineSave(Request $request){
        // exit(print_r($request->all()));
        $allVisaData = [];
        $total_payment = 0.0;
        $tableName = DB::table('visa_type_name')->where('language_id',env('APP_LANG'))->get();
        $currencyRate = DB::table('currency_rate')->where('language_id',env('APP_LANG'))->get();
        foreach ($tableName as $key => $value) {
           $tempVisaTable = DB::table(strtolower($value->visa_type_table))->get();
           $allVisaData[$value->id]['name'] = $value->visa_type_name;
           foreach ($tempVisaTable as $key1 => $value1) {
              $allVisaData[$value->id]['country'][strtolower($value1->country_name)]['USD']['standard'] = number_format($value1->st_usd_price,2);
              $allVisaData[$value->id]['country'][strtolower($value1->country_name)]['USD']['rush'] = number_format($value1->ru_usd_price,2);
              $allVisaData[$value->id]['country'][strtolower($value1->country_name)]['USD']['superrush'] = number_format($value1->super_ru_usd_price,2);
              foreach ($currencyRate as $key2 => $value2) {
                $allVisaData[$value->id]['country'][strtolower($value1->country_name)][strtoupper($value2->code)]['standard']  = number_format($value2->rate * $value1->st_usd_price,2);
                $allVisaData[$value->id]['country'][strtolower($value1->country_name)][strtoupper($value2->code)]['rush']      = number_format($value2->rate * $value1->ru_usd_price,2);
                $allVisaData[$value->id]['country'][strtolower($value1->country_name)][strtoupper($value2->code)]['superrush'] = number_format($value2->rate * $value1->super_ru_usd_price,2);
              }

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
                 "type_of_visa_id" => $request['visaTypeId'],
                 "nationality" => $request['applicant_nationality'.$i],
                 "visa_process_type" => $request['visa_process_type'],
                 "date_of_birth" =>date('Y-m-d H:m:s',strtotime($request['applicant_dob_year'.$i].'-'.$request['applicant_dob_month'.$i].'-'.$request['applicant_dob_date'.$i])),
                 "gender" => $request['applicant_gender'.$i],
                 "passport_expiry_date" => date('Y-m-d H:m:s',strtotime($request['applicant_passport_year'.$i].'-'.$request['applicant_passport_month'.$i].'-'.$request['applicant_passport_date'.$i])),
                 "applicant_payment" => floatval($allVisaData[$request['visaTypeId']]['country'][$request['applicant_nationality'.$i]]['USD'][$request['visa_process_type']]),
              ];
              $total_payment += floatval($allVisaData[$request['visaTypeId']]['country'][$request['applicant_nationality'.$i]]['USD'][$request['visa_process_type']]);
            }
        }

        DB::table("visa_apply_detail")->insert([
          "order_id" => $orderId,
          "email_id" => $request['email'],
          "arrival_date" => date('Y-m-d',strtotime($request['arrival_year'].'-'.$request['arrival_month'].'-'.$request['arrival_date'])),
          "departure_date" => date('Y-m-d',strtotime($request['departure_year'].'-'.$request['departure_month'].'-'.$request['departure_date'])),
          "type_of_visa_id" => $request['visaTypeId'],
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

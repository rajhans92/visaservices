<?php

namespace App\Http\Controllers\Front;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

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
         $tempVisaTable = DB::table($value->visa_type_table)->get();
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
      // code...
    }
}

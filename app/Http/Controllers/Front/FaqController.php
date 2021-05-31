<?php

namespace App\Http\Controllers\Front;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Mail\ApplyNotificationMail;

class FaqController extends Controller
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


    public function pages(Request $request){

      $data = [];

      $data = DB::table('faq_section')->where('language_id',env('APP_LANG'))->get();
      // exit(print_r($mainDataSet));
      $secondDropdown = DB::table('country')
      ->select(
          'country.id as id',
          'country.country_name as country_name',
          'country.country_code as country_code',
          'route_visa.visa_url as visa_url'
        )
      ->where('country.language_id',env('APP_LANG'))
      ->where('route_visa.type_of_url',"visa")
      ->whereIn('country.country_name',function($db){
        $db->select('visa_pages.country_name')
            ->from('visa_pages')
            ->where('visa_pages.language_id',env('APP_LANG'))
            ->where('route_visa.type_of_url',"visa")
            ->join('route_visa','route_visa.visa_id',"=","visa_pages.id");
      })
      ->join('visa_pages','visa_pages.country_name',"=","country.country_name")
      ->join('route_visa','route_visa.visa_id',"=","visa_pages.id")
      ->get();

      $homeData = DB::table('home_page')
      ->join('home_client_review','home_client_review.language_id','=','home_page.language_id')
      ->join('home_section_2','home_section_2.language_id','=','home_page.language_id')
      ->join('home_section_3','home_section_3.language_id','=','home_page.language_id')
      ->join('home_info_section','home_info_section.language_id','=','home_page.language_id')
      ->where('home_page.language_id',env('APP_LANG'))
      ->first();

      $footerData = DB::table('footer_detail')
      ->where('footer_detail.language_id',env('APP_LANG'))
      ->first();


      return view('front.faq.detail',compact('data','secondDropdown','homeData','footerData'));

    }

}

<?php

namespace App\Http\Controllers\Front;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class LandingController extends Controller
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
    public function index()
    {
      $homeData = DB::table('home_page')
      ->join('home_client_review','home_client_review.language_id','=','home_page.language_id')
      ->join('home_section_2','home_section_2.language_id','=','home_page.language_id')
      ->join('home_section_3','home_section_3.language_id','=','home_page.language_id')
      ->join('home_info_section','home_info_section.language_id','=','home_page.language_id')
      ->where('home_page.language_id',env('APP_LANG'))
      ->first();
      $section2Data = DB::table('home_page')
      ->join('home_section_2','home_section_2.language_id','=','home_page.language_id')
      ->where('home_page.language_id',env('APP_LANG'))
      ->first();

      $mainData = DB::table('home_page')
      ->select('home_page.id as id',
      'home_page.language_id as language_id',
      'home_page.main_title_1 as main_title_1',
      'home_page.main_title_2 as main_title_2',
      'home_page.main_img as main_img',
      'home_page.dropdown_1 as dropdown_1',
      'home_page.dropdown_2 as dropdown_2',
      'home_page.main_button_name as main_button_name',
      'home_page.popular as popular',
      'home_popular_section.title_1 as title_1',
      'home_popular_section.title_2 as title_2',
      'home_popular_section.title_3 as title_3',
      'home_popular_section.title_4 as title_4',
      'home_popular_section.link_1 as link_1',
      'home_popular_section.link_2 as link_2',
      'home_popular_section.link_3 as link_3',
      'home_popular_section.link_4 as link_4'
      )
      ->join('home_popular_section','home_popular_section.language_id','=','home_page.language_id')
      ->where('home_page.language_id',env('APP_LANG'))
      ->first();

      $countryData = DB::table('country')
      ->where('country.language_id',env('APP_LANG'))
      ->get();

      $countryVisa = [];
      if(isset($countryData[0]->id)){
        $countryVisa = DB::table('country')
        ->select(
            'country.id as id',
            'country.country_name as country_name',
            'country.country_code as country_code',
            'country.country_flag as country_flag',
            'route_visa.visa_url as visa_url'
          )
        ->where('country.language_id',env('APP_LANG'))
        ->where('country_popular_visa.country_name_one',$countryData[0]->country_name)
        ->whereIn('country_popular_visa.country_name_many',function($db){
          $db->select('visa_pages.country_name')
              ->from('visa_pages')
              ->where('visa_pages.language_id',env('APP_LANG'))
              ->join('route_visa','route_visa.visa_id',"=","visa_pages.id");
        })
        ->join('country_popular_visa','country_popular_visa.country_name_many',"=",'country.country_name')
        ->join('visa_pages','visa_pages.country_name',"=","country.country_name")
        ->join('route_visa','route_visa.visa_id',"=","visa_pages.id")
        ->get();
      }

      $secondDropdown = DB::table('country')
      ->select(
          'country.id as id',
          'country.country_name as country_name',
          'country.country_code as country_code',
          'route_visa.visa_url as visa_url'
        )
      ->where('country.language_id',env('APP_LANG'))
      ->whereIn('country.country_name',function($db){
        $db->select('visa_pages.country_name')
            ->from('visa_pages')
            ->where('visa_pages.language_id',env('APP_LANG'))
            ->join('route_visa','route_visa.visa_id',"=","visa_pages.id");
      })
      ->join('visa_pages','visa_pages.country_name',"=","country.country_name")
      ->join('route_visa','route_visa.visa_id',"=","visa_pages.id")
      ->get();

      $temp = "";
      $count = 1;
      foreach ($countryVisa as $key => $value) {
        if( $count%2 != 0){
          $temp .= '<li><div class="flag-main"> <div class="flag-image"> <img src="'.url('images/country/'.$value->country_flag).'" /> </div> <div class="cont"> <h6>'.$value->country_name.'</h6> <a href="'. url("/".$value->visa_url) .'">'.$homeData->section_button_name.'</a> </div> </div>';
        }else{
          $temp .= '<div class="flag-main"> <div class="flag-image"> <img src="'.url('images/country/'.$value->country_flag).'" /> </div> <div class="cont"> <h6>'.$value->country_name.'</h6> <a href="'. url("/".$value->visa_url) .'">'.$homeData->section_button_name.'</a> </div> </div></li>';
        }
        $count++;
        // code...
      }
      // exit(print_r($countryVisa));
      return view('front.home',compact('homeData','section2Data','mainData','countryData','secondDropdown','temp'));
    }

    public function apiCountryList($country){
      $data = ['status'=>false,'data'=>""];
      $homeData = DB::table('home_page')
      ->join('home_client_review','home_client_review.language_id','=','home_page.language_id')
      ->join('home_section_2','home_section_2.language_id','=','home_page.language_id')
      ->join('home_section_3','home_section_3.language_id','=','home_page.language_id')
      ->join('home_info_section','home_info_section.language_id','=','home_page.language_id')
      ->where('home_page.language_id',env('APP_LANG'))
      ->first();
      $countryVisa = DB::table('country')
      ->select(
          'country.id as id',
          'country.country_name as country_name',
          'country.country_code as country_code',
          'country.country_flag as country_flag',
          'route_visa.visa_url as visa_url'
        )
      ->where('country.language_id',env('APP_LANG'))
      ->where('country_popular_visa.country_name_one',$country)
      ->whereIn('country_popular_visa.country_name_many',function($db){
        $db->select('visa_pages.country_name')
            ->from('visa_pages')
            ->where('visa_pages.language_id',env('APP_LANG'))
            ->join('route_visa','route_visa.visa_id',"=","visa_pages.id");
      })
      ->join('country_popular_visa','country_popular_visa.country_name_many',"=",'country.country_name')
      ->join('visa_pages','visa_pages.country_name',"=","country.country_name")
      ->join('route_visa','route_visa.visa_id',"=","visa_pages.id")
      ->get();

      $temp = "";
      $count = 1;
      foreach ($countryVisa as $key => $value) {
        if( $count%2 != 0){
          $temp .= '<li><div class="flag-main"> <div class="flag-image"> <img src="'.url('images/country/'.$value->country_flag).'" /> </div> <div class="cont"> <h6>'.$value->country_name.'</h6> <a href="'. url("/".$value->visa_url) .'">'.$homeData->section_button_name.'</a> </div> </div>';
        }else{
          $temp .= '<div class="flag-main"> <div class="flag-image"> <img src="'.url('images/country/'.$value->country_flag).'" /> </div> <div class="cont"> <h6>'.$value->country_name.'</h6> <a href="'. url("/".$value->visa_url) .'">'.$homeData->section_button_name.'</a> </div> </div></li>';
        }
        $count++;
        // code...
      }
      if( $temp != "" ){
        $data['status'] = true;
        $data['data'] = $temp;
      }
      return json_encode($data);
    }
}

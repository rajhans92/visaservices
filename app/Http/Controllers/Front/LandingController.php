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

      return view('front.home',compact('homeData','section2Data','mainData'));
    }
}

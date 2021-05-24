<?php

namespace App\Http\Controllers\Front;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Mail\ApplyNotificationMail;

class EmbassiesController extends Controller
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
    public function embassiesList(Request $request){

      $dataEmbassies = DB::table('embassies')->get();
      $data = [];
      foreach ($dataEmbassies as $key => $value) {

         $data[strtolower(substr($value->name,0,1))][] = ['name'=> $value->name,'url' => $value->url];
      }
        // exit(print_r($data));
      return view('front.embassies.list',compact('data'));

    }

    public function embassiesListById(Request $request){
      $uri = $request->path();
      $embassy = DB::table('embassies')->where('url',$uri)->first();
      if(!isset($embassy->id)){
        return redirect()->back();
      }
      $data = [];
      $data = DB::table('embassies')->get();
      $embassyList = DB::table('embassies_detail')->where('embassies_id',$embassy->id)->get();

      $embassyListData = [];
      foreach ($embassyList as $key => $value) {
        // code...
        $embassyListData[$value->embassy_in] = $value->embassy_in;
      }

      $mainDataSet = [];
      foreach ($data as $key => $value) {
          $temp = DB::table('embassies_detail')->where('embassies_id',$value->id)->get();
          $tempData = [];
          foreach ($temp as $key1 => $value1) {
            $tempData[$value1->embassy_in][] = $value1;
          }
          $mainDataSet[$value->id] = $tempData;
      }
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


      return view('front.embassies.detail',compact('embassyList','data','embassy','secondDropdown','homeData','footerData','mainDataSet','embassyListData'));

    }

}

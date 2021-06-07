<?php

namespace App\Http\Controllers\Front;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Mail\ApplyNotificationMail;

class BlogController extends Controller
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


    public function blogList(Request $request){

      $data = [];

      $blogData = DB::table('blog_pages')
      ->select(
        'blog_pages.id as id',
        'blog_pages.category_id as category_id',
        'blog_pages.blog_name as blog_name',
        'blog_pages.blog_heading as blog_heading',
        'route_visa.visa_url as visa_url'
        )
      ->where('blog_pages.language_id',env('APP_LANG'))
      ->where("route_visa.type_of_url","blog")
      ->join("route_visa","route_visa.visa_id","=","blog_pages.id")
      ->get();

      $blogCategory = DB::table('blog_category')->where('language_id',env('APP_LANG'))->get();

      foreach ($blogData as $key => $value) {
        $data[$value->category_id][]= [
          "id" => $value->id,
          "heading" => $value->blog_heading,
          "visa_url" => $value->visa_url
        ];
      }

      $countryData = DB::table('country')
      ->where('country.language_id',env('APP_LANG'))
      ->get();

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

      $categoryId = isset($blogCategory[0]->id) ? $blogCategory[0]->id : 0;

      if ($request->has('id')) {

        $check = DB::table('blog_category')->where('language_id',env('APP_LANG'))->where('id',$request->input('id'))->first();

        if(isset($check->id)){
          $categoryId = $request->input('id');
        }

      }

      return view('front.blog.blogList',compact('data','secondDropdown','homeData','footerData','countryData','blogCategory','categoryId'));

    }

    public function pages(Request $request)
    {
      $uri = $request->path();
      $blogData = DB::table('blog_pages')
      ->select(
        'blog_pages.id as id',
        'blog_pages.category_id as category_id',
        'blog_pages.blog_name as blog_name',
        'blog_pages.blog_heading as blog_heading',
        'blog_pages.landing_img as landing_img',
        'blog_pages.main_button_url as main_button_url',
        'blog_pages.content_1 as content_1',
        'blog_pages.content_2 as content_2',
        'blog_pages.meta_title as meta_title',
        'blog_pages.meta_description as meta_description',
        'blog_pages.meta_keywords as meta_keywords',
        'blog_pages.whatsapp_number as whatsapp_number',
        'blog_pages.whatsapp_status as whatsapp_status',
        'blog_pages.call_number as call_number',
        'blog_pages.call_status as call_status',
        'blog_pages.whatsapp_text as whatsapp_text',
        'route_visa.visa_url as visa_url'
        )
      ->where('blog_pages.language_id',env('APP_LANG'))
      ->where('route_visa.visa_url',$uri)
      ->where("route_visa.type_of_url","blog")
      ->join("route_visa","route_visa.visa_id","=","blog_pages.id")
      ->first();

      if(!isset($blogData->id)){
        return redirect("/");
      }
      $blogCategory = DB::table('blog_category')->get();

      $blogPages = DB::table('blog_pages')
      ->select(
        'blog_pages.id as id',
        'blog_pages.category_id as category_id',
        'blog_pages.blog_name as blog_name',
        'blog_pages.blog_heading as blog_heading',
        'blog_pages.landing_img as landing_img',
        'blog_pages.main_button_url as main_button_url',
        'blog_pages.content_1 as content_1',
        'blog_pages.content_2 as content_2',
        'blog_pages.meta_title as meta_title',
        'blog_pages.meta_description as meta_description',
        'blog_pages.meta_keywords as meta_keywords',
        'blog_pages.whatsapp_number as whatsapp_number',
        'blog_pages.whatsapp_status as whatsapp_status',
        'blog_pages.call_number as call_number',
        'blog_pages.call_status as call_status',
        'blog_pages.whatsapp_text as whatsapp_text',
        'route_visa.visa_url as visa_url'
        )
      ->where('blog_pages.language_id',env('APP_LANG'))
      ->where('blog_pages.category_id',$blogData->category_id)
      ->where("route_visa.type_of_url","blog")
      ->join("route_visa","route_visa.visa_id","=","blog_pages.id")
      ->get();

      return view('front.blog.pages',compact('blogData','blogPages','blogCategory'));

    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.home.list');
    }

    public function searchSection($lang_id){

      return view('admin.home.searchSection',compact(''));
    }

    public function clientReview($lang_id){

      $homeData = DB::table('home_page')
      ->select('home_page.id as id',
      'home_page.language_id as language_id',
      'home_page.section_4_title as section_4_title',
      'home_client_review.client_name_1 as client_name_1',
      'home_client_review.client_review_1 as client_review_1',
      'home_client_review.client_img_1 as client_img_1',
      'home_client_review.client_name_2 as client_name_2',
      'home_client_review.client_review_2 as client_review_2',
      'home_client_review.client_img_2 as client_img_2',
      'home_client_review.client_name_3 as client_name_3',
      'home_client_review.client_review_3 as client_review_3',
      'home_client_review.client_img_3 as client_img_3',
      'home_client_review.client_name_4 as client_name_4',
      'home_client_review.client_review_4 as client_review_4',
      'home_client_review.client_img_4 as client_img_4'
      )
      ->join('home_client_review','home_client_review.language_id','=','home_page.language_id')
      ->where('home_page.language_id',$lang_id)
      ->first();
      return view('admin.home.clientReview',compact('homeData'));
    }

    public function clientReviewUpdate(Request $request, $lang_id)
    {
        $data =  [
             'section_4_title' => $request['section_4_title']
          ];

        DB::table('home_page')->where('language_id','=',$lang_id)->update($data);
        $homeData = DB::table('home_page')
        ->select('home_page.id as id',
        'home_page.language_id as language_id',
        'home_page.section_4_title as section_4_title',
        'home_client_review.client_name_1 as client_name_1',
        'home_client_review.client_review_1 as client_review_1',
        'home_client_review.client_img_1 as client_img_1',
        'home_client_review.client_name_2 as client_name_2',
        'home_client_review.client_review_2 as client_review_2',
        'home_client_review.client_img_2 as client_img_2',
        'home_client_review.client_name_3 as client_name_3',
        'home_client_review.client_review_3 as client_review_3',
        'home_client_review.client_img_3 as client_img_3',
        'home_client_review.client_name_4 as client_name_4',
        'home_client_review.client_review_4 as client_review_4',
        'home_client_review.client_img_4 as client_img_4'
        )
        ->join('home_client_review','home_client_review.language_id','=','home_page.language_id')
        ->where('home_page.language_id',$lang_id)
        ->first();

        $data = [];
        if ($request->hasFile('client_img_1')) {
            if($homeData->client_img_1 != ""){
              $oldImagePath = public_path('images/home/').$homeData->client_img_1;
              if (file_exists($oldImagePath)) {
                @unlink($oldImagePath);
              }
            }
            $images = $request->client_img_1->getClientOriginalName();
            $images = time().'_client_'.$images; // Add current time before image name
            $client_img_1 = $images;
            $request->client_img_1->move(public_path('images/home'),$client_img_1);
            $data['client_img_1'] = $client_img_1;
        }
        if ($request->hasFile('client_img_2')) {
            if($homeData->client_img_2 != ""){
              $oldImagePath = public_path('images/home/').$homeData->client_img_2;
              if (file_exists($oldImagePath)) {
                @unlink($oldImagePath);
              }
            }
            $images = $request->client_img_2->getClientOriginalName();
            $images = time().'_client_'.$images; // Add current time before image name
            $client_img_2 = $images;
            $request->client_img_2->move(public_path('images/home'),$client_img_2);
            $data['client_img_2'] = $client_img_2;
        }
        if ($request->hasFile('client_img_3')) {
            if($homeData->client_img_3 != ""){
              $oldImagePath = public_path('images/home/').$homeData->client_img_3;
              if (file_exists($oldImagePath)) {
                @unlink($oldImagePath);
              }
            }
            $images = $request->client_img_3->getClientOriginalName();
            $images = time().'_client_'.$images; // Add current time before image name
            $client_img_3 = $images;
            $request->client_img_3->move(public_path('images/home'),$client_img_3);
            $data['client_img_3'] = $client_img_3;
        }

        if ($request->hasFile('client_img_4')) {
            if($homeData->client_img_4 != ""){
              $oldImagePath = public_path('images/home/').$homeData->client_img_4;
              if (file_exists($oldImagePath)) {
                @unlink($oldImagePath);
              }
            }
            $images = $request->client_img_4->getClientOriginalName();
            $images = time().'_client_'.$images; // Add current time before image name
            $client_img_4 = $images;
            $request->client_img_4->move(public_path('images/home'),$client_img_4);
            $data['client_img_4'] = $client_img_4;
        }
        $data['client_name_1'] = $request['client_name_1'];
        $data['client_review_1'] = $request['client_review_1'];

        $data['client_name_2'] = $request['client_name_2'];
        $data['client_review_2'] = $request['client_review_2'];

        $data['client_name_3'] = $request['client_name_3'];
        $data['client_review_3'] = $request['client_review_3'];

        $data['client_name_4'] = $request['client_name_4'];
        $data['client_review_4'] = $request['client_review_4'];

        DB::table('home_client_review')->where('language_id','=',$lang_id)->update($data);


        return redirect()->route('admin.home.index');
    }

    public function section3List($lang_id){

      $homeData = DB::table('home_page')
      ->select('home_page.id as id',
      'home_page.language_id as language_id',
      'home_page.section_3_title as section_3_title',
      'home_section_3.title_1 as title_1',
      'home_section_3.title_2 as title_2',
      'home_section_3.title_3 as title_3',
      'home_section_3.img_1 as img_1',
      'home_section_3.img_2 as img_2',
      'home_section_3.img_3 as img_3',
      'home_section_3.link_1 as link_1',
      'home_section_3.link_2 as link_2',
      'home_section_3.link_3 as link_3'
      )
      ->join('home_section_3','home_section_3.language_id','=','home_page.language_id')
      ->where('home_page.language_id',$lang_id)
      ->first();
      $data = DB::table('route_visa')->where("type_of_url","visa")->get();
      $urlSet=[];
      foreach ($data as $key => $value) {
        $urlSet[$value->id] = $value->visa_url;
      }
      return view('admin.home.section3List',compact('homeData','urlSet'));
    }

    public function section3Update(Request $request, $lang_id)
    {
        $data =  [
             'section_3_title' => $request['section_3_title']
          ];
        DB::table('home_page')->where('language_id','=',$lang_id)->update($data);

        $homeData = DB::table('home_page')
        ->select('home_page.id as id',
        'home_page.language_id as language_id',
        'home_page.section_3_title as section_3_title',
        'home_section_3.title_1 as title_1',
        'home_section_3.title_2 as title_2',
        'home_section_3.title_3 as title_3',
        'home_section_3.img_1 as img_1',
        'home_section_3.img_2 as img_2',
        'home_section_3.img_3 as img_3',
        'home_section_3.link_1 as link_1',
        'home_section_3.link_2 as link_2',
        'home_section_3.link_3 as link_3'
        )
        ->join('home_section_3','home_section_3.language_id','=','home_page.language_id')
        ->where('home_page.language_id',$lang_id)
        ->first();

        $data = [];
        if ($request->hasFile('img_1')) {
            if($homeData->img_1 != ""){
              $oldImagePath = public_path('images/home/').$homeData->img_1;
              if (file_exists($oldImagePath)) {
                @unlink($oldImagePath);
              }
            }
            $images = $request->img_1->getClientOriginalName();
            $images = time().'_section3_'.$images; // Add current time before image name
            $img_1 = $images;
            $request->img_1->move(public_path('images/home'),$img_1);
            $data['img_1'] = $img_1;
        }
        if ($request->hasFile('img_2')) {
            if($homeData->img_2 != ""){
              $oldImagePath = public_path('images/home/').$homeData->img_2;
              if (file_exists($oldImagePath)) {
                @unlink($oldImagePath);
              }
            }
            $images = $request->img_2->getClientOriginalName();
            $images = time().'_section3_'.$images; // Add current time before image name
            $img_2 = $images;
            $request->img_2->move(public_path('images/home'),$img_2);
            $data['img_2'] = $img_2;
        }
        if ($request->hasFile('img_3')) {
            if($homeData->img_3 != ""){
              $oldImagePath = public_path('images/home/').$homeData->img_3;
              if (file_exists($oldImagePath)) {
                @unlink($oldImagePath);
              }
            }
            $images = $request->img_3->getClientOriginalName();
            $images = time().'_section3_'.$images; // Add current time before image name
            $img_3 = $images;
            $request->img_3->move(public_path('images/home'),$img_3);
            $data['img_3'] = $img_3;
        }

        $data['title_1'] = $request['title_1'];
        $data['link_1'] = $request['link_1'];

        $data['title_2'] = $request['title_2'];
        $data['link_2'] = $request['link_2'];

        $data['title_3'] = $request['title_3'];
        $data['link_3'] = $request['link_3'];

        DB::table('home_section_3')->where('language_id','=',$lang_id)->update($data);

        return redirect()->route('admin.home.index');
    }

    public function infoList($lang_id){

      $homeData = DB::table('home_page')
      ->select('home_page.id as id',
      'home_page.language_id as language_id',
      'home_page.info_title as info_title',
      'home_page.info_img as info_img',
      'home_info_section.title_1 as title_1',
      'home_info_section.title_2 as title_2',
      'home_info_section.title_3 as title_3',
      'home_info_section.title_4 as title_4',
      'home_info_section.content_1 as content_1',
      'home_info_section.content_2 as content_2',
      'home_info_section.content_3 as content_3',
      'home_info_section.content_4 as content_4'
      )
      ->join('home_info_section','home_info_section.language_id','=','home_page.language_id')
      ->where('home_page.language_id',$lang_id)
      ->first();
      return view('admin.home.infoList',compact('homeData'));
    }

    public function infoUpdate(Request $request, $lang_id)
    {
        $data =  [
             'info_title' => $request['info_title']
          ];

        $homeData = DB::table('home_page')
        ->where('home_page.language_id',$lang_id)
        ->first();

        if ($request->hasFile('info_img')) {
            if($homeData->info_img != ""){
              $oldImagePath = public_path('images/home/').$homeData->info_img;
              if (file_exists($oldImagePath)) {
                @unlink($oldImagePath);
              }
            }
            $images = $request->info_img->getClientOriginalName();
            $images = time().'_info_'.$images; // Add current time before image name
            $info_img = $images;
            $request->info_img->move(public_path('images/home'),$info_img);
            $data['info_img'] = $info_img;
        }
        DB::table('home_page')->where('language_id','=',$lang_id)->update($data);



        $data = [];

        $data['title_1'] = $request['title_1'];
        $data['content_1'] = $request['content_1'];

        $data['title_2'] = $request['title_2'];
        $data['content_2'] = $request['content_2'];

        $data['title_3'] = $request['title_3'];
        $data['content_3'] = $request['content_3'];

        $data['title_4'] = $request['title_4'];
        $data['content_4'] = $request['content_4'];

        DB::table('home_info_section')->where('language_id','=',$lang_id)->update($data);

        return redirect()->route('admin.home.index');
    }

    public function section2List($lang_id){

      $homeData = DB::table('home_page')
      ->select('home_page.id as id',
      'home_page.language_id as language_id',
      'home_page.section_2_title as section_2_title',
      'home_section_2.title_1 as title_1',
      'home_section_2.title_2 as title_2',
      'home_section_2.title_3 as title_3',
      'home_section_2.title_4 as title_4',
      'home_section_2.img_1 as img_1',
      'home_section_2.img_2 as img_2',
      'home_section_2.img_3 as img_3',
      'home_section_2.img_4 as img_4',
      'home_section_2.link_1 as link_1',
      'home_section_2.link_2 as link_2',
      'home_section_2.link_3 as link_3',
      'home_section_2.link_4 as link_4'
      )
      ->join('home_section_2','home_section_2.language_id','=','home_page.language_id')
      ->where('home_page.language_id',$lang_id)
      ->first();
      $data = DB::table('route_visa')->where("type_of_url","visa")->get();
      $urlSet=[];
      foreach ($data as $key => $value) {
        $urlSet[$value->id] = $value->visa_url;
      }

      return view('admin.home.section2List',compact('homeData','urlSet'));
    }

    public function section2Update(Request $request, $lang_id)
    {
      $data =  [
        'section_2_title' => $request['section_2_title']
      ];
      DB::table('home_page')->where('language_id','=',$lang_id)->update($data);

      $homeData = DB::table('home_page')
      ->select('home_page.id as id',
      'home_page.language_id as language_id',
      'home_page.section_2_title as section_2_title',
      'home_section_2.title_1 as title_1',
      'home_section_2.title_2 as title_2',
      'home_section_2.title_3 as title_3',
      'home_section_2.title_4 as title_4',
      'home_section_2.img_1 as img_1',
      'home_section_2.img_2 as img_2',
      'home_section_2.img_3 as img_3',
      'home_section_2.img_4 as img_4',
      'home_section_2.link_1 as link_1',
      'home_section_2.link_2 as link_2',
      'home_section_2.link_3 as link_3',
      'home_section_2.link_4 as link_4'
      )
      ->join('home_section_2','home_section_2.language_id','=','home_page.language_id')
      ->where('home_page.language_id',$lang_id)
      ->first();

      $data = [];
      if ($request->hasFile('img_1')) {
        if($homeData->img_1 != ""){
          $oldImagePath = public_path('images/home/').$homeData->img_1;
          if (file_exists($oldImagePath)) {
            @unlink($oldImagePath);
          }
        }
        $images = $request->img_1->getClientOriginalName();
        $images = time().'_section2_'.$images; // Add current time before image name
        $img_1 = $images;
        $request->img_1->move(public_path('images/home'),$img_1);
        $data['img_1'] = $img_1;
      }
      if ($request->hasFile('img_2')) {
        if($homeData->img_2 != ""){
          $oldImagePath = public_path('images/home/').$homeData->img_2;
          if (file_exists($oldImagePath)) {
            @unlink($oldImagePath);
          }
        }
        $images = $request->img_2->getClientOriginalName();
        $images = time().'_section2_'.$images; // Add current time before image name
        $img_2 = $images;
        $request->img_2->move(public_path('images/home'),$img_2);
        $data['img_2'] = $img_2;
      }
      if ($request->hasFile('img_3')) {
        if($homeData->img_3 != ""){
          $oldImagePath = public_path('images/home/').$homeData->img_3;
          if (file_exists($oldImagePath)) {
            @unlink($oldImagePath);
          }
        }
        $images = $request->img_3->getClientOriginalName();
        $images = time().'_section2_'.$images; // Add current time before image name
        $img_3 = $images;
        $request->img_3->move(public_path('images/home'),$img_3);
        $data['img_3'] = $img_3;
      }
      if ($request->hasFile('img_4')) {
        if($homeData->img_4 != ""){
          $oldImagePath = public_path('images/home/').$homeData->img_4;
          if (file_exists($oldImagePath)) {
            @unlink($oldImagePath);
          }
        }
        $images = $request->img_4->getClientOriginalName();
        $images = time().'_section2_'.$images; // Add current time before image name
        $img_4 = $images;
        $request->img_4->move(public_path('images/home'),$img_4);
        $data['img_4'] = $img_4;
      }

      $data['title_1'] = $request['title_1'];
      $data['link_1'] = $request['link_1'];

      $data['title_2'] = $request['title_2'];
      $data['link_2'] = $request['link_2'];

      $data['title_3'] = $request['title_3'];
      $data['link_3'] = $request['link_3'];

      $data['title_4'] = $request['title_4'];
      $data['link_4'] = $request['link_4'];

      DB::table('home_section_2')->where('language_id','=',$lang_id)->update($data);

      return redirect()->route('admin.home.index');
    }

    public function popularVisa($lang_id){

      $homeData = DB::table('home_page')
      ->where('home_page.language_id',$lang_id)
      ->first();

      return view('admin.home.popularVisa',compact('homeData'));
    }

    public function popularVisaUpdate(Request $request, $lang_id)
    {
      $data =  [
        'section_1_title' => $request['section_1_title'],
        'section_button_name' => $request['section_button_name']
      ];
      DB::table('home_page')->where('language_id','=',$lang_id)->update($data);
      return redirect()->route('admin.home.index');
    }

    public function sectionReview($lang_id){

      $homeData = DB::table('home_page')
      ->where('home_page.language_id',$lang_id)
      ->first();

      return view('admin.home.sectionReview',compact('homeData'));
    }

    public function sectionReviewUpdate(Request $request, $lang_id){

      $data =  [
        'review_detail' => $request['review_detail'],
        'review_tag' => $request['review_tag']
      ];

      $homeData = DB::table('home_page')
      ->where('home_page.language_id',$lang_id)
      ->first();

      if ($request->hasFile('review_img_1')) {
        if($homeData->review_img_1 != ""){
          $oldImagePath = public_path('images/home/').$homeData->review_img_1;
          if (file_exists($oldImagePath)) {
            @unlink($oldImagePath);
          }
        }
        $images = $request->review_img_1->getClientOriginalName();
        $images = time().'_review_'.$images; // Add current time before image name
        $review_img_1 = $images;
        $request->review_img_1->move(public_path('images/home'),$review_img_1);
        $data['review_img_1'] = $review_img_1;
      }

      if ($request->hasFile('review_img_2')) {
        if($homeData->review_img_2 != ""){
          $oldImagePath = public_path('images/home/').$homeData->review_img_2;
          if (file_exists($oldImagePath)) {
            @unlink($oldImagePath);
          }
        }
        $images = $request->review_img_2->getClientOriginalName();
        $images = time().'_review_'.$images; // Add current time before image name
        $review_img_2 = $images;
        $request->review_img_2->move(public_path('images/home'),$review_img_2);
        $data['review_img_2'] = $review_img_2;
      }

      DB::table('home_page')->where('language_id','=',$lang_id)->update($data);
      return redirect()->route('admin.home.index');
    }

    public function sectionSearch($lang_id){
      $homeData = DB::table('home_page')
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
      ->where('home_page.language_id',$lang_id)
      ->first();

      $data = DB::table('route_visa')->where('language_id',env('APP_LANG'))->where("type_of_url","visa")->get();
      $urlSet=[];
      foreach ($data as $key => $value) {
        $urlSet[$value->id] = $value->visa_url;
      }

      return view('admin.home.sectionSearch',compact('homeData','urlSet'));
    }

    public function sectionSearchUpdate(Request $request, $lang_id)
    {
      $homeData = DB::table('home_page')
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
      ->where('home_page.language_id',$lang_id)
      ->first();

        $data =  [
             'main_title_1' => $request['main_title_1'],
             'main_title_2' => $request['main_title_2'],
             'dropdown_1' => $request['dropdown_1'],
             'dropdown_2' => $request['dropdown_2'],
             'main_button_name' => $request['main_button_name'],
             'popular' => $request['popular']
          ];

        if ($request->hasFile('main_img')) {
            if($homeData->main_img != ""){
              $oldImagePath = public_path('images/home/').$homeData->main_img;
              if (file_exists($oldImagePath)) {
                @unlink($oldImagePath);
              }
            }
            $images = $request->main_img->getClientOriginalName();
            $images = time().'_main_img_'.$images; // Add current time before image name
            $main_img = $images;
            $request->main_img->move(public_path('images/home'),$main_img);
            $data['main_img'] = $main_img;
        }
        DB::table('home_page')->where('language_id','=',$lang_id)->update($data);



        $data = [];

        $data['title_1'] = $request['title_1'];
        $data['link_1'] = $request['link_1'];

        $data['title_2'] = $request['title_2'];
        $data['link_2'] = $request['link_2'];

        $data['title_3'] = $request['title_3'];
        $data['link_3'] = $request['link_3'];

        $data['title_4'] = $request['title_4'];
        $data['link_4'] = $request['link_4'];

        DB::table('home_popular_section')->where('language_id','=',$lang_id)->update($data);

        return redirect()->route('admin.home.index');
    }

}

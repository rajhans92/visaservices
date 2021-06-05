<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Admin\UpdateServicesRequest;

class BlogController extends Controller
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
        $blogData = DB::table('blog_pages')
        ->select(
          'blog_pages.id as id',
          'blog_pages.blog_name as blog_name',
          'blog_pages.blog_heading as blog_heading',
          'blog_category.name as category_name',
          'route_visa.visa_url as visa_url'
          )
        ->where('blog_pages.language_id',env('APP_LANG'))
        ->where('route_visa.type_of_url',"blog")
        ->join("route_visa","route_visa.visa_id","=","blog_pages.id")
        ->join("blog_category","blog_category.id","=","blog_pages.category_id")
        ->get();


        return view('admin.blog.list',compact('blogData'));
    }

    public function create(){
      $blogData = [];
      $categoryList = DB::table('blog_category')->get();
      $routeList = DB::table('route_visa')->get();

      return view('admin.blog.create',compact('blogData','categoryList','routeList'));
    }

    public function store(Request $request){

      $tempNm = DB::table('route_visa')->where("language_id",env('APP_LANG'))->where('visa_url',$request['visa_url'])->count();
      if($tempNm > 0){
          return redirect()->back()->with('error','Page URL should be unique!');
      }

      $data =  [
           'language_id' => env('APP_LANG'),
           'category_id' => $request['blog_category_id'],
           'blog_name' => $request['blog_name'],
           'blog_heading' => $request['blog_heading'],
           'content_1' => $request['content_1'],
           'content_2' => $request['content_2'],
           'meta_title' => $request['meta_title'],
           'meta_description' => $request['meta_description'],
           'meta_keywords' => $request['meta_keywords'],
           'call_status' => $request['call_status'],
           'whatsapp_number' => $request['whatsapp_number'],
           'whatsapp_status' => $request['whatsapp_status'],
           'call_number' => $request['call_number'],
           'whatsapp_text' => $request['whatsapp_text'],
           'main_button_url' => $request['main_button_url']
        ];

      if ($request->hasFile('landing_img')) {
          $images = $request->landing_img->getClientOriginalName();
          $images = time().'_blog_'.$images; // Add current time before image name
          $landing_img = $images;
          $request->landing_img->move(public_path('images/blog'),$landing_img);
          $data['landing_img'] = $landing_img;
      }
      $blog_id = DB::table('blog_pages')->insertGetId($data);

      DB::table('route_visa')->insert([
        'language_id' => env('APP_LANG'),
        'class' => 'Front\BlogController',
        'method' => 'pages',
        'visa_id' => $blog_id,
        'type_of_url' => "blog",
        'visa_url' => $request['visa_url']
      ]);

      return redirect()->route('admin.blog.index');
    }

    public function edit($id){

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
      ->where('blog_pages.id',$id)
      ->where("route_visa.type_of_url","blog")
      ->join("route_visa","route_visa.visa_id","=","blog_pages.id")
      ->first();

      $categoryList = DB::table('blog_category')->get();
      $routeList = DB::table('route_visa')->get();


      return view('admin.blog.edit',compact('blogData','categoryList','routeList'));
    }


    public function update(Request $request, $id){

      $tempNm = DB::table('route_visa')
      ->where("language_id",env('APP_LANG'))
      ->where('visa_url',$request['visa_url'])
      ->whereNotIn('visa_id',[$id])->count();
      if($tempNm > 0){
          return redirect()->back()->with('error','Page URL should be unique!');
      }

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
      ->where('blog_pages.id',$id)
      ->where("route_visa.type_of_url","blog")
      ->join("route_visa","route_visa.visa_id","=","blog_pages.id")
      ->first();

        $data =  [
             'category_id' => $request['blog_category_id'],
             'blog_name' => $request['blog_name'],
             'blog_heading' => $request['blog_heading'],
             'content_1' => $request['content_1'],
             'content_2' => $request['content_2'],
             'meta_title' => $request['meta_title'],
             'meta_description' => $request['meta_description'],
             'meta_keywords' => $request['meta_keywords'],
             'call_status' => $request['call_status'],
             'whatsapp_number' => $request['whatsapp_number'],
             'whatsapp_status' => $request['whatsapp_status'],
             'call_number' => $request['call_number'],
             'whatsapp_text' => $request['whatsapp_text'],
             'main_button_url' => $request['main_button_url']
          ];

      if ($request->hasFile('landing_img')) {
        if($blogData->landing_img != ""){
          $oldImagePath = public_path('images/blog/').$blogData->landing_img;
          if (file_exists($oldImagePath)) {
            @unlink($oldImagePath);
          }
        }
          $images = $request->landing_img->getClientOriginalName();
          $images = time().'_blog_'.$images; // Add current time before image name
          $landing_img = $images;
          $request->landing_img->move(public_path('images/blog'),$landing_img);
          $data['landing_img'] = $landing_img;
      }

      DB::table('blog_pages')->where('id',$id)->where('language_id',env('APP_LANG'))->update($data);

      if($blogData->visa_url != $request['visa_url']){
        DB::table('route_visa')
        ->where('visa_id',$id)
        ->where('language_id',env('APP_LANG'))
        ->where("type_of_url","blog")
        ->update([
          'visa_url' => $request['visa_url']
        ]);
      }

      return redirect()->route('admin.blog.index');
    }

    public function destroy(Request $request){
      $data = DB::table('blog_pages')->where('language_id',env('APP_LANG'))->where('id',$request->id)->get();

      DB::table('blog_pages')->where('language_id',env('APP_LANG'))->where('id',$request->id)->delete();
      DB::table('route_visa')->where('language_id',env('APP_LANG'))->where('type_of_url',"blog")->where('visa_id', $request->id)->limit(1)
      ->delete();

      foreach ($data as $key => $value) {
        if(isset($value->landing_img) && $value->landing_img != ""){
          $oldImagePath = public_path('images/blog/').$value->landing_img;
          if (file_exists($oldImagePath)) {
            @unlink($oldImagePath);
          }
        }
      }
      return redirect()->route('admin.blog.index');
    }

    public function categoryList(){
      $data = DB::table('blog_category')->where('language_id',env('APP_LANG'))->get();

      return view('admin.blog.categoryList',compact('data'));
    }

    public function categoryAdd(){
      $data = [];

      return view('admin.blog.categoryAdd',compact('data'));
    }

    public function categoryStore(Request $request){
      DB::table('blog_category')->insert([
        'language_id' => env('APP_LANG'),
        'name' => $request['name']
      ]);
      return redirect()->route('admin.blog.categoryList');

    }

    public function categoryEdit($id){
      $data = DB::table('blog_category')->where('language_id',env('APP_LANG'))->where('id',$id)->first();

      return view('admin.blog.categoryEdit',compact('data'));
    }
    public function categoryUpdate(Request $request,$id){
      DB::table('blog_category')
      ->where('language_id',env('APP_LANG'))
      ->where('id',$id)
      ->update([
        'name' => $request['name']
      ]);
      return redirect()->route('admin.blog.categoryList');

    }
    public function categoryDestroy($id){
      $data = DB::table('blog_pages')->where('language_id',env('APP_LANG'))->where('category_id',$id)->get();

      DB::table('blog_category')->where('language_id',env('APP_LANG'))->where('id',$id)->delete();
      DB::table('blog_pages')->where('language_id',env('APP_LANG'))->where('category_id',$id)->delete();

      foreach ($data as $key => $value) {
        if(isset($value->landing_img) && $value->landing_img != ""){
          $oldImagePath = public_path('images/blog/').$value->landing_img;
          if (file_exists($oldImagePath)) {
            @unlink($oldImagePath);
          }
        }
      }
      return redirect()->route('admin.blog.categoryList');

    }

}

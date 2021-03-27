<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Admin\UpdateVisaRequest;

class VisaController extends Controller
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
        $visaData = DB::table('visa_pages')
        ->select(
          'visa_pages.id as id',
          'visa_pages.country_name as country_name',
          'visa_pages.visa_heading as visa_heading',
          'visa_pages.visa_landing_img as visa_landing_img',
          'route_visa.visa_url as visa_url'
          )
        ->where('visa_pages.language_id',env('APP_LANG'))
        ->join("route_visa","route_visa.visa_id","=","visa_pages.id")
        ->get();

        foreach ($visaData as $key => $value) {
          $temp = DB::table('visa_faqs')
          ->where('visa_faqs.language_id',env('APP_LANG'))
          ->where('visa_faqs.visa_id',$value->id)
          ->get();
          $value->faq = $temp;
        }
        return view('admin.visa.list',compact('visaData'));
    }

    public function createVisa(){
      $visaData = [];

      $countryData = DB::table('country')->whereNotIn('country_name', function($q){
        $q->select('country_name')->from('visa_pages')->where('visa_pages.language_id',env('APP_LANG'));
      })->get();

      return view('admin.visa.create',compact('countryData','visaData'));
    }

    public function storeVisa(Request $request){

      $tempNm = DB::table('route_visa')->where("language_id",env('APP_LANG'))->where('visa_url',$request['visa_url'])->count();
      if($tempNm > 0){
          return redirect()->back()->with('error','Visa URL should be unique!');
      }

      $data =  [
           'language_id' => env('APP_LANG'),
           'country_name' => $request['country_name'],
           'visa_heading' => $request['visa_heading'],
           'visa_content_1' => $request['visa_content_1'],
           'visa_content_2' => $request['visa_content_2'],
           'visa_main_button' => $request['visa_main_button'],
           'visa_faqs' => $request['visa_faqs'],
           'visa_nationality_title' => $request['visa_nationality_title'],
           'visa_type_title' => $request['visa_type_title'],
           'visa_popular_title' => $request['visa_popular_title'],
           'isPassportDocRequired' => isset($request['isPassportDocRequired']) ? $request['isPassportDocRequired'] : 0,
           'isApplicantPhotoRequired' => isset($request['isApplicantPhotoRequired']) ? $request['isApplicantPhotoRequired'] : 0,
           'isOtherDocRequired' => isset($request['isOtherDocRequired']) ? $request['isOtherDocRequired'] : 0
        ];

      if ($request->hasFile('visa_landing_img')) {
          $images = $request->visa_landing_img->getClientOriginalName();
          $images = time().'_visa_'.$images; // Add current time before image name
          $visa_landing_img = $images;
          $request->visa_landing_img->move(public_path('images/visa'),$visa_landing_img);
          $data['visa_landing_img'] = $visa_landing_img;
      }
      $visa_id = DB::table('visa_pages')->insertGetId($data);

      DB::table('route_visa')->insert([
        'language_id' => env('APP_LANG'),
        'class' => 'Front\VisaController',
        'method' => 'pages',
        'visa_id' => $visa_id,
        'visa_url' => $request['visa_url']
      ]);

      return redirect()->route('admin.visa.index');
    }

    public function updateVisa(Request $request, $id){

      $tempNm = DB::table('route_visa')
      ->where("language_id",env('APP_LANG'))
      ->where('visa_url',$request['visa_url'])
      ->whereNotIn('visa_id',[$id])->count();
      if($tempNm > 0){
          return redirect()->back()->with('error','Visa URL should be unique!');
      }

      $visaData = DB::table('visa_pages')
      ->select(
        'visa_pages.id as id',
        'visa_pages.country_name as country_name',
        'visa_pages.visa_heading as visa_heading',
        'visa_pages.visa_landing_img as visa_landing_img',
        'visa_pages.visa_main_button as visa_main_button',
        'visa_pages.visa_faqs as visa_faqs',
        'visa_pages.visa_nationality_title as visa_nationality_title',
        'visa_pages.visa_type_title as visa_type_title',
        'visa_pages.visa_popular_title as visa_popular_title',
        'visa_pages.visa_content_1 as visa_content_1',
        'visa_pages.visa_content_2 as visa_content_2',
        'route_visa.visa_url as visa_url'
        )
      ->where('visa_pages.language_id',env('APP_LANG'))
      ->where('visa_pages.id',$id)
      ->join("route_visa","route_visa.visa_id","=","visa_pages.id")
      ->first();

      $data =  [
          'country_name' => $request['country_name'],
          'visa_heading' => $request['visa_heading'],
          'visa_content_1' => $request['visa_content_1'],
          'visa_content_2' => $request['visa_content_2'],
          'visa_main_button' => $request['visa_main_button'],
          'visa_faqs' => $request['visa_faqs'],
          'visa_nationality_title' => $request['visa_nationality_title'],
          'visa_type_title' => $request['visa_type_title'],
          'visa_popular_title' => $request['visa_popular_title'],
          'isPassportDocRequired' => isset($request['isPassportDocRequired']) ? $request['isPassportDocRequired'] : 0,
          'isApplicantPhotoRequired' => isset($request['isApplicantPhotoRequired']) ? $request['isApplicantPhotoRequired'] : 0,
          'isOtherDocRequired' => isset($request['isOtherDocRequired']) ? $request['isOtherDocRequired'] : 0
        ];

      if ($request->hasFile('visa_landing_img')) {
        if($visaData->visa_landing_img != ""){
          $oldImagePath = public_path('images/visa/').$visaData->visa_landing_img;
          if (file_exists($oldImagePath)) {
            @unlink($oldImagePath);
          }
        }
          $images = $request->visa_landing_img->getClientOriginalName();
          $images = time().'_visa_'.$images; // Add current time before image name
          $visa_landing_img = $images;
          $request->visa_landing_img->move(public_path('images/visa'),$visa_landing_img);
          $data['visa_landing_img'] = $visa_landing_img;
      }

      DB::table('visa_pages')->where('id',$id)->where('language_id',env('APP_LANG'))->update($data);

      if($visaData->visa_url != $request['visa_url']){
        DB::table('route_visa')
        ->where('visa_id',$id)
        ->where('language_id',env('APP_LANG'))
        ->update([
          'visa_url' => $request['visa_url']
        ]);
      }

      return redirect()->route('admin.visa.index');
    }

    public function editVisa($id){
      $countryData = DB::table('country')->whereNotIn('country_name', function($q){
        $q->select('country_name')->from('visa_pages')->where('visa_pages.language_id',env('APP_LANG'));
      })->get();

      $visaData = DB::table('visa_pages')
      ->select(
        'visa_pages.id as id',
        'visa_pages.country_name as country_name',
        'visa_pages.visa_heading as visa_heading',
        'visa_pages.visa_landing_img as visa_landing_img',
        'visa_pages.visa_main_button as visa_main_button',
        'visa_pages.visa_faqs as visa_faqs',
        'visa_pages.visa_nationality_title as visa_nationality_title',
        'visa_pages.visa_type_title as visa_type_title',
        'visa_pages.visa_popular_title as visa_popular_title',
        'visa_pages.visa_content_1 as visa_content_1',
        'visa_pages.visa_content_2 as visa_content_2',
        'visa_pages.isPassportDocRequired as isPassportDocRequired',
        'visa_pages.isApplicantPhotoRequired as isApplicantPhotoRequired',
        'visa_pages.isOtherDocRequired as isOtherDocRequired',
        'route_visa.visa_url as visa_url'
        )
      ->where('visa_pages.language_id',env('APP_LANG'))
      ->where('visa_pages.id',$id)
      ->join("route_visa","route_visa.visa_id","=","visa_pages.id")
      ->first();

      return view('admin.visa.edit',compact('countryData','visaData'));
    }

    public function destroyVisa(Request $request){
        $visaData = DB::table('visa_pages')->where('id', $request->id)->first();

        DB::table('visa_pages')->where('id', $request->id)->limit(1)
        ->delete();

        DB::table('route_visa')->where('language_id',env('APP_LANG'))->where('visa_id', $request->id)->limit(1)
        ->delete();

        DB::table('visa_faqs')->where('language_id',env('APP_LANG'))->where('visa_id', $request->id)->delete();

        if($visaData->visa_landing_img != ""){
          $oldImagePath = public_path('images/visa/').$visaData->visa_landing_img;
          if (file_exists($oldImagePath)) {
            @unlink($oldImagePath);
          }
        }
        return redirect()->route('admin.visa.index');
    }

    public function faqVisa($id){
      $faqData = DB::table('visa_faqs')->where('language_id',env('APP_LANG'))->where('visa_id',$id)->get();

      return view('admin.visa.faqlist',compact('faqData','id'));
    }

    public function faqCreateVisa($id){
      $faqData = [];

      return view('admin.visa.faqCreate',compact('faqData','id'));
    }

    public function faqStoreVisa(Request $request,$id){
      DB::table('visa_faqs')->insert([
        'language_id' => env('APP_LANG'),
        'visa_id' => $id,
        'question' => $request['question'],
        'answer' => $request['answer']
      ]);
      return redirect()->route('admin.visa.faqList',$id);

    }

    public function faqEditVisa($id,$faqId){
      $faqData = DB::table('visa_faqs')->where('language_id',env('APP_LANG'))->where('visa_id',$id)->where('id',$faqId)->first();

      return view('admin.visa.faqEdit',compact('faqData','id'));
    }
    public function faqUpdateVisa(Request $request,$id,$faqId){
      DB::table('visa_faqs')
      ->where('language_id',env('APP_LANG'))
      ->where('visa_id',$id)
      ->where('id',$faqId)
      ->update([
        'language_id' => env('APP_LANG'),
        'visa_id' => $id,
        'question' => $request['question'],
        'answer' => $request['answer']
      ]);
      return redirect()->route('admin.visa.faqList',$id);

    }
    public function faqDeleteVisa($id,$faqId){

      DB::table('visa_faqs')->where('language_id',env('APP_LANG'))->where('visa_id',$id)->where('id',$faqId)->delete();

      return redirect()->route('admin.visa.faqList',$id);

    }
}

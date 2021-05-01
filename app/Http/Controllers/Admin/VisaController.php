<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Admin\UpdateVisaRequest;
use Excel;

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
        ->where('route_visa.type_of_url',"visa")
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

      $tempNm = DB::table('route_visa')->where("language_id",env('APP_LANG'))->where('route_visa.type_of_url',"visa")->where('visa_url',$request['visa_url'])->count();
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
           'payment_method' => $request['payment_method'],
           'meta_title' => $request['meta_title'],
           'meta_description' => $request['meta_description'],
           'meta_keywords' => $request['meta_keywords'],
           'call_status' => $request['call_status'],
           'is_price_show' => $request['is_price_show'],
           'is_govt_apply' => $request['is_govt_apply'],
           'whatsapp_number' => $request['whatsapp_number'],
           'whatsapp_text' => $request['whatsapp_text'],
           'whatsapp_status' => $request['whatsapp_status'],
           'standard_time_duration' => $request['standard_time_duration'],
           'rush_time_duration' => $request['rush_time_duration'],
           'express_time_duration' => $request['express_time_duration'],
           'call_number' => $request['call_number'],
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
        'visa_url' => $request['visa_url'],
        "type_of_url" => "visa"
      ]);

      DB::table('visa_apply_page_content')->insert([
        'language_id' => env('APP_LANG'),
        'visa_id' => $visa_id
      ]);

      return redirect()->route('admin.visa.index');
    }

    public function updateVisa(Request $request, $id){

      $tempNm = DB::table('route_visa')
      ->where("language_id",env('APP_LANG'))
      ->where('visa_url',$request['visa_url'])
      ->where('type_of_url',"visa")
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
        'visa_pages.payment_method as payment_method',
        'route_visa.visa_url as visa_url'
        )
      ->where('visa_pages.language_id',env('APP_LANG'))
      ->where('visa_pages.id',$id)
      ->where('route_visa.type_of_url',"visa")
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
          'payment_method' => $request['payment_method'],
          'meta_title' => $request['meta_title'],
          'meta_description' => $request['meta_description'],
          'meta_keywords' => $request['meta_keywords'],
          'call_status' => $request['call_status'],
          'is_price_show' => $request['is_price_show'],
          'is_govt_apply' => $request['is_govt_apply'],
          'whatsapp_number' => $request['whatsapp_number'],
          'whatsapp_text' => $request['whatsapp_text'],
          'whatsapp_status' => $request['whatsapp_status'],
          'standard_time_duration' => $request['standard_time_duration'],
          'rush_time_duration' => $request['rush_time_duration'],
          'express_time_duration' => $request['express_time_duration'],
          'call_number' => $request['call_number'],
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
        ->where('type_of_url',"visa")
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
        'visa_pages.payment_method as payment_method',
        'visa_pages.meta_title as meta_title',
        'visa_pages.meta_description as meta_description',
        'visa_pages.meta_keywords as meta_keywords',
        'visa_pages.is_price_show as is_price_show',
        'visa_pages.is_govt_apply as is_govt_apply',
        'visa_pages.whatsapp_number as whatsapp_number',
        'visa_pages.whatsapp_text as whatsapp_text',
        'visa_pages.whatsapp_status as whatsapp_status',
        'visa_pages.call_number as call_number',
        'visa_pages.call_status as call_status',
        'visa_pages.standard_time_duration as standard_time_duration',
        'visa_pages.rush_time_duration as rush_time_duration',
        'visa_pages.express_time_duration as express_time_duration',
        'route_visa.visa_url as visa_url'
        )
      ->where('visa_pages.language_id',env('APP_LANG'))
      ->where('visa_pages.id',$id)
      ->where('route_visa.type_of_url',"visa")
      ->join("route_visa","route_visa.visa_id","=","visa_pages.id")
      ->first();

      return view('admin.visa.edit',compact('countryData','visaData'));
    }

    public function destroyVisa(Request $request){
        $visaData = DB::table('visa_pages')->where('id', $request->id)->first();

        DB::table('visa_pages')->where('id', $request->id)->limit(1)
        ->delete();

        DB::table('route_visa')->where('language_id',env('APP_LANG'))->where('type_of_url',"visa")->where('visa_id', $request->id)->limit(1)
        ->delete();

        DB::table('visa_faqs')->where('language_id',env('APP_LANG'))->where('visa_id', $request->id)->delete();

        $applyData = DB::table('visa_apply_page_content')->where('visa_id', $request->id)->first();

        DB::table('visa_apply_page_content')->where('visa_id', $request->id)->limit(1)
        ->delete();

        if(isset($visaData->visa_landing_img) && $visaData->visa_landing_img != ""){
          $oldImagePath = public_path('images/visa/').$visaData->visa_landing_img;
          if (file_exists($oldImagePath)) {
            @unlink($oldImagePath);
          }
        }
        if(isset($visaData->thank_you_img) &&  $applyData->thank_you_img != ""){
          $oldImagePath = public_path('images/visa/apply/').$applyData->thank_you_img;
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
    public function applyDetailList($visa_id){
      $applyData = DB::table('visa_apply_page_content')->where('visa_id', $visa_id)->first();
      return view('admin.visa.applyDetailList',compact('applyData'));
    }

    public function applyDetailSave(Request $request, $visa_id){


      $applyData = DB::table('visa_apply_page_content')->where('visa_id', $visa_id)->first();

      $data =  [
          'thank_you_content' => $request['thank_you_content'],
        ];

      if ($request->hasFile('thank_you_img')) {
        if($applyData->thank_you_img != ""){
          $oldImagePath = public_path('images/visa/apply/').$applyData->thank_you_img;
          if (file_exists($oldImagePath)) {
            @unlink($oldImagePath);
          }
        }
        $images = $request->thank_you_img->getClientOriginalName();
        $images = time().'_visa_'.$images; // Add current time before image name
        $thank_you_img = $images;
        $request->thank_you_img->move(public_path('images/visa/apply'),$thank_you_img);
        $data['thank_you_img'] = $thank_you_img;
      }

      DB::table('visa_apply_page_content')->where('visa_id',$visa_id)->where('language_id',env('APP_LANG'))->update($data);

      return redirect()->route('admin.visa.index');
    }

    public function typeOfVisaList($visa_id){

      $visaData = DB::table('visa_pages')->where('id', $visa_id)->first();
      if(!isset($visaData->id)){
        return redirect()->route('admin.visa.index');
      }
      $visaType = DB::table('visa_type_detail')->where('visa_country_name', strtolower($visaData->country_name))->where('language_id',env('APP_LANG'))->get();

      return view('admin.visa.typeOfVisaList',compact('visaType','visa_id'));
    }

    public function typeOfVisaUpload($visa_id){

      return view('admin.visa.showUploadScreen',compact('visa_id'));

    }

    public function typeOfVisaSave(Request $request){
      $this->validate($request, [
       'file_name'  => 'required|mimes:xls,xlsx'
      ]);

      $path = $request->file('file_name')->getRealPath();
      $data = Excel::load($path)->get()->toArray();

      if(count($data) < 1){
        return back()->with('error', 'Invalid Sheet');

      }
      $visaData = DB::table('visa_pages')->where('id', $request->visa_id)->first();
      if(!isset($visaData->id)){
        return redirect()->route('admin.visa.index');
      }

      $tempData = [];
      foreach ($data[0] as $key => $value) {
        $tempData[] =[
            'language_id' => env('APP_LANG'),
            'visa_country_name' => strtolower($visaData->country_name),
            'visa_type_name' => $value['visa_type_name'],
            'nationality_name' => $value['nationality_name'],
            'govt_fee' => $value['govt_fee'] && is_numeric($value['govt_fee']) ? $value['govt_fee'] : 0.0,
            'standard_usd_price' => $value['standard_usd_price'] && is_numeric($value['standard_usd_price']) ? $value['standard_usd_price'] : 0.0,
            'rush_usd_price' => $value['rush_usd_price'] && is_numeric($value['rush_usd_price']) ? $value['rush_usd_price'] : 0.0,
            'express_usd_price' => $value['express_usd_price'] && is_numeric($value['express_usd_price']) ? $value['express_usd_price'] : 0.0
        ];
      }
      DB::table('visa_type_detail')->where('language_id',env('APP_LANG'))->where("visa_country_name",strtolower($visaData->country_name))->delete();
      DB::table('visa_type_detail')->insert($tempData);
      return redirect()->route('admin.visa.typeOfVisaList',[$request->visa_id])->with("success","Excel Upload Successfully");
    }

}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Admin\UpdateServicesRequest;
use Excel;

class ServicesController extends Controller
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
        $servicesData = DB::table('services_pages')
        ->select(
          'services_pages.id as id',
          'services_pages.services_name as services_name',
          'services_pages.services_heading as services_heading',
          'services_pages.services_landing_img as services_landing_img',
          'route_visa.visa_url as visa_url'
          )
        ->where('services_pages.language_id',env('APP_LANG'))
        ->where('route_visa.type_of_url',"services")
        ->join("route_visa","route_visa.visa_id","=","services_pages.id")
        ->get();


        return view('admin.services.list',compact('servicesData'));
    }

    public function createServices(){
      $servicesData = [];

      return view('admin.services.create',compact('servicesData'));
    }

    public function storeServices(Request $request){

      $tempNm = DB::table('route_visa')->where("language_id",env('APP_LANG'))->where('visa_url',$request['visa_url'])->count();
      if($tempNm > 0){
          return redirect()->back()->with('error','Page URL should be unique!');
      }

      $data =  [
           'language_id' => env('APP_LANG'),
           'services_name' => $request['services_name'],
           'services_heading' => $request['services_heading'],
           'services_content_1' => $request['services_content_1'],
           'services_content_2' => $request['services_content_2'],
           'services_main_button' => $request['services_main_button'],
           'services_faqs' => $request['services_faqs'],
           'services_nationality_title' => $request['services_nationality_title'],
           'services_type_title' => $request['services_type_title'],
           'services_popular_title' => $request['services_popular_title'],
           'payment_method' => $request['payment_method'],
           'meta_title' => $request['meta_title'],
           'meta_description' => $request['meta_description'],
           'meta_keywords' => $request['meta_keywords'],
           'call_status' => $request['call_status'],
           'whatsapp_number' => $request['whatsapp_number'],
           'whatsapp_status' => $request['whatsapp_status'],
           'is_price_show' => $request['is_price_show'],
           'call_number' => $request['call_number'],
           'whatsapp_text' => $request['whatsapp_text'],
           'standard_time_duration' => $request['standard_time_duration'],
           'rush_time_duration' => $request['rush_time_duration'],
           'express_time_duration' => $request['express_time_duration'],
           'isPassportDocRequired' => isset($request['isPassportDocRequired']) ? $request['isPassportDocRequired'] : 0,
           'isApplicantPhotoRequired' => isset($request['isApplicantPhotoRequired']) ? $request['isApplicantPhotoRequired'] : 0,
           'isOtherDocRequired' => isset($request['isOtherDocRequired']) ? $request['isOtherDocRequired'] : 0,
           'is_govt_apply' => isset($request['is_govt_apply']) ? $request['is_govt_apply'] : 0
        ];

      if ($request->hasFile('services_landing_img')) {
          $images = $request->services_landing_img->getClientOriginalName();
          $images = time().'_services_'.$images; // Add current time before image name
          $services_landing_img = $images;
          $request->services_landing_img->move(public_path('images/services'),$services_landing_img);
          $data['services_landing_img'] = $services_landing_img;
      }
      $services_id = DB::table('services_pages')->insertGetId($data);

      DB::table('route_visa')->insert([
        'language_id' => env('APP_LANG'),
        'class' => 'Front\ServicesController',
        'method' => 'pages',
        'visa_id' => $services_id,
        'type_of_url' => "services",
        'visa_url' => $request['visa_url']
      ]);

      DB::table('services_apply_page_content')->insert([
        'language_id' => env('APP_LANG'),
        'services_id' => $services_id
      ]);

      return redirect()->route('admin.services.index');
    }

    public function updateServices(Request $request, $id){

      $tempNm = DB::table('route_visa')
      ->where("language_id",env('APP_LANG'))
      ->where('visa_url',$request['visa_url'])
      ->whereNotIn('visa_id',[$id])->count();
      if($tempNm > 0){
          return redirect()->back()->with('error','Page URL should be unique!');
      }

      $servicesData = DB::table('services_pages')
      ->select(
        'services_pages.id as id',
        'services_pages.services_name as services_name',
        'services_pages.services_heading as services_heading',
        'services_pages.services_landing_img as services_landing_img',
        'services_pages.services_main_button as services_main_button',
        'services_pages.services_faqs as services_faqs',
        'services_pages.services_nationality_title as services_nationality_title',
        'services_pages.services_type_title as services_type_title',
        'services_pages.services_popular_title as services_popular_title',
        'services_pages.services_content_1 as services_content_1',
        'services_pages.services_content_2 as services_content_2',
        'services_pages.payment_method as payment_method',
        'route_visa.visa_url as visa_url'
        )
      ->where('services_pages.language_id',env('APP_LANG'))
      ->where('services_pages.id',$id)
      ->where("route_visa.type_of_url","services")
      ->join("route_visa","route_visa.visa_id","=","services_pages.id")
      ->first();

      $data =  [
          'services_name' => $request['services_name'],
          'services_heading' => $request['services_heading'],
          'services_content_1' => $request['services_content_1'],
          'services_content_2' => $request['services_content_2'],
          'services_main_button' => $request['services_main_button'],
          'services_faqs' => $request['services_faqs'],
          'services_nationality_title' => $request['services_nationality_title'],
          'services_type_title' => $request['services_type_title'],
          'services_popular_title' => $request['services_popular_title'],
          'payment_method' => $request['payment_method'],
          'meta_title' => $request['meta_title'],
          'meta_description' => $request['meta_description'],
          'meta_keywords' => $request['meta_keywords'],
          'call_status' => $request['call_status'],
          'whatsapp_number' => $request['whatsapp_number'],
          'whatsapp_status' => $request['whatsapp_status'],
          'call_number' => $request['call_number'],
          'whatsapp_text' => $request['whatsapp_text'],
          'is_price_show' => $request['is_price_show'],
          'standard_time_duration' => $request['standard_time_duration'],
          'rush_time_duration' => $request['rush_time_duration'],
          'express_time_duration' => $request['express_time_duration'],
          'isPassportDocRequired' => isset($request['isPassportDocRequired']) ? $request['isPassportDocRequired'] : 0,
          'isApplicantPhotoRequired' => isset($request['isApplicantPhotoRequired']) ? $request['isApplicantPhotoRequired'] : 0,
          'isOtherDocRequired' => isset($request['isOtherDocRequired']) ? $request['isOtherDocRequired'] : 0,
          'is_govt_apply' => isset($request['is_govt_apply']) ? $request['is_govt_apply'] : 0
        ];

      if ($request->hasFile('services_landing_img')) {
        if($servicesData->services_landing_img != ""){
          $oldImagePath = public_path('images/services/').$servicesData->services_landing_img;
          if (file_exists($oldImagePath)) {
            @unlink($oldImagePath);
          }
        }
          $images = $request->services_landing_img->getClientOriginalName();
          $images = time().'_services_'.$images; // Add current time before image name
          $services_landing_img = $images;
          $request->services_landing_img->move(public_path('images/services'),$services_landing_img);
          $data['services_landing_img'] = $services_landing_img;
      }

      DB::table('services_pages')->where('id',$id)->where('language_id',env('APP_LANG'))->update($data);

      if($servicesData->visa_url != $request['visa_url']){
        DB::table('route_visa')
        ->where('visa_id',$id)
        ->where('language_id',env('APP_LANG'))
        ->where("type_of_url","services")
        ->update([
          'visa_url' => $request['visa_url']
        ]);
      }

      return redirect()->route('admin.services.index');
    }

    public function editServices($id){


      $servicesData = DB::table('services_pages')
      ->select(
        'services_pages.id as id',
        'services_pages.services_name as services_name',
        'services_pages.services_heading as services_heading',
        'services_pages.services_landing_img as services_landing_img',
        'services_pages.services_main_button as services_main_button',
        'services_pages.services_faqs as services_faqs',
        'services_pages.services_nationality_title as services_nationality_title',
        'services_pages.services_type_title as services_type_title',
        'services_pages.services_popular_title as services_popular_title',
        'services_pages.services_content_1 as services_content_1',
        'services_pages.services_content_2 as services_content_2',
        'services_pages.isPassportDocRequired as isPassportDocRequired',
        'services_pages.isApplicantPhotoRequired as isApplicantPhotoRequired',
        'services_pages.isOtherDocRequired as isOtherDocRequired',
        'services_pages.payment_method as payment_method',
        'services_pages.meta_title as meta_title',
        'services_pages.meta_description as meta_description',
        'services_pages.meta_keywords as meta_keywords',
        'services_pages.whatsapp_number as whatsapp_number',
        'services_pages.whatsapp_status as whatsapp_status',
        'services_pages.call_number as call_number',
        'services_pages.call_status as call_status',
        'services_pages.is_govt_apply as is_govt_apply',
        'services_pages.is_price_show as is_price_show',
        'services_pages.whatsapp_text as whatsapp_text',
        'services_pages.standard_time_duration as standard_time_duration',
        'services_pages.rush_time_duration as rush_time_duration',
        'services_pages.express_time_duration as express_time_duration',

        'route_visa.visa_url as visa_url'
        )
      ->where('services_pages.language_id',env('APP_LANG'))
      ->where('services_pages.id',$id)
      ->where("route_visa.type_of_url","services")
      ->join("route_visa","route_visa.visa_id","=","services_pages.id")
      ->first();

      return view('admin.services.edit',compact('servicesData'));
    }

    public function destroyServices(Request $request){
        $servicesData = DB::table('services_pages')->where('id', $request->id)->first();

        DB::table('services_pages')->where('id', $request->id)->limit(1)
        ->delete();

        DB::table('route_visa')->where('language_id',env('APP_LANG'))->where("type_of_url","services")->where('visa_id', $request->id)->limit(1)
        ->delete();

        DB::table('services_faqs')->where('language_id',env('APP_LANG'))->where('services_id', $request->id)->delete();

        $applyData = DB::table('services_apply_page_content')->where('services_id', $request->id)->first();

        DB::table('services_apply_page_content')->where('services_id', $request->id)->limit(1)
        ->delete();

        DB::table('services_country_price')->where('services_id', $request->id)->limit(1)
        ->delete();

        if(isset($servicesData->services_landing_img) && $servicesData->services_landing_img != ""){
          $oldImagePath = public_path('images/services/').$servicesData->services_landing_img;
          if (file_exists($oldImagePath)) {
            @unlink($oldImagePath);
          }
        }
        if(isset($servicesData->thank_you_img) &&  $applyData->thank_you_img != ""){
          $oldImagePath = public_path('images/services/apply/').$applyData->thank_you_img;
          if (file_exists($oldImagePath)) {
            @unlink($oldImagePath);
          }
        }
        return redirect()->route('admin.services.index');
    }

    public function faqServices($id){
      $faqData = DB::table('services_faqs')->where('language_id',env('APP_LANG'))->where('services_id',$id)->get();

      return view('admin.services.faqlist',compact('faqData','id'));
    }

    public function faqCreateServices($id){
      $faqData = [];

      return view('admin.services.faqCreate',compact('faqData','id'));
    }

    public function faqStoreServices(Request $request,$id){
      DB::table('services_faqs')->insert([
        'language_id' => env('APP_LANG'),
        'services_id' => $id,
        'question' => $request['question'],
        'answer' => $request['answer']
      ]);
      return redirect()->route('admin.services.faqList',$id);

    }

    public function faqEditServices($id,$faqId){
      $faqData = DB::table('services_faqs')->where('language_id',env('APP_LANG'))->where('services_id',$id)->where('id',$faqId)->first();

      return view('admin.services.faqEdit',compact('faqData','id'));
    }
    public function faqUpdateServices(Request $request,$id,$faqId){
      DB::table('services_faqs')
      ->where('language_id',env('APP_LANG'))
      ->where('services_id',$id)
      ->where('id',$faqId)
      ->update([
        'language_id' => env('APP_LANG'),
        'services_id' => $id,
        'question' => $request['question'],
        'answer' => $request['answer']
      ]);
      return redirect()->route('admin.services.faqList',$id);

    }
    public function faqDeleteServices($id,$faqId){

      DB::table('services_faqs')->where('language_id',env('APP_LANG'))->where('services_id',$id)->where('id',$faqId)->delete();

      return redirect()->route('admin.services.faqList',$id);

    }
    public function applyDetailList($services_id){
      $applyData = DB::table('services_apply_page_content')->where('services_id', $services_id)->first();
      return view('admin.services.applyDetailList',compact('applyData'));
    }

    public function applyDetailSave(Request $request, $services_id){


      $applyData = DB::table('services_apply_page_content')->where('services_id', $services_id)->first();

      $data =  [
          'thank_you_content' => $request['thank_you_content'],
        ];

      if ($request->hasFile('thank_you_img')) {
        if($applyData->thank_you_img != ""){
          $oldImagePath = public_path('images/services/apply/').$applyData->thank_you_img;
          if (file_exists($oldImagePath)) {
            @unlink($oldImagePath);
          }
        }
        $images = $request->thank_you_img->getClientOriginalName();
        $images = time().'_services_'.$images; // Add current time before image name
        $thank_you_img = $images;
        $request->thank_you_img->move(public_path('images/services/apply'),$thank_you_img);
        $data['thank_you_img'] = $thank_you_img;
      }

      DB::table('services_apply_page_content')->where('services_id',$services_id)->where('language_id',env('APP_LANG'))->update($data);

      return redirect()->route('admin.services.index');
    }

    public function dataEntryList($services_id){

      $servicesData = DB::table('services_pages')->where('id', $services_id)->first();
      if(!isset($servicesData->id)){
        return redirect()->route('admin.services.index');
      }
      $servicesType = DB::table('services_country_price')->where('services_id', $services_id)->where('language_id',env('APP_LANG'))->get();

      return view('admin.services.dataEntryList',compact('servicesType','services_id'));
    }

    public function dataEntryUpdate($services_id){

      return view('admin.services.dataEntryUpdate',compact('services_id'));

    }

    public function dataEntrySave(Request $request){
      $this->validate($request, [
       'file_name'  => 'required|mimes:xls,xlsx'
      ]);

      $path = $request->file('file_name')->getRealPath();
      $data = Excel::load($path)->get()->toArray();

      if(count($data) < 1){
        return back()->with('error', 'Invalid Sheet');

      }
      $servicesData = DB::table('services_pages')->where('id', $request->services_id)->first();
      if(!isset($servicesData->id)){
        return redirect()->route('admin.services.index');
      }

      $tempData = [];
      foreach ($data[0] as $key => $value) {
        $tempData[] =[
            'language_id' => env('APP_LANG'),
            'services_id' => $request->services_id,
            'nationality' => $value['nationality'],
            'govt_fee' => $value['govt_fee'] && is_numeric($value['govt_fee']) ? $value['govt_fee'] : 0.0,
            'standard_usd_price' => $value['standard_usd_price'] && is_numeric($value['standard_usd_price']) ? $value['standard_usd_price'] : 0.0,
            'rush_usd_price' => $value['rush_usd_price'] && is_numeric($value['rush_usd_price']) ? $value['rush_usd_price'] : 0.0,
            'express_usd_price' => $value['express_usd_price'] && is_numeric($value['express_usd_price']) ? $value['express_usd_price'] : 0.0
        ];
      }
      DB::table('services_country_price')->where('language_id',env('APP_LANG'))->where("services_id",$request->services_id)->delete();
      DB::table('services_country_price')->insert($tempData);

      return redirect()->route('admin.services.dataEntryList',[$request->services_id])->with("success","Excel Upload Successfully");
    }

    public function contactList()
    {
        $visaData = DB::table("services_contact_us")->orderBy('id', 'DESC')
        ->get();
        return view('admin.services.contactList',compact('visaData'));
    }

    public function applicationList(){
      $visaData = DB::table("services_apply_detail")->orderBy('id', 'DESC')
      ->get();
      return view('admin.services.applicationList',compact('visaData'));
    }

    public function applicationDetail($application_id){
        $visaData = DB::table("services_apply_detail")
        ->where("services_apply_detail.id",$application_id)
        ->first();

        if(!isset($visaData->id)){
           return redirect()->back()->with('success', 'No Data available');
        }

        return view('admin.services.applicationDetail',compact('visaData'));
    }
}

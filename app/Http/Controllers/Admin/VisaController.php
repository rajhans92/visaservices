<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
// use App\Http\Requests\Admin\UpdateVisaRequest;

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
      $visaData = DB::table('visa_pages')
      ->where('visa_pages.language_id',env('APP_LANG'))
      ->get();

      // $countryData = DB::table('country')->select('country_name')->where('country.language_id',env('APP_LANG'))->whereNotIn('country_name',function($qa){
      //
      // })
      // ->get();

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
           'visa_popular_title' => $request['visa_popular_title']
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

    public function updateCountry(UpdateCountryRequest $request, $id){

      $countryData = DB::table('country')->where('id',$id)->where('country.language_id',env('APP_LANG'))
      ->first();

      $data =  [
           'country_name' => $request['country_name'],
           'country_code' => $request['country_code'],
        ];

      if ($request->hasFile('country_flag')) {
        if($countryData->country_flag != ""){
          $oldImagePath = public_path('images/country/').$countryData->country_flag;
          if (file_exists($oldImagePath)) {
            @unlink($oldImagePath);
          }
        }
          $images = $request->country_flag->getClientOriginalName();
          $images = time().'_flag_'.$images; // Add current time before image name
          $country_flag = $images;
          $request->country_flag->move(public_path('images/country'),$country_flag);
          $data['country_flag'] = $country_flag;
      }
      DB::table('country')->where('id',$id)->where('language_id',env('APP_LANG'))->update($data);

      if(isset($request['country_popular_visa']) && count($request['country_popular_visa'])){
        DB::table('country_popular_visa')->where('language_id',env('APP_LANG'))->where('country_name_one',$countryData->country_name)->delete();

        $data = [];
          foreach ($request['country_popular_visa'] as $key => $value) {
            $data[] = [
            'language_id'=> env('APP_LANG'),
            'country_name_one' => $request['country_name'],
            'country_name_many' => $value
            ];
          }
          DB::table('country_popular_visa')->insert($data);
      }

      if($countryData->country_name != $request['country_name']){
        $recheck = DB::table('country_popular_visa')->where('language_id',env('APP_LANG'))->where('country_name_many',$countryData->country_name)->count();
        if($recheck  > 0){
          DB::table('country_popular_visa')->where('country_name_many',$countryData->country_name)->where('language_id',env('APP_LANG'))->update(['country_name_many'=>$request['country_name']]);
        }
      }
      return redirect()->route('admin.country.index');
    }

    public function editCountry($id){
      $countryData = DB::table('country')->where('id',$id)->where('country.language_id',env('APP_LANG'))
      ->first();

      $country = DB::table('country_popular_visa')->where('country_name_one',$countryData->country_name)->where('language_id',env('APP_LANG'))
      ->get();
      $countrylist = DB::table('country')->select('country_name')->where('country.language_id',env('APP_LANG'))
      ->get();
      $countrySelectedlist = [];
      foreach ($country as $key => $value) {
        $countrySelectedlist[] = $value->country_name_many;
       }
      return view('admin.Country.edit',compact('countryData','countrylist','countrySelectedlist'));
    }

    public function editStatusCountry(Request $request){
        DB::table('country')->where('id', $request->id)->limit(1)
        ->update(array('status' => $request->status));

        return redirect()->route('admin.country.index');
    }

    public function destroyCountry(Request $request){
        DB::table('country')->where('id', $request->id)->limit(1)
        ->delete();

        return redirect()->route('admin.country.index');
    }
}

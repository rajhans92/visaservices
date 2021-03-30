<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Admin\UpdateCountryRequest;

class CountryController extends Controller
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
        $countryData = DB::table('country')
        ->where('country.language_id',env('APP_LANG'))
        ->get();

        foreach ($countryData as $key => $value) {
          $temp = DB::table('country_popular_visa')
          ->where('country_popular_visa.language_id',env('APP_LANG'))
          ->where('country_popular_visa.country_name_one',$value->country_name)
          ->get();
          $temStr = "";
          foreach ($temp as $key1 => $value1) {
            $temStr .= $value1->country_name_many.",\n";
          }
          $temStr = trim($temStr,",\n");
          $value->popular_visa = $temStr;
        }
        return view('admin.country.list',compact('countryData'));
    }

    public function createCountry(){
      $countryData = DB::table('country')->select('country_name')->where('country.language_id',env('APP_LANG'))
      ->get();
      return view('admin.country.create',compact('countryData'));
    }

    public function storeCountry(Request $request){
      $tempNm = DB::table('country')->where("language_id",env('APP_LANG'))->where('country_name',$request['country_name'])->count();
      if($tempNm > 0){
          return redirect()->back()->with('error','Country Name should be unique!');
      }

      $tempCd = DB::table('country')->where("language_id",env('APP_LANG'))->where('country_code',$request['country_code'])->count();
      if($tempCd > 0){
          return redirect()->back()->with('error','Country Code should be unique!');
      }
      // exit(print_r($request->all()));
      $data =  [
           'language_id' => env('APP_LANG'),
           'country_name' => $request['country_name'],
           'country_code' => $request['country_code'],
           'status' => 0
        ];

      if ($request->hasFile('country_flag')) {
          $images = $request->country_flag->getClientOriginalName();
          $images = time().'_flag_'.$images; // Add current time before image name
          $country_flag = $images;
          $request->country_flag->move(public_path('images/country'),$country_flag);
          $data['country_flag'] = $country_flag;
      }
      DB::table('country')->insert($data);

      if(isset($request['country_popular_visa']) && count($request['country_popular_visa'])){
        $data = [];
          foreach ($request['country_popular_visa'] as $key => $value) {
            $data['language_id'] = env('APP_LANG');
            $data['country_name_one'] = $request['country_name'];
            $data['country_name_many'] = $value;
          }
          DB::table('country_popular_visa')->insert($data);
      }

      return redirect()->route('admin.country.index');
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
      return view('admin.country.edit',compact('countryData','countrylist','countrySelectedlist'));
    }

    public function editStatusCountry(Request $request){
        DB::table('country')->where('id', $request->id)->limit(1)
        ->update(array('status' => $request->status));

        return redirect()->route('admin.country.index');
    }

    public function destroyCountry(Request $request){
      $countryData = DB::table('country')->where('id',$request->id)->where('country.language_id',env('APP_LANG'))
      ->first();

        DB::table('country')->where('id', $request->id)->limit(1)
        ->delete();

        DB::table('port_of_arrival')
       ->where('port_of_arrival.country_id',$request->id)
       ->where('port_of_arrival.language_id',env('APP_LANG'))
       ->delete();

        if($countryData->country_flag != ""){
          $oldImagePath = public_path('images/country/').$countryData->country_flag;
          if (file_exists($oldImagePath)) {
            @unlink($oldImagePath);
          }
        }
        return redirect()->route('admin.country.index');
    }

    public function portOfArrivalCountry($country_id)
    {
        $countryData = DB::table('port_of_arrival')
        ->where('port_of_arrival.country_id',$country_id)
        ->where('port_of_arrival.language_id',env('APP_LANG'))
        ->get();

        return view('admin.country.portOfArrival',compact('countryData','country_id'));
    }

    public function portOfArrivalAddCountry($country_id)
    {
        return view('admin.country.portOfArrivalAdd',compact('country_id'));
    }

    public function portOfArrivalStoreCountry(Request $request,$country_id){

      DB::table('port_of_arrival')->insert([
        'language_id' => env('APP_LANG'),
        'country_id' => $country_id,
        'port_name' => $request['port_name']
      ]);

      return redirect()->route('admin.country.portOfArrivalCountry',[$country_id]);

    }

    public function portOfArrivalEditCountry($country_id,$port_id)
    {
        $countryData = DB::table('port_of_arrival')
        ->where('port_of_arrival.id',$port_id)
        ->where('port_of_arrival.country_id',$country_id)
        ->where('port_of_arrival.language_id',env('APP_LANG'))
        ->first();

        return view('admin.country.portOfArrivalEdit',compact('countryData','country_id'));
    }

    public function portOfArrivalUpdateCountry(Request $request,$country_id,$port_id){
        DB::table('port_of_arrival')
        ->where('id',$port_id)
        ->update([
          'port_name' => $request['port_name']
        ]);

        return redirect()->route('admin.country.portOfArrivalCountry',[$country_id]);
    }

    public function portOfArrivalDeleteCountry(Request $request,$country_id,$port_id){

        DB::table('port_of_arrival')
        ->where('id',$port_id)
       ->where('country_id',$country_id)
       ->where('language_id',env('APP_LANG'))
       ->delete();

        return redirect()->route('admin.country.portOfArrivalCountry',[$country_id]);
    }
}

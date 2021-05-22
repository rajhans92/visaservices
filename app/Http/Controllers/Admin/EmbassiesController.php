<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Admin\UpdateVisaRequest;
use Excel;

class EmbassiesController extends Controller
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
    public function embassiesList()
    {
        $embassiesList = DB::table('embassies')
        ->get();

        return view('admin.embassies.list',compact('embassiesList'));
    }

    public function embassiesDelete(Request $request, $embassies_id){
      $embassiesDetail = DB::table('embassies')
      ->where("embassies.id",$embassies_id)
      ->first();
      if(!isset($embassiesDetail->id)){
        return redirect()->back();
      }
      DB::table('embassies')
      ->where("embassies.id",$embassies_id)
      ->delete();
      return redirect()->route('admin.embassies.embassiesList');
    }


    public function embassiesEdit(Request $request, $embassies_id){
      $embassiesDetail = DB::table('embassies')
      ->where("embassies.id",$embassies_id)
      ->first();
      if(!isset($embassiesDetail->id)){
        return redirect()->back();
      }
      return view('admin.embassies.edit',compact('embassiesDetail'));
    }

    public function embassiesUpdate(Request $request, $embassies_id){

      $embassiesDetail = DB::table('embassies')
      ->where("embassies.id",$embassies_id)
      ->first();

      if(!isset($embassiesDetail->id)){
        return redirect()->back();
      }

      $data =  [
          'embassy_of' => $request['embassy_of'],
          'embassy_in' => $request['embassy_in'],
          'heading' => $request['heading'],
          'address' => $request['address'],
          'contact_us' => isset($request['contact_us']) && $request['contact_us'] != "" ? $request['contact_us'] :"",
          'email_id' => isset($request['email_id']) && $request['email_id'] != "" ? $request['email_id'] :"",
          'website' => isset($request['website']) && $request['website'] != "" ? $request['website'] :"",
          'map_location' => isset($request['map_location']) && $request['map_location'] != "" ? $request['map_location'] :""
        ];

      DB::table('embassies')->where('id',$embassies_id)->where('language_id',env('APP_LANG'))->update($data);

      return redirect()->route('admin.embassies.embassiesList');
    }


    public function embassiesUpload(){

      return view('admin.embassies.showUploadScreen');

    }

    public function embassiesSave(Request $request){
      $this->validate($request, [
       'file_name'  => 'required|mimes:xls,xlsx'
      ]);

      $path = $request->file('file_name')->getRealPath();
      $data = Excel::load($path)->get()->toArray();

      if(count($data) < 1){
        return back()->with('error', 'Invalid Sheet');

      }

      $tempData = [];
      foreach ($data[0] as $key => $value) {
        $tempData[] = [
            'language_id' => env('APP_LANG'),
            'embassy_of' => $value['embassy_of'],
            'embassy_in' => $value['embassy_in'],
            'heading' => $value['heading'],
            'address' => $value['address'],
            'contact_us' => $value['contact_us'],
            'email_id' => $value['email_address'],
            'website' => $value['website'],
            'map_location' => $value['map_location']
        ];
      }

      DB::table('embassies')->insert($tempData);

      return redirect()->route('admin.embassies.embassiesList')->with("success","Excel Upload Successfully");
    }

}

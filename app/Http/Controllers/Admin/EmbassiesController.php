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
     public function index(){
       $embassiesList = DB::table('embassies')
       ->get();

       return view('admin.embassies.embassiesList',compact('embassiesList'));

     }

     public function embassiesNameUpload(){

       return view('admin.embassies.showNameUploadScreen');

     }


     public function embassiesNameSave(Request $request){
       $this->validate($request, [
        'file_name'  => 'required|mimes:xls,xlsx'
       ]);

       $path = $request->file('file_name')->getRealPath();
       $data = Excel::load($path)->get()->toArray();

       if(count($data) < 1){
         return back()->with('error', 'Invalid Sheet');

       }

       $tempData = [];
       $name = [];
       $url = [];
       foreach ($data[0] as $key => $value) {
         $tempData = [
             'name' => $value['embassy_name'],
             'url' => $value['url']
         ];
         $count = DB::table('route_visa')->where('visa_url',$value['url'])->count();
         if($count){
           return back()->with('error', 'Dublicate Url ['.$value['url'].']');
         }
         $count = DB::table('embassies')->where('name',$value['embassy_name'])->count();
         if($count){
           return back()->with('error', 'Dublicate embassy name ['.$value['embassy_name'].']');
         }

         $id = DB::table('embassies')->insertGetId($tempData);

         DB::table('route_visa')->insert([
           'language_id' => env('APP_LANG'),
           'visa_id' => $id,
           'visa_url' => $value['url'],
           'class' => 'Front\EmbassiesController',
           'method' => 'embassiesListById',
           'type_of_url' => 'embassy'
         ]);
       }

       return redirect()->route('admin.embassies.index')->with("success","Excel Upload Successfully");
     }

     public function embassiesNameDelete(Request $request, $embassies_id){
       $embassiesDetail = DB::table('embassies')
       ->where("embassies.id",$embassies_id)
       ->first();
       if(!isset($embassiesDetail->id)){
         return redirect()->back();
       }
       DB::table('embassies')
       ->where("embassies.id",$embassies_id)
       ->delete();
       DB::table('embassies_detail')
       ->where("embassies_detail.embassies_id",$embassies_id)
       ->delete();
       DB::table('route_visa')
       ->where("route_visa.visa_id",$embassies_id)
       ->where("route_visa.type_of_url",'embassy')
       ->where("route_visa.language_id",env('APP_LANG'))
       ->delete();

       return redirect()->route('admin.embassies.index');
     }

     public function embassiesNameEdit(Request $request, $embassies_id){
       $embassiesDetail = DB::table('embassies')
       ->where("embassies.id",$embassies_id)
       ->first();
       if(!isset($embassiesDetail->id)){
         return redirect()->back();
       }
       return view('admin.embassies.nameEdit',compact('embassiesDetail'));
     }

     public function embassiesNameUpdate(Request $request, $embassies_id){

       $embassiesDetail = DB::table('embassies')
       ->where("embassies.id",$embassies_id)
       ->first();

       if(!isset($embassiesDetail->id)){
         return redirect()->back();
       }
       $count = DB::table('embassies')
       ->where("embassies.name",$request['name'])
       ->whereNotIn('id',[$embassies_id])
       ->count();
       if($count){
         return back()->with('error', 'Dublicate embassy name ['.$request['name'].']');
       }
       $count = DB::table('embassies')
       ->where("embassies.url",$request['url'])
       ->whereNotIn('id',[$embassies_id])
       ->count();
       if($count){
         return back()->with('error', 'Dublicate embassy url ['.$request['url'].']');
       }
       $data =  [
           'name' => $request['name'],
           'url' => $request['url']
         ];
       DB::table('embassies')->where('id',$embassies_id)->update($data);
       $data =  [
           'visa_url' => $request['url']
         ];
       DB::table('route_visa')->where('visa_id',$embassies_id)->where('type_of_url','embassy')->update($data);

       return redirect()->route('admin.embassies.index');
     }


    public function embassiesList($embassies_id)
    {
        $embassiesList = DB::table('embassies_detail')
        ->where('embassies_id',$embassies_id)
        ->get();

        return view('admin.embassies.list',compact('embassiesList','embassies_id'));
    }

    public function embassiesDelete(Request $request, $embassies_id,$id){
      $embassiesDetail = DB::table('embassies_detail')
      ->where("embassies_id",$id)
      ->where("id",$embassies_id)
      ->first();
      if(!isset($embassiesDetail->id)){
        return redirect()->back();
      }
      DB::table('embassies_detail')
      ->where("embassies_id",$id)
      ->where("id",$embassies_id)
      ->delete();
      return redirect()->route('admin.embassies.embassiesList',$embassies_id);
    }


    public function embassiesEdit(Request $request, $embassies_id,$id){
      $embassiesDetail = DB::table('embassies_detail')
      ->where("embassies_id",$embassies_id)
      ->where("id",$id)
      ->first();
      if(!isset($embassiesDetail->id)){
        return redirect()->back();
      }
      return view('admin.embassies.edit',compact('embassiesDetail','embassies_id'));
    }

    public function embassiesUpdate(Request $request, $embassies_id,$id){

      $embassiesDetail = DB::table('embassies_detail')
      ->where("embassies_id",$embassies_id)
      ->where("id",$id)
      ->first();

      if(!isset($embassiesDetail->id)){
        return redirect()->back();
      }

      $data =  [
          'embassy_in' => $request['embassy_in'],
          'embassy_city' => $request['embassy_city'],
          'heading' => $request['heading'],
          'address' => $request['address'],
          'contact_us' => isset($request['contact_us']) && $request['contact_us'] != "" ? $request['contact_us'] :"",
          'email_id' => isset($request['email_id']) && $request['email_id'] != "" ? $request['email_id'] :"",
          'website' => isset($request['website']) && $request['website'] != "" ? $request['website'] :"",
          'map_location' => isset($request['map_location']) && $request['map_location'] != "" ? $request['map_location'] :""
        ];

      DB::table('embassies_detail')->where('id',$id)->where('embassies_id',$embassies_id)->where('language_id',env('APP_LANG'))->update($data);

      return redirect()->route('admin.embassies.embassiesList',$embassies_id);
    }


    public function embassiesUpload($embassies_id){

      return view('admin.embassies.showUploadScreen',compact('embassies_id'));

    }

    public function embassiesSave(Request $request,$embassies_id){
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
            'embassies_id' => $embassies_id,
            'embassy_in' => $value['embassy_in'],
            'embassy_city' => $value['embassy_city'],
            'heading' => $value['heading'],
            'address' => $value['address'],
            'contact_us' => $value['contact_us'],
            'email_id' => $value['email_address'],
            'website' => $value['website'],
            'map_location' => $value['map_location']
        ];
      }

      DB::table('embassies_detail')->insert($tempData);

      return redirect()->route('admin.embassies.embassiesList',$embassies_id)->with("success","Excel Upload Successfully");
    }

}

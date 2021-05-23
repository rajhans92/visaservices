<?php

namespace App\Http\Controllers\Front;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Mail\ApplyNotificationMail;

class EmbassiesController extends Controller
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
    public function embassiesList(Request $request){

      $dataEmbassies = DB::table('embassies')->get();
      $data = [];
      foreach ($dataEmbassies as $key => $value) {

         $data[strtolower(substr($value->name,0,1))][] = ['name'=> $value->name,'url' => $value->url];
      }
        // exit(print_r($data));
      return view('front.embassies.list',compact('data'));

    }

    public function embassiesListById(Request $request){
      $uri = $request->path();
      $embassy = DB::table('embassies')->where('url',$uri)->first();
      if(!isset($embassy->id)){
        return redirect()->back();
      }
      $data = [];
      $data = DB::table('embassies')->get();
      $embassyList = DB::table('embassies_detail')->where('embassies_id',$embassy->id)->get();

      return view('front.embassies.detail',compact('embassyList','data','embassy'));

    }

}

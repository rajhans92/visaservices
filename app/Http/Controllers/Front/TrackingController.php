<?php

namespace App\Http\Controllers\Front;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Mail\ApplyNotificationMail;

class TrackingController extends Controller
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

     public function tracking(){
       return view('front.tracking.index');
     }

     public function statusDetail(Request $request){
       $responseData = ["status"=>true];
       $responseData['data'] = DB::table("visa_apply_detail")->where("order_id",$request->orderNumber)->first();
       if(!isset($responseData['data']->id)){
         $responseData['data'] = DB::table("services_apply_detail")->where("order_id",$request->orderNumber)->first();
         if(!isset($responseData['data']->id)){
           $responseData["status"] =false;
         }
       }
       $responseData['subSet'] = DB::table("visa_apply_applicant")->where("order_id",$request->orderNumber)->get();

       return json_encode($responseData);
     }


}

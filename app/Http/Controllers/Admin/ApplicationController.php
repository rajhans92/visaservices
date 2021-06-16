<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ApplicationController extends Controller
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
        $visaData = DB::table("visa_apply_detail")->orderBy('id', 'DESC')
        ->get();
        return view('admin.application.list',compact('visaData'));
    }

    public function applicationDetail($application_id){
        $visaData = DB::table("visa_apply_detail")
        ->where("visa_apply_detail.id",$application_id)
        ->first();

        if(!isset($visaData->id)){
           return redirect()->back()->with('success', 'No Data available');
        }

        $visaApplicant = DB::table("visa_apply_applicant")
        ->where("visa_apply_applicant.order_id",$visaData->order_id)
        ->get();

        return view('admin.application.show',compact('visaData','visaApplicant'));
    }

    public function contactList()
    {
        $visaData = DB::table("visa_contact_us")->orderBy('id', 'DESC')
        ->get();
        return view('admin.application.contactList',compact('visaData'));
    }

    public function trackingDetail($application_id){
        $visaData = DB::table("visa_apply_detail")
        ->where("visa_apply_detail.id",$application_id)
        ->first();

        if(!isset($visaData->id)){
           return redirect()->back()->with('success', 'No Data available');
        }

        return view('admin.application.trackingDetail',compact('visaData'));
    }

    public function trackingDetailUpdate(Request $request,$application_id){
        $visaData = DB::table("visa_apply_detail")
        ->where("visa_apply_detail.id",$application_id)
        ->first();

        if(!isset($visaData->id)){
           return redirect()->back()->with('success', 'No Data available');
        }
         DB::table('visa_apply_detail')->where('id',$application_id)->update([
           "tracking_status" => $request['tracking_status'],
           "tracking_status_desc" => $request['tracking_status_desc']
         ]);

        return redirect()->route('admin.application.index');
    }
}

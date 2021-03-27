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
        $visaData = DB::table("visa_apply_detail")
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
}

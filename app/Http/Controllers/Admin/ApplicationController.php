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
        ->select(
          "visa_apply_detail.id as id",
          "visa_apply_detail.order_id as order_id",
          "visa_apply_detail.email_id as email_id",
          "visa_apply_detail.visa_process_type as visa_process_type",
          "visa_apply_detail.submission_date as submission_date",
          "visa_apply_detail.payment_status as payment_status",
          "visa_apply_detail.total_payment as total_payment",
          "visa_type_name.visa_type_name as visa_type_name"
        )
        ->join("visa_type_name","visa_type_name.id","=","visa_apply_detail.type_of_visa_id")
        ->get();
        return view('admin.application.list',compact('visaData'));
    }

    public function applicationDetail(){
      exit("coming soon");
    }
}

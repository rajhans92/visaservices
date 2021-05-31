<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Admin\UpdateVisaRequest;
use Excel;

class FaqController extends Controller
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

    public function list(){
      $faqData = DB::table('faq_section')->where('language_id',env('APP_LANG'))->get();

      return view('admin.faq.faqlist',compact('faqData'));
    }

    public function create(){
      $faqData = [];

      return view('admin.faq.faqCreate',compact('faqData'));
    }

    public function save(Request $request){
      DB::table('faq_section')->insert([
        'language_id' => env('APP_LANG'),
        'question' => $request['question'],
        'answer' => $request['answer']
      ]);
      return redirect()->route('admin.faq.list');

    }

    public function edit($id){
      $faqData = DB::table('faq_section')->where('language_id',env('APP_LANG'))->where('id',$id)->first();

      return view('admin.faq.faqEdit',compact('faqData'));
    }
    public function update(Request $request,$id){
      DB::table('faq_section')
      ->where('language_id',env('APP_LANG'))
      ->where('id',$id)
      ->update([
        'language_id' => env('APP_LANG'),
        'question' => $request['question'],
        'answer' => $request['answer']
      ]);
      return redirect()->route('admin.faq.list');

    }
    public function delete($id){

      DB::table('faq_section')->where('language_id',env('APP_LANG'))->where('id',$id)->delete();

      return redirect()->route('admin.faq.list');

    }

}

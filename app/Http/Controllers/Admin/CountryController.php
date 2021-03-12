<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

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
        return view('admin.Country.list',compact('countryData'));
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

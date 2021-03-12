<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class HeaderFooterController extends Controller
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
        $menuData = DB::table('menu')->where('language_id',env('APP_LANG'))->get();

        return view('admin.headerFooter.headerList',compact('menuData'));
    }

    public function editHeader($id)
    {
        $menuData = DB::table('menu')->where('language_id',env('APP_LANG'))->where('id',$id)->first();

        return view('admin.headerFooter.headerEdit',compact('menuData'));
    }

    public function updateHeader(Request $request, $id)
    {

          $data =  [
               'name' => $request['name'],
               'updated_at' => date('Y-m-d')
            ];

          DB::table('menu')->where('id','=',$id)->update($data);

          return redirect()->route('admin.header.index');
    }

    public function footerList()
    {
        return view('admin.headerFooter.footerList');
    }

    public function footerTagEdit($lang_id){

      $footerTag = DB::table('footer_detail')
      ->select(
        'id','language_id','tag_1','tag_2','tag_3','tag_4','tag_link_1','tag_link_2','tag_link_3','tag_link_4')
      ->where('language_id',$lang_id)
      ->first();
      $urlSet = ["-",'blog/how-to-get-visa','blog/how-to-save-money','visa/india','visa/singapore'];

      return view('admin.headerFooter.footerTagEdit',compact('footerTag','urlSet'));
    }

    public function footerTagUpdate(Request $request, $lang_id)
    {
          $data =  [
               'tag_1' => $request['tag_1'],
               'tag_2' => $request['tag_2'],
               'tag_3' => $request['tag_3'],
               'tag_4' => $request['tag_4'],
               'tag_link_1' => $request['tag_link_1'],
               'tag_link_2' => $request['tag_link_2'],
               'tag_link_3' => $request['tag_link_3'],
               'tag_link_4' => $request['tag_link_4'],
               'updated_at' => date('Y-m-d')
            ];

          DB::table('footer_detail')->where('language_id','=',$lang_id)->update($data);

          return redirect()->route('admin.footer.index');
    }

    public function footerSocialEdit($lang_id){

      $footerData = DB::table('footer_detail')->select('id','language_id','social_network_title','social_network_link1','social_network_link2','social_network_link3')->where('language_id',$lang_id)->first();
      return view('admin.headerFooter.footerSocialEdit',compact('footerData'));
    }

    public function footerSocialUpdate(Request $request, $lang_id)
    {
          $data =  [
               'social_network_title' => $request['social_network_title'],
               'social_network_link1' => $request['social_network_link1'],
               'social_network_link2' => $request['social_network_link2'],
               'social_network_link3' => $request['social_network_link3']
            ];

          DB::table('footer_detail')->where('language_id','=',$lang_id)->update($data);

          return redirect()->route('admin.footer.index');
    }

    public function footerLogoEdit($lang_id){

      $footerLogo = DB::table('footer_detail')->select('id','language_id','img_left','img_right')->where('language_id',$lang_id)->first();
      return view('admin.headerFooter.footerLogoEdit',compact('footerLogo'));
    }

    public function footerLogoUpdate(Request $request, $lang_id){

      $img_left = '';
      $data = [];
      $footerLogo = DB::table('footer_detail')->select('id','language_id','img_left','img_right')->where('language_id',$lang_id)->first();

      if ($request->hasFile('img_left')) {
          if($footerLogo->img_left != ""){
            $oldImagePath = public_path('images/footer/').$footerLogo->img_left;
            if (file_exists($oldImagePath)) {
              @unlink($oldImagePath);
            }
          }
          $images = $request->img_left->getClientOriginalName();
          $images = time().'_left_'.$images; // Add current time before image name
          $img_left = $images;
          $request->img_left->move(public_path('images/footer'),$img_left);
      }

      if($img_left != ""){
        $data['img_left'] = $img_left;
      }

      $img_right = "";
      if ($request->hasFile('img_right')) {
          if($footerLogo->img_right != ""){
            $oldImagePath = public_path('images/footer/').$footerLogo->img_right;
            if (file_exists($oldImagePath)) {
              @unlink($oldImagePath);
            }
          }
          $images = $request->img_right->getClientOriginalName();
          $images = time().'_right_'.$images; // Add current time before image name
          $img_right = $images;
          $request->img_right->move(public_path('images/footer'),$img_right);
      }

      if($img_right != ""){
        $data['img_right'] = $img_right;
      }
      if(count($data))
        DB::table('footer_detail')->where('language_id','=',$lang_id)->update($data);

        return redirect()->route('admin.footer.index');
    }

    public function footerCompanyEdit($lang_id){

      $footerData = DB::table('footer_detail')->select('id','language_id','company_detail')->where('language_id',$lang_id)->first();
      return view('admin.headerFooter.footerCompanyEdit',compact('footerData'));
    }

    public function footerCompanyUpdate(Request $request, $lang_id)
    {
          $data =  [
               'company_detail' => $request['company_detail'],
               'updated_at' => date('Y-m-d')
            ];

          DB::table('footer_detail')->where('language_id','=',$lang_id)->update($data);

          return redirect()->route('admin.footer.index');
    }

    public function footerDisclaimerEdit($lang_id){

      $footerData = DB::table('footer_detail')->select('id','language_id','disclaimer_title','disclaimer_detail')->where('language_id',$lang_id)->first();

      return view('admin.headerFooter.footerDisclaimerEdit',compact('footerData'));
    }

    public function footerDisclaimerUpdate(Request $request, $lang_id)
    {
          $data =  [
               'disclaimer_title' => $request['disclaimer_title'],
               'disclaimer_detail' => $request['disclaimer_detail'],
               'updated_at' => date('Y-m-d')
            ];

          DB::table('footer_detail')->where('language_id','=',$lang_id)->update($data);

          return redirect()->route('admin.footer.index');
    }

    public function footerOfficeEdit($lang_id){

      $footerData = DB::table('footer_detail')->select('id','language_id','address_title_1','address_title_2','address_title_3','address_title_4','address_detail_1','address_detail_2','address_detail_3','address_detail_4')->where('language_id',$lang_id)->first();

      return view('admin.headerFooter.footerOfficeEdit',compact('footerData'));
    }

    public function footerOfficeUpdate(Request $request, $lang_id)
    {
          $data =  [
               'address_title_1' => $request['address_title_1'],
               'address_title_2' => $request['address_title_2'],
               'address_title_3' => $request['address_title_3'],
               'address_title_4' => $request['address_title_4'],
               'address_detail_1' => $request['address_detail_1'],
               'address_detail_2' => $request['address_detail_2'],
               'address_detail_3' => $request['address_detail_3'],
               'address_detail_4' => $request['address_detail_4'],
               'updated_at' => date('Y-m-d')
            ];

          DB::table('footer_detail')->where('language_id','=',$lang_id)->update($data);

          return redirect()->route('admin.footer.index');
    }
}

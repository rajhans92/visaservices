<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Hash;
use Auth;

class UserProfileController extends Controller
{
    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $otherTable = "";
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 4){
          $otherTable = "subadmin";
        }
        if(Auth::user()->role_id == 2){
          $otherTable = "teacher";
        }
        if(Auth::user()->role_id == 5){
          $otherTable = "organization";
        }

        $user = DB::table('users')
                ->join($otherTable,$otherTable.".user_id",'=',"users.id")
                ->where('users.id','=',Auth::user()->id)
                ->where('role_id','=',Auth::user()->role_id)
                ->first();

        $organization = DB::table('users')
        ->select('id','first_name','last_name')
        ->where('role_id','=',5)
        ->where('status','=',2)
        ->get();

        $orgObj = array('0' => 'Self');
        foreach ($organization as $key => $value) {
          $orgObj[$value->id] = $value->first_name.' '.$value->last_name;
        }

        return view('admin.user-profile.edit', compact('user','orgObj'));
    }

    /**
     * Show the form for creating new User.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created User in storage.
     *
     * @param  \App\Http\Requests\StoreUsersRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }


    /**
     * Show the form for editing User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update User in storage.
     *
     * @param  \App\Http\Requests\UpdateUsersRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      if(Auth::user()->role_id == 1 || Auth::user()->role_id == 4){
         $this->updateSubadmin($request, $id);
      }

      if(Auth::user()->role_id == 2){
         $this->updateTeacher($request, $id);
      }

      if(Auth::user()->role_id == 5){
         $this->updateOrganization($request, $id);
      }

        return redirect()->route('admin.user-profile.index');
    }

    private function updateTeacher($request, $id){
      $this->validate($request,[
        'first_name' => 'required',
        'phone_no' => 'required|numeric|regex:/[6-9]{1}[0-9]{9}/|digits:10',
        'alt_phone_no' => 'nullable|regex:/[6-9]{1}[0-9]{9}/|digits:10',
        'dob' => 'required',
        'specialties' => 'required',
        'experience' => 'required|numeric',
        'organization_id' => 'required|numeric',
        'education' => 'required',
        'address' => 'required',
        'overview' => 'required'
      ]);
      $errors = [];
      if(isset($request['alt_phone_no']) && $request['alt_phone_no'] == $request['phone_no']){
        $errors['alt_phone_no'] = 'Alternate No should be different from Phone No';
      }

      if(isset($request['overview']) && preg_replace('/\s+/','',str_replace('&nbsp;','',trim(strip_tags($request['overview'])))) == ""){
        $errors['overview'] = 'The overview field is required.';
      }
      if(count($errors)){
        return back()->withInput($request->input())->withErrors(new \Illuminate\Support\MessageBag($errors));
      }
        $filename = '';
        if ($request->hasFile('profile_pic')) {
            $images = $request->profile_pic->getClientOriginalName();
            $images = time().'_'.$images; // Add current time before image name
            $request->profile_pic->move(env('IMG_UPLOAD_PATH').'img/teacher/profile/',$images);
            $filename = $images;

            $user = DB::table('teacher')
                ->select('profile_pic')
                ->where('user_id','=',$id)
                ->first();
           $oldImagePath = env('IMG_UPLOAD_PATH').'img/teacher/profile/'.$user->profile_pic;
            if (file_exists($oldImagePath)) {
                @unlink($oldImagePath);
            }
        }

        $banner = '';
        if ($request->hasFile('banner')) {
            $images = $request->banner->getClientOriginalName();
            $images = time().'_'.$images; // Add current time before image name
            $request->banner->move(env('IMG_UPLOAD_PATH').'img/teacher/banner/',$images);
            $banner = $images;

            $user = DB::table('teacher')
                ->select('banner')
                ->where('user_id','=',$id)
                ->first();
           $oldImagePath = env('IMG_UPLOAD_PATH').'img/teacher/banner/'.$user->banner;
            if (file_exists($oldImagePath)) {
                @unlink($oldImagePath);
            }
        }

        DB::table('users')->where('id', $id)->limit(1)
        ->update(array('first_name' => $request['first_name'],
         'last_name' => $request['last_name'],
         'phone_no' => $request['phone_no'],
         'alt_phone_no' => $request['alt_phone_no'],
         'updated_at' => date('Y-m-d'),
        'updated_by' => Auth::user()->id));

        $teacherData = array(
             'dob' => date('Y-m-d',strtotime($request['dob'])),
             'specialties' => $request['specialties'],
             'overview' => $request['overview'],
             'website' => $request['website'],
             'education' => $request['education'],
             'experience' => $request['experience'],
             'organization_id' => $request['organization_id'],
             'address' => $request['address'],
           );

        if($filename != ""){
          $teacherData['profile_pic'] = $filename;
        }
        if($banner != ""){
          $teacherData['banner'] = $banner;
        }
        DB::table('teacher')->where('user_id', $id)->limit(1)
        ->update($teacherData);
        return redirect()->back()->with('success','Profile updated successfully');

    }

    private function updateOrganization($request, $id){
      $this->validate($request,['first_name' => 'required',
        'phone_no' => 'required|numeric|regex:/[6-9]{1}[0-9]{9}/|digits:10',
        'alt_phone_no' => 'nullable|regex:/[6-9]{1}[0-9]{9}/|digits:10',
        'established_date' => 'required',
        'teacher_strength' => 'required|numeric',
        'student_strength' => 'required|numeric',
        'overview' => 'required',
        'specialties' => 'required',
        'address' => 'required']);
      $errors = [];
      if(isset($request['alt_phone_no']) && $request['alt_phone_no'] == $request['phone_no']){
        $errors['alt_phone_no'] = 'Alternate No should be different from Phone No';
      }

      if(isset($request['overview']) && preg_replace('/\s+/','',str_replace('&nbsp;','',trim(strip_tags($request['overview'])))) == ""){
        $errors['overview'] = 'The overview field is required.';
      }
      if(count($errors)){
        return back()->withInput($request->input())->withErrors(new \Illuminate\Support\MessageBag($errors));
      }
      $filename = '';
      if ($request->hasFile('profile_pic')) {
          $images = $request->profile_pic->getClientOriginalName();
          $images = time().'_'.$images; // Add current time before image name
          $request->profile_pic->move(env('IMG_UPLOAD_PATH').'img/org/profile/',$images);
          $filename = $images;

          $user = DB::table('organization')
              ->select('profile_pic')
              ->where('user_id','=',$id)
              ->first();
         $oldImagePath = env('IMG_UPLOAD_PATH').'img/org/profile/'.$user->profile_pic;
          if (file_exists($oldImagePath)) {
              @unlink($oldImagePath);
          }
      }

      $banner = '';
      if ($request->hasFile('banner')) {
          $images = $request->banner->getClientOriginalName();
          $images = time().'_'.$images; // Add current time before image name
          $request->banner->move(env('IMG_UPLOAD_PATH').'img/org/banner/',$images);
          $banner = $images;

          $user = DB::table('organization')
              ->select('banner')
              ->where('user_id','=',$id)
              ->first();
         $oldImagePath = env('IMG_UPLOAD_PATH').'img/org/banner/'.$user->banner;
          if (file_exists($oldImagePath)) {
              @unlink($oldImagePath);
          }
      }

      DB::table('users')->where('id', $id)->limit(1)
      ->update(array('first_name' => $request['first_name'],
       'last_name' => $request['last_name'],
       'phone_no' => $request['phone_no'],
       'alt_phone_no' => $request['alt_phone_no'],
       'updated_at' => date('Y-m-d'),
      'updated_by' => Auth::user()->id));

      $orgData = array(
           'established_date' => date('Y-m-d',strtotime($request['established_date'])),
           'specialties' => $request['specialties'],
           'overview' => $request['overview'],
           'website' => $request['website'],
           'teacher_strength' => $request['teacher_strength'],
           'student_strength' => $request['student_strength'],
           'address' => $request['address'],
         );

      if($filename != ""){
        $orgData['profile_pic'] = $filename;
      }
      if($banner != ""){
        $orgData['banner'] = $banner;
      }
      DB::table('organization')->where('user_id', $id)->limit(1)
      ->update($orgData);
      return redirect()->back()->with('success','Profile updated successfully');

    }

    private function updateSubadmin($request, $id){
      $this->validate($request,[
        'first_name' => 'required',
        'phone_no' => 'required|numeric|regex:/[6-9]{1}[0-9]{9}/|digits:10',
        'alt_phone_no' => 'nullable|regex:/[6-9]{1}[0-9]{9}/|digits:10',
        'dob' => 'required',
      ]);
      $errors = [];
      if(isset($request['alt_phone_no']) && $request['alt_phone_no'] == $request['phone_no']){
        $errors['alt_phone_no'] = 'Alternate No should be different from Phone No';
      }

      if(isset($request['detail']) && preg_replace('/\s+/','',str_replace('&nbsp;','',trim(strip_tags($request['detail'])))) == ""){
        $errors['detail'] = 'The detail field is required.';
      }
      if(count($errors)){
        return back()->withInput($request->input())->withErrors(new \Illuminate\Support\MessageBag($errors));
      }
      $filename = '';
      if ($request->hasFile('profile_pic')) {
          $images = $request->profile_pic->getClientOriginalName();
          $images = time().'_'.$images; // Add current time before image name
          $request->profile_pic->move(env('IMG_UPLOAD_PATH').'img/subadmin/profile/',$images);
          $filename = $images;

          $user = DB::table('subadmin')
              ->select('profile_pic')
              ->where('user_id','=',$id)
              ->first();
         $oldImagePath = env('IMG_UPLOAD_PATH').'img/subadmin/profile/'.$user->profile_pic;
          if (file_exists($oldImagePath)) {
              @unlink($oldImagePath);
          }
      }

      DB::table('users')->where('id', $id)->limit(1)
      ->update(array('first_name' => $request['first_name'],
       'last_name' => $request['last_name'],
       'phone_no' => $request['phone_no'],
       'alt_phone_no' => $request['alt_phone_no'],
       'updated_at' => date('Y-m-d'),
      'updated_by' => Auth::user()->id));

      $subadminData = array(
           'dob' => date('Y-m-d',strtotime($request['dob'])),
           'detail' => $request['detail'],
         );

      if($filename != ""){
        $subadminData['profile_pic'] = $filename;
      }
      DB::table('subadmin')->where('user_id', $id)->limit(1)
      ->update($subadminData);

      return redirect()->back()->with('success','Profile updated successfully');
    }
    /**
     * Display User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }


    /**
     * Remove User from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

    public function updateStatus(Request $request){

    }

    /**
     * Delete all selected User at once.
     *
     * @param Request $request
     */
    // public function massDestroy(Request $request)
    // {
    //     if (! Gate::allows('org_delete')) {
    //         return abort(401);
    //     }
    //     if ($request->input('ids')) {
    //         $entries = User::whereIn('id', $request->input('ids'))->get();
    //
    //         foreach ($entries as $entry) {
    //             $entry->delete();
    //         }
    //     }
    // }

}

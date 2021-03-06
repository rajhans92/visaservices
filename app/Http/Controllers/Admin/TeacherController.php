<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Teacher;
use App\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTeacherRequest;
use App\Http\Requests\Admin\UpdateTeacherRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Mail\verifyEmail;
use Hash;
use Auth;

class TeacherController extends Controller
{
    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('teacher_access')) {
            return abort(401);
        }

        $querUsers = DB::table('users')
            ->select('users.id AS id','first_name','last_name','email','phone_no','alt_phone_no','role_id','status.title AS status','teacher.dob AS dob','teacher.education AS education','teacher.specialties AS specialties','teacher.experience AS experience','teacher.organization_id AS organization_id')
            ->join('teacher', 'users.id', '=', 'teacher.user_id')
            ->join('status', 'users.status', '=', 'status.id')
            ->where('role_id','=',2);

        if(Auth::user()->role_id != 1 && Auth::user()->role_id != 4){
            $querUsers->where(function($query) {
              return $query->orWhere(['users.created_by' => Auth::user()->id, 'teacher.organization_id' => Auth::user()->id]);
            });
        }
        $users = $querUsers->get();

        $organization = DB::table('users')
                ->select('id','first_name','last_name')
                ->where('role_id','=',5)
                ->where('status','=',2)
                ->get();

        $orgObj = array('0' => 'Self');
        foreach ($organization as $key => $value) {
          $orgObj[$value->id] = $value->first_name.' '.$value->last_name;
        }
        // exit(print_r($orgObj));
        return view('admin.teacher.index', compact('users','orgObj'));
    }

    public function onlyView(){

      $users = DB::table('users')
          ->select('users.id AS id','first_name','last_name','email','phone_no','alt_phone_no','role_id','status.title AS status','teacher.dob AS dob','teacher.education AS education','teacher.specialties AS specialties','teacher.experience AS experience','teacher.organization_id AS organization_id')
          ->join('teacher', 'users.id', '=', 'teacher.user_id')
          ->join('status', 'users.status', '=', 'status.id')
          ->where('role_id','=',2)
          ->where('users.status','=',2)
          ->get();

      return view('admin.teacher.onlyView', compact('users'));
    }
    /**
     * Show the form for creating new User.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('teacher_create')) {
            return abort(401);
        }
        $orgObj = array('0' => 'Self');

        if(Auth::user()->role_id != 5){
          $organization = DB::table('users')
                  ->select('id','first_name','last_name')
                  ->where('role_id','=',5)
                  ->where('status','=',2)
                  ->get();
          foreach ($organization as $key => $value) {
            $orgObj[$value->id] = $value->first_name.' '.$value->last_name;
          }
        }else {
          $orgObj = array(Auth::user()->id => Auth::user()->first_name.' '.Auth::user()->last_name);
        }

        return view('admin.teacher.create', compact('orgObj'));
    }

    /**
     * Store a newly created User in storage.
     *
     * @param  \App\Http\Requests\StoreUsersRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTeacherRequest $request)
    {
        if (! Gate::allows('teacher_create')) {
            return abort(401);
        }
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
          }

          $bannername = '';
          if ($request->hasFile('banner')) {
              $images = $request->banner->getClientOriginalName();
              $images = time().'_'.$images; // Add current time before image name
              $request->banner->move(env('IMG_UPLOAD_PATH').'img/teacher/banner/',$images);
              $bannername = $images;
          }
          $token = Str::random(40);
          $user = DB::table('users')->insertGetId(
              ['first_name' => $request['first_name'],
               'last_name' => $request['last_name'],
               'email' => $request['email'],
               'phone_no' => $request['phone_no'],
               'alt_phone_no' => $request['alt_phone_no'],
               'password' => Hash::make($request['password']),
               'role_id' => 2,
               'status' => 1,
               'verify_token' => $token,
               'created_at' => date('Y-m-d'),
              'created_by' => Auth::user()->id
             ]
          );

          $roleTable = DB::table('role_user')->insertGetId([
            "role_id" => 2,
            "user_id" => $user
          ]);

          $admin = DB::table('teacher')->insertGetId(
              ['user_id' => $user,
               'dob' => date('Y-m-d',strtotime($request['dob'])),
               'specialties' => $request['specialties'],
               'overview' => $request['overview'],
               'profile_pic' => $filename,
               'banner' => $bannername,
               'website' => $request['website'],
               'education' => $request['education'],
               'experience' => $request['experience'],
               'organization_id' => $request['organization_id'],
               'address' => $request['address'],
             ]
          );
          $userData = [
            'name' => $request['first_name'].' '.$request['last_name'],
            'email' =>  $request['email'],
            'token' => $token
          ];
        $this->sendMail($userData);
        return redirect()->route('admin.teacher.index');
    }

    private function sendMail($userData){
        \Mail::to($userData['email'])->send(new verifyEmail($userData));
    }
    /**
     * Show the form for editing User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('teacher_edit')) {
            return abort(401);
        }
        $querUsers = DB::table('users')
            ->select('users.id AS id','first_name','last_name','email','phone_no','alt_phone_no','role_id','status.title AS status','teacher.profile_pic AS profile_pic','teacher.dob AS dob','teacher.banner AS banner','teacher.specialties AS specialties','teacher.overview AS overview','teacher.website AS website','teacher.experience AS experience','teacher.education AS education','teacher.address AS address','teacher.organization_id AS organization_id')
            ->join('teacher', 'users.id', '=', 'teacher.user_id')
            ->join('status', 'users.status', '=', 'status.id')
            ->where('users.role_id','=',2)
            ->where('users.id','=',$id);

        if(Auth::user()->role_id != 1 && Auth::user()->role_id != 4){
            $querUsers->where(function($query) {
              return $query->orWhere(['users.created_by' => Auth::user()->id, 'teacher.organization_id' => Auth::user()->id]);
            });
        }

        $user =  $querUsers->first();

        if(!isset($user->id)){
          return redirect()->route('admin.teacher.index')->with('error','unauthorized access!');
        }
$orgObj = array('0' => 'Self');
        if(Auth::user()->role_id != 5){
          $organization = DB::table('users')
                  ->select('id','first_name','last_name')
                  ->where('role_id','=',5)
                  ->where('status','=',2)
                  ->get();
          foreach ($organization as $key => $value) {
            $orgObj[$value->id] = $value->first_name.' '.$value->last_name;
          }
        }else {
          $orgObj = array(Auth::user()->id => Auth::user()->first_name.' '.Auth::user()->last_name);
        }

        return view('admin.teacher.edit', compact('user', 'orgObj'));
    }

    /**
     * Update User in storage.
     *
     * @param  \App\Http\Requests\UpdateUsersRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTeacherRequest $request, $id)
    {
        if (! Gate::allows('teacher_edit')) {
            return abort(401);
        }

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
         'email' => $request['email'],
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

        return redirect()->route('admin.teacher.index');
    }


    /**
     * Display User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('teacher_view')) {
            return abort(401);
        }
        $querUsers = DB::table('users')
            ->select('users.id AS id','first_name','last_name','email','phone_no','alt_phone_no','role_id','status.title AS status','teacher.profile_pic AS profile_pic','teacher.dob AS dob','teacher.banner AS banner','teacher.specialties AS specialties','teacher.overview AS overview','teacher.website AS website','teacher.experience AS experience','teacher.education AS education','teacher.address AS address','teacher.organization_id AS organization_id')
            ->join('teacher', 'users.id', '=', 'teacher.user_id')
            ->join('status', 'users.status', '=', 'status.id')
            ->where('users.role_id','=',2)
            ->where('users.id','=',$id);

        if(Auth::user()->role_id != 1 && Auth::user()->role_id != 4){
            $querUsers->where(function($query) {
              return $query->orWhere(['users.created_by' => Auth::user()->id, 'teacher.organization_id' => Auth::user()->id]);
            });
        }

        $user =  $querUsers->first();

        if(!isset($user->id)){
          return redirect()->route('admin.teacher.index')->with('error','unauthorized access!');
        }

        $organization = DB::table('users')
                ->select('id','first_name','last_name')
                ->where('role_id','=',5)
                ->where('status','=',2)
                ->get();

        $orgObj = array('0' => 'Self');
        foreach ($organization as $key => $value) {
          $orgObj[$value->id] = $value->first_name.' '.$value->last_name;
        }
        return view('admin.teacher.show', compact('user', 'orgObj'));
    }


    /**
     * Remove User from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('teacher_delete')) {
            return abort(401);
        }

        $user = DB::table('teacher')
            ->select('profile_pic','banner')
            ->where('user_id','=',$id)
            ->first();

        $oldImagePath = env('IMG_UPLOAD_PATH').'img/teacher/profile/'.$user->profile_pic;
        if (file_exists($oldImagePath)) {
            @unlink($oldImagePath);
        }
        $oldImagePath = env('IMG_UPLOAD_PATH').'img/teacher/banner/'.$user->banner;
        if (file_exists($oldImagePath)) {
            @unlink($oldImagePath);
        }

        DB::table('users')->where('id', $id)->delete();
        DB::table('teacher')->where('user_id', $id)->delete();

        return redirect()->route('admin.teacher.index');
    }


    public function updateStatus(Request $request){
      if (! Gate::allows('teacher_edit')) {
          return abort(401);
      }
      // exit(print_r($request->all()));
      DB::table('users')->where('id', $request->userId)->limit(1)
      ->update(array('status' => $request->status,
       'updated_at' => date('Y-m-d'),
      'updated_by' => Auth::user()->id));

      return redirect()->route('admin.teacher.index');
    }

    public function getTeacherList($org_id){
      $teacher = array();
      if(Auth::user()->role_id != 2){
        $teacherQuery = DB::table("users")->select("users.id AS id","first_name","last_name")->join("teacher","teacher.user_id","=","users.id")->where("role_id","=",2)->where('status',"=","2");

        if($org_id != "" && $org_id != 0){
          $teacherQuery->where("teacher.organization_id","=",$org_id);
        }
        $teacher = $teacherQuery->get();
      }else{
        $teacher = array("id"=> Auth::user()->id,"first_name" => Auth::user()->first_name,"last_name" => Auth::user()->last_name);
      }

        return json_encode($teacher);
    }
    /**
     * Delete all selected User at once.
     *
     * @param Request $request
     */
    // public function massDestroy(Request $request)
    // {
    //     if (! Gate::allows('teacher_delete')) {
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

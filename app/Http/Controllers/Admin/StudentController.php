<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Student;
use App\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreStudentRequest;
use App\Http\Requests\Admin\UpdateStudentRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Mail\verifyEmail;
use Hash;
use Auth;

class StudentController extends Controller
{
    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('student_access')) {
            return abort(401);
        }

        $querUsers = DB::table('users')
            ->select('users.id AS id','first_name','last_name','email','phone_no','alt_phone_no','role_id','status.title AS status','students.dob AS dob','students.education AS education','students.teacher_id AS teacher_id','students.organization_id AS organization_id')
            ->join('students', 'users.id', '=', 'students.user_id')
            ->join('status', 'users.status', '=', 'status.id')
            ->where('role_id','=',3);

        if(Auth::user()->role_id != 1 && Auth::user()->role_id != 4){
            $querUsers->where(function($query) {
              return $query->orWhere(['users.created_by' => Auth::user()->id, 'students.organization_id' => Auth::user()->id,'students.teacher_id'=>Auth::user()->id]);
            });
        }
        $users = $querUsers->get();

        $organization = DB::table('users')
                ->select('id','first_name','last_name')
                ->where('role_id','=',5)
                ->where('status','=',2)
                ->get();

        $orgObj = array('0' => 'NA');
        foreach ($organization as $key => $value) {
          $orgObj[$value->id] = $value->first_name.' '.$value->last_name;
        }

        $teacher = DB::table('users')
                ->select('id','first_name','last_name')
                ->where('role_id','=',2)
                ->where('status','=',2)
                ->get();

        $teacherObj = array('0' => 'NA');
        foreach ($teacher as $key => $value) {
          $teacherObj[$value->id] = $value->first_name.' '.$value->last_name;
        }

        return view('admin.student.index', compact('users','orgObj','teacherObj'));
    }

    /**
     * Show the form for creating new User.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('student_create')) {
            return abort(401);
        }
        if(Auth::user()->role_id != 5){
          $organization = DB::table('users')
                  ->select('id','first_name','last_name')
                  ->where('role_id','=',5)
                  ->where('status','=',2)
                  ->get();
          $orgObj = array('0' => 'NA');
          foreach ($organization as $key => $value) {
            $orgObj[$value->id] = $value->first_name.' '.$value->last_name;
          }
        }else {
          $orgObj = array(Auth::user()->id => Auth::user()->first_name.' '.Auth::user()->last_name);
        }
        if(Auth::user()->role_id == 5){
          $teacher = DB::table('users')
                  ->select('users.id AS id','users.first_name As first_name','users.last_name As last_name')
                  ->join('teacher','teacher.user_id',"=","users.id")
                  ->where('users.role_id','=',2)
                  ->where('users.status','=',2)
                  ->where('teacher.organization_id',"=",Auth::user()->id)
                  ->get();

          $teacherObj = array('0' => 'NA');
          foreach ($teacher as $key => $value) {
            $teacherObj[$value->id] = $value->first_name.' '.$value->last_name;
          }
        }elseif (Auth::user()->role_id == 2) {
          $teacherObj = array(Auth::user()->id => Auth::user()->first_name.' '.Auth::user()->last_name);
          $organization = DB::table('users')
                  ->select('users.id AS id','users.first_name As first_name','users.last_name As last_name')
                  ->join('teacher','teacher.organization_id',"=","users.id")
                  ->where('users.status','=',2)
                  ->where('teacher.user_id',"=",Auth::user()->id)
                  ->first();
          $orgObj = array('0' => 'NA');
          if(isset($organization->id)){
            $orgObj = array($organization->id => $organization->first_name.' '.$organization->last_name);
          }
        }else{
          $teacher = DB::table('users')
                  ->select('id','first_name','last_name')
                  ->where('role_id','=',2)
                  ->where('status','=',2)
                  ->get();

          $teacherObj = array('0' => 'NA');
          foreach ($teacher as $key => $value) {
            $teacherObj[$value->id] = $value->first_name.' '.$value->last_name;
          }
        }

        return view('admin.student.create', compact('orgObj', 'teacherObj'));
    }

    /**
     * Store a newly created User in storage.
     *
     * @param  \App\Http\Requests\StoreUsersRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStudentRequest $request)
    {
        if (! Gate::allows('student_create')) {
            return abort(401);
        }
        $errors = [];
        if(isset($request['alt_phone_no']) && $request['alt_phone_no'] == $request['phone_no']){
          $errors['alt_phone_no'] = 'Alternate No should be different from Phone No';
        }

        if(isset($request['about']) && preg_replace('/\s+/','',str_replace('&nbsp;','',trim(strip_tags($request['about'])))) == ""){
          $errors['about'] = 'The about field is required.';
        }
        if(count($errors)){
          return back()->withInput($request->input())->withErrors(new \Illuminate\Support\MessageBag($errors));
        }

        $filename = '';
        if ($request->hasFile('profile_pic')) {
            $images = $request->profile_pic->getClientOriginalName();
            $images = time().'_'.$images; // Add current time before image name
            $request->profile_pic->move(env('IMG_UPLOAD_PATH').'img/student/profile/',$images);
            $filename = $images;
        }
        $token = Str::random(40);
        $user = DB::table('users')->insertGetId(
            ['first_name' => $request['first_name'],
             'last_name' => $request['last_name'],
             'email' => $request['email'],
             'phone_no' => $request['phone_no'],
             'alt_phone_no' => $request['alt_phone_no'],
             'password' => Hash::make($request['password']),
             'role_id' => 3,
             'status' => 1,
             'verify_token' => $token,
             'created_at' => date('Y-m-d'),
            'created_by' => Auth::user()->id
           ]
        );
        $roleTable = DB::table('role_user')->insertGetId([
          "role_id" => 3,
          "user_id" => $user
        ]);
        $admin = DB::table('students')->insertGetId(
            ['user_id' => $user,
             'dob' => date('Y-m-d',strtotime($request['dob'])),
             'about' => $request['about'],
             'profile_pic' => $filename,
             'education' => $request['education'],
             'teacher_id' => $request['teacher_id'],
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

        return redirect()->route('admin.student.index');
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
        if (! Gate::allows('student_edit')) {
            return abort(401);
        }

        $querUsers = DB::table('users')
            ->select('users.id AS id','first_name','last_name','email','phone_no','alt_phone_no','role_id','status.title AS status','students.profile_pic AS profile_pic','students.dob AS dob','students.about AS about','students.teacher_id AS teacher_id','students.education AS education','students.address AS address','students.organization_id AS organization_id')
            ->join('students', 'users.id', '=', 'students.user_id')
            ->join('status', 'users.status', '=', 'status.id')
            ->where('users.role_id','=',3)
            ->where('users.id','=',$id);

        if(Auth::user()->role_id != 1 && Auth::user()->role_id != 4){
            $querUsers->where(function($query) {
              return $query->orWhere(['users.created_by' => Auth::user()->id, 'students.organization_id' => Auth::user()->id,'students.teacher_id'=>Auth::user()->id]);
            });
        }

        $user =  $querUsers->first();

        if(!isset($user->id)){
          return redirect()->route('admin.student.index')->with('error','unauthorized access!');
        }

        if(Auth::user()->role_id != 5){
          $organization = DB::table('users')
                  ->select('id','first_name','last_name')
                  ->where('role_id','=',5)
                  ->where('status','=',2)
                  ->get();
          $orgObj = array('0' => 'NA');
          foreach ($organization as $key => $value) {
            $orgObj[$value->id] = $value->first_name.' '.$value->last_name;
          }
        }else {
          $orgObj = array(Auth::user()->id => Auth::user()->first_name.' '.Auth::user()->last_name);
        }
        if(Auth::user()->role_id == 5){
          $teacher = DB::table('users')
                  ->select('users.id AS id','users.first_name As first_name','users.last_name As last_name')
                  ->join('teacher','teacher.user_id',"=","users.id")
                  ->where('users.role_id','=',2)
                  ->where('users.status','=',2)
                  ->where('teacher.organization_id',"=",Auth::user()->id)
                  ->get();

          $teacherObj = array('0' => 'NA');
          foreach ($teacher as $key => $value) {
            $teacherObj[$value->id] = $value->first_name.' '.$value->last_name;
          }
        }elseif (Auth::user()->role_id == 2) {
          $teacherObj = array(Auth::user()->id => Auth::user()->first_name.' '.Auth::user()->last_name);
          $organization = DB::table('users')
                  ->select('users.id AS id','users.first_name As first_name','users.last_name As last_name')
                  ->join('teacher','teacher.organization_id',"=","users.id")
                  ->where('users.status','=',2)
                  ->where('teacher.user_id',"=",Auth::user()->id)
                  ->first();
          $orgObj = array('0' => 'NA');
          if(isset($organization->id)){
            $orgObj = array($organization->id => $organization->first_name.' '.$organization->last_name);
          }
        }else{
          $teacher = DB::table('users')
                  ->select('id','first_name','last_name')
                  ->where('role_id','=',2)
                  ->where('status','=',2)
                  ->get();

          $teacherObj = array('0' => 'NA');
          foreach ($teacher as $key => $value) {
            $teacherObj[$value->id] = $value->first_name.' '.$value->last_name;
          }
        }

        return view('admin.student.edit', compact('user', 'teacherObj', 'orgObj'));
    }

    /**
     * Update User in storage.
     *
     * @param  \App\Http\Requests\UpdateUsersRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStudentRequest $request, $id)
    {
        if (! Gate::allows('student_edit')) {
            return abort(401);
        }

        $errors = [];
        if(isset($request['alt_phone_no']) && $request['alt_phone_no'] == $request['phone_no']){
          $errors['alt_phone_no'] = 'Alternate No should be different from Phone No';
        }

        if(isset($request['about']) && preg_replace('/\s+/','',str_replace('&nbsp;','',trim(strip_tags($request['about'])))) == ""){
          $errors['about'] = 'The about field is required.';
        }
        if(count($errors)){
          return back()->withInput($request->input())->withErrors(new \Illuminate\Support\MessageBag($errors));
        }

        $filename = '';
        if ($request->hasFile('profile_pic')) {
          $images = $request->profile_pic->getClientOriginalName();
          $images = time().'_'.$images; // Add current time before image name
          $request->profile_pic->move(env('IMG_UPLOAD_PATH').'img/student/profile/',$images);
          $filename = $images;

          $user = DB::table('students')
          ->select('profile_pic')
          ->where('user_id','=',$id)
          ->first();
          $oldImagePath = env('IMG_UPLOAD_PATH').'img/student/profile/'.$user->profile_pic;
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

        $studentData = array(
          'dob' => date('Y-m-d',strtotime($request['dob'])),
          'about' => $request['about'],
          'education' => $request['education'],
          'teacher_id' => $request['teacher_id'],
          'organization_id' => $request['organization_id'],
          'address' => $request['address'],
          );

          if($filename != ""){
            $studentData['profile_pic'] = $filename;
          }
          DB::table('students')->where('user_id', $id)->limit(1)
          ->update($studentData);


        return redirect()->route('admin.student.index');
    }


    /**
     * Display User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('student_view')) {
            return abort(401);
        }
        $querUsers = DB::table('users')
            ->select('users.id AS id','first_name','last_name','email','phone_no','alt_phone_no','role_id','status.title AS status','students.profile_pic AS profile_pic','students.dob AS dob','students.about AS about','students.teacher_id AS teacher_id','students.education AS education','students.address AS address','students.organization_id AS organization_id')
            ->join('students', 'users.id', '=', 'students.user_id')
            ->join('status', 'users.status', '=', 'status.id')
            ->where('users.role_id','=',3)
            ->where('users.id','=',$id);


            if(Auth::user()->role_id != 1 && Auth::user()->role_id != 4){
                $querUsers->where(function($query) {
                  return $query->orWhere(['users.created_by' => Auth::user()->id, 'students.organization_id' => Auth::user()->id,'students.teacher_id'=>Auth::user()->id]);
                });
            }

            $user =  $querUsers->first();
            if(!isset($user->id)){
              return redirect()->route('admin.student.index')->with('error','unauthorized access!');
            }

        $organization = DB::table('users')
                ->select('id','first_name','last_name')
                ->where('role_id','=',5)
                ->where('status','=',2)
                ->get();

        $orgObj = array('0' => 'NA');
        foreach ($organization as $key => $value) {
          $orgObj[$value->id] = $value->first_name.' '.$value->last_name;
        }

        $teacher = DB::table('users')
                ->select('id','first_name','last_name')
                ->where('role_id','=',2)
                ->where('status','=',2)
                ->get();

        $teacherObj = array('0' => 'NA');
        foreach ($teacher as $key => $value) {
          $teacherObj[$value->id] = $value->first_name.' '.$value->last_name;
        }

        return view('admin.student.show', compact('user', 'orgObj', 'teacherObj'));
    }


    /**
     * Remove User from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('student_delete')) {
            return abort(401);
        }

        $user = DB::table('students')
            ->select('profile_pic')
            ->where('user_id','=',$id)
            ->first();

        $oldImagePath = env('IMG_UPLOAD_PATH').'img/teacher/profile/'.$user->profile_pic;
        if (file_exists($oldImagePath)) {
            @unlink($oldImagePath);
        }

        DB::table('users')->where('id', $id)->delete();
        DB::table('students')->where('user_id', $id)->delete();

        return redirect()->route('admin.student.index');
    }

    public function updateStatus(Request $request){
      if (! Gate::allows('student_edit')) {
          return abort(401);
      }
      // exit(print_r($request->all()));
      DB::table('users')->where('id', $request->userId)->limit(1)
      ->update(array('status' => $request->status,
       'updated_at' => date('Y-m-d'),
      'updated_by' => Auth::user()->id));

      return redirect()->route('admin.student.index');
    }
    /**
     * Delete all selected User at once.
     *
     * @param Request $request
     */
    // public function massDestroy(Request $request)
    // {
    //     if (! Gate::allows('student_delete')) {
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

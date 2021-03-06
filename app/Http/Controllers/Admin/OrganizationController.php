<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Organization;
use App\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreOrganizationRequest;
use App\Http\Requests\Admin\UpdateOrganizationRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Mail\verifyEmail;
use Hash;
use Auth;

class OrganizationController extends Controller
{
    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('org_access')) {
            return abort(401);
        }


        $users = DB::table('users')
            ->select('users.id AS id','first_name','last_name','email','phone_no','alt_phone_no','role_id','status.title AS status','organization.established_date AS established_date')
            ->join('organization', 'users.id', '=', 'organization.user_id')
            ->join('status', 'users.status', '=', 'status.id')
            ->where('role_id','=',5)
            ->get();


        return view('admin.org.index', compact('users'));
    }

    public function onlyView(){

      $users = DB::table('users')
          ->select('users.id AS id','first_name','last_name','email','phone_no','alt_phone_no','role_id','status.title AS status','organization.established_date AS established_date')
          ->join('organization', 'users.id', '=', 'organization.user_id')
          ->join('status', 'users.status', '=', 'status.id')
          ->where('role_id','=',5)
          ->where('users.status','=',2)
          ->get();


      return view('admin.org.onlyView', compact('users'));
    }
    /**
     * Show the form for creating new User.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('org_create')) {
            return abort(401);
        }
        return view('admin.org.create');
    }

    /**
     * Store a newly created User in storage.
     *
     * @param  \App\Http\Requests\StoreUsersRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrganizationRequest $request)
    {
        if (! Gate::allows('org_create')) {
            return abort(401);
        }
        $errors = [];
        if(isset($request['alt_phone_no']) && $request['alt_phone_no'] == $request['phone_no']){
          $errors['alt_phone_no'] = 'Alternate No should be different from Phone No';
        }
        if(isset($request['address']) && preg_replace('/\s+/','',str_replace('&nbsp;','',trim(strip_tags($request['address'])))) == ""){
          $errors['address'] = 'The address field is required.';
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
        }

        $bannername = '';
        if ($request->hasFile('banner')) {
            $images = $request->banner->getClientOriginalName();
            $images = time().'_'.$images; // Add current time before image name
            $request->banner->move(env('IMG_UPLOAD_PATH').'img/org/banner/',$images);
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
             'role_id' => 5,
             'status' => 1,
             'verify_token' => $token,
             'created_at' => date('Y-m-d'),
            'created_by' => Auth::user()->id
           ]
        );

        $roleTable = DB::table('role_user')->insertGetId([
          "role_id" => 5,
          "user_id" => $user
        ]);

        $admin = DB::table('organization')->insertGetId(
            ['user_id' => $user,
             'established_date' => date('Y-m-d',strtotime($request['established_date'])),
             'specialties' => $request['specialties'],
             'overview' => $request['overview'],
             'profile_pic' => $filename,
             'banner' => $bannername,
             'website' => $request['website'],
             'teacher_strength' => $request['teacher_strength'],
             'student_strength' => $request['student_strength'],
             'address' => $request['address'],
           ]
        );
        $userData = [
          'name' => $request['first_name'].' '.$request['last_name'],
          'email' =>  $request['email'],
          'token' => $token
        ];
        $this->sendMail($userData);
        return redirect()->route('admin.org.index');
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
        if (! Gate::allows('org_edit')) {
            return abort(401);
        }
        $user = DB::table('users')
            ->select('users.id AS id','first_name','last_name','email','phone_no','alt_phone_no','role_id','status.title AS status','organization.established_date AS established_date','organization.profile_pic AS profile_pic','organization.banner AS banner','organization.specialties AS specialties','organization.overview AS overview','organization.website AS website','organization.teacher_strength AS teacher_strength','organization.student_strength AS student_strength','organization.address AS address')
            ->join('organization', 'users.id', '=', 'organization.user_id')
            ->join('status', 'users.status', '=', 'status.id')
            ->where('role_id','=',5)
            ->where('users.id','=',$id)
            ->first();

        return view('admin.org.edit', compact('user'));
    }

    /**
     * Update User in storage.
     *
     * @param  \App\Http\Requests\UpdateUsersRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrganizationRequest $request, $id)
    {
        if (! Gate::allows('org_edit')) {
            return abort(401);
        }
        $errors = [];
        if(isset($request['alt_phone_no']) && $request['alt_phone_no'] == $request['phone_no']){
          $errors['alt_phone_no'] = 'Alternate No should be different from Phone No';
        }
        if(isset($request['address']) && preg_replace('/\s+/','',str_replace('&nbsp;','',trim(strip_tags($request['address'])))) == ""){
          $errors['address'] = 'The address field is required.';
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
         'email' => $request['email'],
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

        return redirect()->route('admin.org.index');
    }


    /**
     * Display User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('org_view')) {
            return abort(401);
        }
        $user = DB::table('users')
            ->select('users.id AS id','first_name','last_name','email','phone_no','alt_phone_no','role_id','status.title AS status','organization.profile_pic AS profile_pic','organization.established_date AS established_date','organization.banner AS banner','organization.specialties AS specialties','organization.overview AS overview','organization.website AS website','organization.teacher_strength AS teacher_strength','organization.student_strength AS student_strength','organization.address AS address')
            ->join('organization', 'users.id', '=', 'organization.user_id')
            ->join('status', 'users.status', '=', 'status.id')
            ->where('users.role_id','=',5)
            ->where('users.id','=',$id)
            ->first();

        return view('admin.org.show', compact('user'));
    }


    /**
     * Remove User from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('org_delete')) {
            return abort(401);
        }

        $user = DB::table('organization')
            ->select('profile_pic','banner')
            ->where('user_id','=',$id)
            ->first();

        $oldImagePath = env('IMG_UPLOAD_PATH').'img/org/profile/'.$user->profile_pic;
        if (file_exists($oldImagePath)) {
            @unlink($oldImagePath);
        }
        $oldImagePath = env('IMG_UPLOAD_PATH').'img/org/banner/'.$user->banner;
        if (file_exists($oldImagePath)) {
            @unlink($oldImagePath);
        }

        DB::table('users')->where('id', $id)->delete();
        DB::table('organization')->where('user_id', $id)->delete();

        return redirect()->route('admin.org.index');
    }

    public function updateStatus(Request $request){
      if (! Gate::allows('org_edit')) {
          return abort(401);
      }
      // exit(print_r($request->all()));
      DB::table('users')->where('id', $request->userId)->limit(1)
      ->update(array('status' => $request->status,
       'updated_at' => date('Y-m-d'),
      'updated_by' => Auth::user()->id));

      return redirect()->route('admin.org.index');
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

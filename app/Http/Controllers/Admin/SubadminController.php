<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Subadmin;
use App\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSubadminRequest;
use App\Http\Requests\Admin\UpdateSubadminRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Mail\verifyEmail;
use Hash;
use Auth;

class SubadminController extends Controller
{
    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('subadmin_access')) {
            return abort(401);
        }
        // $users = User::all();
        $users = DB::table('users')
            ->select('users.id AS id','first_name','last_name','email','phone_no','alt_phone_no','role_id','status.title AS status','subadmin.post AS post')
            ->join('subadmin', 'users.id', '=', 'subadmin.user_id')
            ->join('status', 'users.status', '=', 'status.id')
            ->where('role_id','=',4)
            ->get();

        // exit(print_r($userss));
        return view('admin.subadmin.index', compact('users'));
    }

    /**
     * Show the form for creating new User.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('subadmin_create')) {
            return abort(401);
        }

        return view('admin.subadmin.create');
    }

    /**
     * Store a newly created User in storage.
     *
     * @param  \App\Http\Requests\StoreUsersRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSubadminRequest $request)
    {
        if (! Gate::allows('subadmin_create')) {
            return abort(401);
        }
        $errors = [];
        if(isset($request['alt_phone_no']) && $request['alt_phone_no'] == $request['phone_no']){
          $errors['alt_phone_no'] = 'Alternate No should be different from Phone No';
        }

        if(isset($request['detail']) && preg_replace('/\s+/','',str_replace('&nbsp;','',trim(strip_tags($request['detail'])))) == ""){
          $errors['detail'] = 'The detail field is required.';
        }
        $filename = '';
        if ($request->hasFile('profile_pic')) {
            $images = $request->profile_pic->getClientOriginalName();
            $images = time().'_'.$images; // Add current time before image name
            $request->profile_pic->move(env('IMG_UPLOAD_PATH').'img/subadmin/profile/',$images);
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
             'role_id' => 4,
             'status' => 1,
             'verify_token' => $token,
             'created_at' => date('Y-m-d'),
            'created_by' => Auth::user()->id
           ]
        );
        $roleTable = DB::table('role_user')->insertGetId([
          "role_id" => 4,
          "user_id" => $user
        ]);
        $admin = DB::table('subadmin')->insertGetId(
            ['user_id' => $user,
             'dob' => date('Y-m-d',strtotime($request['dob'])),
             'post' => $request['post'],
             'detail' => $request['detail'],
             'profile_pic' => $filename
           ]
        );
        // exit(print_r($admin));
        $userData = [
          'name' => $request['first_name'].' '.$request['last_name'],
          'email' =>  $request['email'],
          'token' => $token
        ];
        $this->sendMail($userData);
        return redirect()->route('admin.subadmin.index');
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
        if (! Gate::allows('subadmin_edit')) {
            return abort(401);
        }

        $user = DB::table('users')
            ->select('users.id AS id','first_name','last_name','email','phone_no','alt_phone_no','role_id','status.title AS status','subadmin.post AS post','subadmin.profile_pic AS profile_pic','subadmin.post AS post','subadmin.dob AS dob','subadmin.detail AS detail')
            ->join('subadmin', 'users.id', '=', 'subadmin.user_id')
            ->join('status', 'users.status', '=', 'status.id')
            ->where('users.role_id','=',4)
            ->where('users.id','=',$id)
            ->first();

        return view('admin.subadmin.edit', compact('user'));
    }

    /**
     * Update User in storage.
     *
     * @param  \App\Http\Requests\UpdateUsersRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSubadminRequest $request, $id)
    {
        if (! Gate::allows('subadmin_edit')) {
            return abort(401);
        }
        $errors = [];
        if(isset($request['alt_phone_no']) && $request['alt_phone_no'] == $request['phone_no']){
          $errors['alt_phone_no'] = 'Alternate No should be different from Phone No';
        }

        if(isset($request['detail']) && preg_replace('/\s+/','',str_replace('&nbsp;','',trim(strip_tags($request['detail'])))) == ""){
          $errors['detail'] = 'The detail field is required.';
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
         'email' => $request['email'],
         'phone_no' => $request['phone_no'],
         'alt_phone_no' => $request['alt_phone_no'],
         'updated_at' => date('Y-m-d'),
        'updated_by' => Auth::user()->id));

        $subadminData = array(
             'dob' => date('Y-m-d',strtotime($request['dob'])),
             'post' => $request['post'],
             'detail' => $request['detail'],
           );

        if($filename != ""){
          $subadminData['profile_pic'] = $filename;
        }
        DB::table('subadmin')->where('user_id', $id)->limit(1)
        ->update($subadminData);

        return redirect()->route('admin.subadmin.index');
    }


    /**
     * Display User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('subadmin_view')) {
            return abort(401);
        }
        // $user = User::findOrFail($id);
        $user = DB::table('users')
            ->select('users.id AS id','first_name','last_name','email','phone_no','alt_phone_no','role_id','status.title AS status','subadmin.post AS post','subadmin.profile_pic AS profile_pic','subadmin.post AS post','subadmin.dob AS dob','subadmin.detail AS detail')
            ->join('subadmin', 'users.id', '=', 'subadmin.user_id')
            ->join('status', 'users.status', '=', 'status.id')
            ->where('users.role_id','=',4)
            ->where('users.id','=',$id)
            ->first();
            // exit(print_r($user));
        return view('admin.subadmin.show', compact('user'));
    }


    /**
     * Remove User from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('subadmin_delete')) {
            return abort(401);
        }
        $user = DB::table('subadmin')
            ->select('profile_pic')
            ->where('user_id','=',$id)
            ->first();
       $oldImagePath = env('IMG_UPLOAD_PATH').'img/subadmin/profile/'.$user->profile_pic;
        if (file_exists($oldImagePath)) {
            @unlink($oldImagePath);
        }
        DB::table('users')->where('id', $id)->delete();
        DB::table('subadmin')->where('user_id', $id)->delete();

        return redirect()->route('admin.subadmin.index');
    }

    public function updateStatus(Request $request){
      if (! Gate::allows('subadmin_edit')) {
          return abort(401);
      }
      // exit(print_r($request->all()));
      DB::table('users')->where('id', $request->userId)->limit(1)
      ->update(array('status' => $request->status,
       'updated_at' => date('Y-m-d'),
      'updated_by' => Auth::user()->id));

      return redirect()->route('admin.subadmin.index');
    }
    /**
     * Delete all selected User at once.
     *
     * @param Request $request
     */
    // public function massDestroy(Request $request)
    // {
    //     if (! Gate::allows('subadmin_delete')) {
    //         return abort(401);
    //     }
    //     // if ($request->input('ids')) {
    //     //     $entries = User::whereIn('id', $request->input('ids'))->get();
    //     //
    //     //     foreach ($entries as $entry) {
    //     //         $entry->delete();
    //     //     }
    //     // }
    // }

}

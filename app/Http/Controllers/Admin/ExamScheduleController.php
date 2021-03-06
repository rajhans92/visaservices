<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreExamScheduleRequest;
use App\Http\Requests\Admin\UpdateExamScheduleRequest;
use Illuminate\Support\Facades\DB;
use Hash;
use Auth;

class ExamScheduleController extends Controller
{
    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('exam_schedule_access')) {
            return abort(401);
        }


        $exam_schedule = DB::table('exam_schedule')
                      ->select(
                        'exam_schedule.id AS id',
                        'exam_schedule.exam_display_name AS exam_display_name',
                        'exam_schedule.start_date AS start_date',
                        'exam_schedule.end_date As end_date',
                        'exam_schedule.result_date AS result_date',
                        'exam_schedule.user_limit AS user_limit',
                        'users.first_name AS first_name',
                        'users.last_name AS last_name',
                        'exam.exam_name AS exam_name',
                        'status.title AS status'
                        )
                      ->join('exam', 'exam.id', '=', 'exam_schedule.exam_id')
                      ->join('users', 'users.id', '=', 'exam_schedule.sponsored_by')
                      ->join('status', 'exam_schedule.status', '=', 'status.id')
                      ->get();

        return view('admin.exam-schedule.index', compact('exam_schedule'));
    }

    /**
     * Show the form for creating new User.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('exam_schedule_create')) {
            return abort(401);
        }
        $sponsor = DB::table('users')
                ->select('id','first_name','last_name')
                ->where('status','=',2)
                ->whereIn('role_id',[2,5])
                ->get();
        // exit(print_r($sponsor));
        $sponsorObj = array();
        foreach ($sponsor as $key => $value) {
          $sponsorObj[$value->id] = $value->first_name. ' ' .$value->last_name;
        }

        $exam = DB::table('exam')
                ->select('id','exam_name')
                ->where('exam_status','=',2)
                ->where('is_schedule','=',0)
                ->get();

        $examObj = array();
        foreach ($exam as $key => $value) {
          $examObj[$value->id] = $value->exam_name;
        }

        return view('admin.exam-schedule.create', compact('examObj','sponsorObj'));
    }

    /**
     * Store a newly created User in storage.
     *
     * @param  \App\Http\Requests\StoreUsersRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreExamScheduleRequest $request)
    {
        if (! Gate::allows('exam_schedule_create')) {
            return abort(401);
        }
        $errors = [];
        if(isset($request['exam_detail']) && preg_replace('/\s+/','',str_replace('&nbsp;','',trim(strip_tags($request['exam_detail'])))) == ""){
          $errors['exam_detail'] = 'The exam detail is required.';
        }
        if(count($errors)){
          return back()->withInput($request->input())->withErrors(new \Illuminate\Support\MessageBag($errors));
        }
        $filename = '';
        if ($request->hasFile('exam_logo')) {
            $images = $request->exam_logo->getClientOriginalName();
            $images = time().'_'.$images; // Add current time before image name
            $filename = $images;
        }

        $bannername = '';
        if ($request->hasFile('exam_banner')) {
            $images = $request->exam_banner->getClientOriginalName();
            $images = time().'_'.$images; // Add current time before image name
            $bannername = $images;
        }

        $examUpdate = DB::table("exam")->where("id","=",$request['exam_id'])->update(["is_schedule"=>1]);

        $exam_schedule = DB::table('exam_schedule')->insertGetId(
                        [
                         'exam_id' => $request['exam_id'],
                         'exam_display_name' => $request['exam_display_name'],
                         'start_date' => date('Y-m-d H:i:s',strtotime($request['start_date'])),
                         'end_date' => date('Y-m-d H:i:s',strtotime($request['end_date'])),
                         'result_date' => date('Y-m-d H:i:s',strtotime($request['result_date'])),
                         'user_limit' => isset($request['user_limit']) ? $request['user_limit'] : 0,
                         'sponsored_by' => isset($request['sponsored_by']) ? $request['sponsored_by'] : 0,
                         'exam_logo' => $filename,
                         'exam_banner' => $bannername,
                         'no_of_winner' => isset($request['no_of_winner']) ? $request['no_of_winner'] : 0,
                         'prize_amount' => isset($request['prize_amount']) ? $request['prize_amount'] : 0,
                         'reminder' => isset($request['reminder']) ? $request['reminder'] : 0,
                         'exam_detail' => $request['exam_detail'],
                         'status' => 1,
                         'created_at' => date('Y-m-d'),
                         'created_by' => Auth::user()->id
                       ]
                    );
        if($filename != ""){
          $request->exam_logo->move(env('IMG_UPLOAD_PATH')."img/exam_schedule/".$exam_schedule."/logo/",$filename);
        }
        if($bannername != ""){
          $request->exam_banner->move(env('IMG_UPLOAD_PATH')."img/exam_schedule/".$exam_schedule."/banner/",$images);
        }
        $createtable = DB::select(DB::raw('CREATE TABLE exam_submit_papers_'.$exam_schedule.' LIKE exam_submit_papers'));
        $createusertable = DB::select(DB::raw('CREATE TABLE exam_registered_users_'.$exam_schedule.' LIKE exam_registered_users'));
        $practicetable = DB::select(DB::raw('CREATE TABLE practice_exam_'.$exam_schedule.' LIKE practice_exam'));
        return redirect()->route('admin.exam-schedule.index');
    }


    /**
     * Show the form for editing User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('exam_schedule_edit')) {
            return abort(401);
        }
        $exam_schedule = DB::table('exam_schedule')
            ->where('id','=',$id)
            ->first();

        $sponsor = DB::table('users')
                ->select('id','first_name','last_name')
                ->where('status','=',2)
                ->whereIn('role_id',[2,5])
                ->get();
        // exit(print_r($sponsor));
        $sponsorObj = array();
        foreach ($sponsor as $key => $value) {
          $sponsorObj[$value->id] = $value->first_name. ' ' .$value->last_name;
        }

        $exam = DB::table('exam')
                ->select('id','exam_name','is_schedule')
                ->where('exam_status','=',2)
                ->get();

        $examObj = array();
        foreach ($exam as $key => $value) {
          if($value->is_schedule == 0 || $exam_schedule->exam_id == $value->id)
            $examObj[$value->id] = $value->exam_name;
        }

        return view('admin.exam-schedule.edit', compact('examObj','sponsorObj','exam_schedule'));
    }

    /**
     * Update User in storage.
     *
     * @param  \App\Http\Requests\UpdateUsersRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateExamScheduleRequest $request, $id)
    {
        if (! Gate::allows('exam_schedule_edit')) {
            return abort(401);
        }
        $errors = [];
        if(isset($request['exam_detail']) && preg_replace('/\s+/','',str_replace('&nbsp;','',trim(strip_tags($request['exam_detail'])))) == ""){
          $errors['exam_detail'] = 'The exam detail is required.';
        }
        if(count($errors)){
          return back()->withInput($request->input())->withErrors(new \Illuminate\Support\MessageBag($errors));
        }
        $exam = DB::table('exam_schedule')
            ->select('exam_id','exam_logo','exam_banner')
            ->where('id','=',$id)
            ->first();

        if(isset($request['exam_logo_delete']) && $request['exam_logo_delete'] == 1){
          DB::table('exam_schedule')->where('id', $id)->limit(1)->update(['exam_logo'=>'']);
          $oldImagePath = env('IMG_UPLOAD_PATH').'img/exam_schedule/'.$id.'/logo/'.$exam->exam_logo;
           if (file_exists($oldImagePath)) {
               @unlink($oldImagePath);
           }
        }
        if(isset($request['exam_banner_delete']) && $request['exam_banner_delete'] == 1){
          DB::table('exam_schedule')->where('id', $id)->limit(1)->update(['exam_banner'=>'']);
          $oldImagePath = env('IMG_UPLOAD_PATH').'img/exam_schedule/'.$id.'/banner/'.$exam->exam_banner;
           if (file_exists($oldImagePath)) {
               @unlink($oldImagePath);
           }
        }

        $filename = '';
        if ($request->hasFile('exam_logo')) {
            $images = $request->exam_logo->getClientOriginalName();
            $images = time().'_'.$images; // Add current time before image name
            $request->exam_logo->move(env('IMG_UPLOAD_PATH').'img/exam_schedule/'.$id.'/logo/',$images);
            $filename = $images;

           $oldImagePath = env('IMG_UPLOAD_PATH').'img/exam_schedule/'.$id.'/logo/'.$exam->exam_logo;
            if (file_exists($oldImagePath)) {
                @unlink($oldImagePath);
            }
        }

        $banner = '';
        if ($request->hasFile('exam_banner')) {
            $images = $request->exam_banner->getClientOriginalName();
            $images = time().'_'.$images; // Add current time before image name
            $request->exam_banner->move(env('IMG_UPLOAD_PATH').'img/exam_schedule/'.$id.'/banner/',$images);
            $banner = $images;

           $oldImagePath = env('IMG_UPLOAD_PATH').'img/exam_schedule/'.$id.'/banner/'.$exam->exam_banner;
            if (file_exists($oldImagePath)) {
                @unlink($oldImagePath);
            }
        }

        if($exam->exam_id != $request['exam_id']){
          DB::table("exam")->where("id","=",$exam->exam_id)->update(['is_schedule' => 0]);
        }
        DB::table("exam")->where("id","=",$request['exam_id'])->update(['is_schedule' => 1]);

        $examdata = array(
              'exam_id' => $request['exam_id'],
              'exam_display_name' => $request['exam_display_name'],
              'start_date' => date('Y-m-d H:i:s',strtotime($request['start_date'])),
              'end_date' => date('Y-m-d H:i:s',strtotime($request['end_date'])),
              'result_date' => date('Y-m-d H:i:s',strtotime($request['result_date'])),
              'user_limit' => isset($request['user_limit']) ? $request['user_limit'] : 0,
              'sponsored_by' => isset($request['sponsored_by']) ? $request['sponsored_by'] : 0,
              'no_of_winner' => isset($request['no_of_winner']) ? $request['no_of_winner'] : 0,
              'prize_amount' => isset($request['prize_amount']) ? $request['prize_amount'] : 0,
              'reminder' => isset($request['reminder']) ? $request['reminder'] : 0,
              'exam_detail' => $request['exam_detail'],
              'updated_at' => date('Y-m-d'),
              'updated_by' => Auth::user()->id
           );

        if($filename != ""){
          $examdata['exam_logo'] = $filename;
        }
        if($banner != ""){
          $examdata['exam_banner'] = $banner;
        }
        DB::table('exam_schedule')->where('id', $id)->limit(1)
        ->update($examdata);

        return redirect()->route('admin.exam-schedule.index');
    }


    /**
     * Display User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('exam_schedule_view')) {
            return abort(401);
        }

        $exam_schedule = DB::table('exam_schedule')
                      ->select('exam_schedule.id AS id',
                      'exam_schedule.exam_display_name AS exam_display_name',
                      'exam_schedule.start_date AS start_date',
                      'exam_schedule.end_date As end_date',
                      'exam_schedule.result_date AS result_date',
                      'exam_schedule.user_limit AS user_limit',
                      'exam_schedule.no_of_winner AS no_of_winner',
                      'exam_schedule.prize_amount AS prize_amount',
                      'exam_schedule.reminder AS reminder',
                      'exam_schedule.exam_logo AS exam_logo',
                      'exam_schedule.exam_banner AS exam_banner',
                      'exam_schedule.exam_detail AS exam_detail',
                      'users.first_name AS first_name',
                      'users.last_name AS last_name',
                      'exam.exam_name AS exam_name',
                      'status.title AS status')
                      ->join('exam', 'exam.id', '=', 'exam_schedule.exam_id')
                      ->join('users', 'users.id', '=', 'exam_schedule.sponsored_by')
                      ->join('status', 'exam_schedule.status', '=', 'status.id')
                      ->where('exam_schedule.id','=',$id)
                      ->first();

        return view('admin.exam-schedule.show', compact('exam_schedule'));
    }


    /**
     * Remove User from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('exam_schedule_delete')) {
            return abort(401);
        }

        $exam_schedule = DB::table('exam_schedule')
            ->select('exam_logo','exam_banner',"exam_id")
            ->where('id','=',$id)
            ->first();

        $oldImagePath = env('IMG_UPLOAD_PATH').'img/exam_schedule/'.$id.'/logo/'.$exam_schedule->exam_logo;
        if (file_exists($oldImagePath)) {
            @unlink($oldImagePath);
        }

        $oldImagePath = env('IMG_UPLOAD_PATH').'img/exam_schedule/'.$id.'/banner/'.$exam_schedule->exam_banner;
        if (file_exists($oldImagePath)) {
            @unlink($oldImagePath);
        }

        $examUpdate = DB::table("exam")->where("id","=",$exam_schedule->exam_id)->update(["is_schedule"=>0]);

        DB::table('exam_schedule')->where('id', $id)->delete();
        $createtable = DB::select(DB::raw('DROP TABLE exam_submit_papers_'.$id));
        $practicetable = DB::select(DB::raw('DROP TABLE practice_exam_'.$id));
        $createusertable = DB::select(DB::raw('DROP TABLE exam_registered_users_'.$id));
        // $createwinnertable = DB::select(DB::raw('DROP TABLE winner_'.$id));

        return redirect()->route('admin.exam-schedule.index')->with("success","Scheduled exam deleted successfully.");
    }

    public function updateStatus(Request $request){
      if (! Gate::allows('exam_schedule_edit')) {
          return abort(401);
      }
      // exit(print_r($request->all()));
      DB::table('exam_schedule')->where('id', $request->exam_schedule_id)->limit(1)
      ->update(array('status' => $request->status,
       'updated_at' => date('Y-m-d'),
      'updated_by' => Auth::user()->id));

      return redirect()->route('admin.exam-schedule.index')->with("success","Scheduled exam status update successfully.");
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

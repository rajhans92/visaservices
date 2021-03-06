<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreExamRequest;
use App\Http\Requests\Admin\UpdateExamRequest;
use App\Http\Requests\Admin\StoreExamSectionRequest;
use App\Http\Requests\Admin\UpdateExamSectionRequest;
use Illuminate\Support\Facades\DB;
use Hash;
use Auth;
use Excel;

class ExamController extends Controller
{
    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('exam_access')) {
            return abort(401);
        }

        $user = DB::table('users')
                ->select('role_id')
                ->where('id','=',Auth::user()->id)
                ->first();

        $queryExam = DB::table('exam')
            ->select('exam.id AS id','exam_name','is_schedule','status.title AS exam_status','organization_id','teacher_id','exam.exam_category_id AS exam_category_id')
            ->join('status', 'exam.exam_status', '=', 'status.id');

        if($user->role_id != 1 && $user->role_id != 4){
            $queryExam->orWhere(['created_by' => Auth::user()->id, 'organization_id' => Auth::user()->id,'teacher_id'=>Auth::user()->id]);
        }

        $exams = $queryExam->get();
        // exit(print_r($exams));
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

        $exam_categoryData = DB::table('exam_category')
                        ->where('status','=',2)
                        ->get();

        $exam_category = array('0' => 'Other');
        foreach ($exam_categoryData as $key => $value) {
          $exam_category[$value->id] = $value->title;
        }
        foreach ($exams as $key => $value) {
          $value->examCompleteStatus = $this->checkExamStatus($value->id);
        }

        return view('admin.exam.index', compact('exams','orgObj', 'teacherObj','exam_category'));
    }

    /**
     * Show the form for creating new User.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('exam_create')) {
            return abort(401);
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

        $exam_categoryData = DB::table('exam_category')
                        ->where('status','=',2)
                        ->get();

        $exam_category = array('0' => 'Other');
        foreach ($exam_categoryData as $key => $value) {
          $exam_category[$value->id] = $value->title;
        }

        $question_type = DB::table('question_type')
                ->select('id','title')
                ->get();

        $questionType = array('0' => 'Both');
        foreach ($question_type as $key => $value) {
          $questionType[$value->id] = $value->title;
        }
        $languages = DB::table('languages')
                  ->select('id','title')
                  ->where("status","=",2)
                  ->get();

        $submitType = [0=>"Both",1=>"Text",2=>"Numeric"];

        return view('admin.exam.create',compact('orgObj', 'teacherObj', 'questionType','languages','exam_category','submitType'));
    }

    /**
     * Store a newly created User in storage.
     *
     * @param  \App\Http\Requests\StoreUsersRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreExamRequest $request)
    {
        if (! Gate::allows('exam_create')) {
            return abort(401);
        }
        // exit(print_r($request->all()));

        $filename = '';
        if ($request->hasFile('file_name')) {
            $images = $request->file_name->getClientOriginalName();
            $images = time().'_'.$images; // Add current time before image name
            $filename = $images;
        }

        $imgname = '';
        if ($request->hasFile('image_name')) {
            $images = $request->image_name->getClientOriginalName();
            $images = time().'_'.$images; // Add current time before image name
            $imgname = $images;
        }

        $exam_id = DB::table('exam')->insertGetId(
            [
             'exam_name' => $request['exam_name'],
             'exam_duration' => isset($request['exam_duration']) && $request['exam_duration']?$request['exam_duration']:0,
             'exam_category_id' => isset($request['exam_category_id'])?$request['exam_category_id']:0,
             'is_negative_marking' => isset($request['is_negative_marking'])?$request['is_negative_marking']:0,
             'negative_marking_no' => isset($request['negative_marking_no'])?$request['negative_marking_no']:0,
             'video_link' => isset($request['video_link'])?$request['video_link']:"",
             'passing_marks' => isset($request['passing_marks']) && $request['passing_marks'] != "" ? $request['passing_marks']:0,
             'total_marks' => isset($request['total_marks']) && $request['total_marks'] != ""?$request['total_marks']:0,
             'total_questions' => isset($request['total_questions']) && $request['total_questions'] != ""?$request['total_questions']:0,
             'organization_id' =>  isset($request['organization_id'])?$request['organization_id']:0,
             'teacher_id' =>  isset($request['teacher_id'])?$request['teacher_id']:0,
             'questions_type' => isset($request['questions_type'])?$request['questions_type']:0,
             'submit_type' => isset($request['submit_type'])?$request['submit_type']:0,
             'has_sections' =>  1,
             'file_name' => $filename,
             'exam_status'=>1,
             'image_name' => $imgname,
             'created_at' => date('Y-m-d'),
             'created_by' => Auth::user()->id
           ]
        );
        if(isset($request['language'])){
          $lang=[];
          $lang_instruction=[];
          $count = 0;
          foreach ($request['language'] as $key => $value) {
            $lang[$count]['language_id'] = $value;
            $lang[$count]['exam_id'] = $exam_id;
            $lang_instruction[$count]['language_id'] = $value;
            $lang_instruction[$count]['exam_id'] = $exam_id;
            $lang_instruction[$count]['exam_note'] = '';
            $count++;
          }
          $exam_languages = DB::table('exam_languages')->insert($lang);
          $exam_languages = DB::table('exam_instructions')->insert($lang_instruction);
        }
        if($filename != ""){
          $request->file_name->move(env('IMG_UPLOAD_PATH').'img/exam/'.$exam_id.'/',$filename);
        }
        if($imgname != ""){
          $request->image_name->move(env('IMG_UPLOAD_PATH').'img/exam/'.$exam_id.'/',$imgname);
        }

        return redirect('admin/exam/instructions/'.$exam_id);

    }



    public function edit($id)
    {
        if (! Gate::allows('exam_edit')) {
            return abort(401);
        }

        $queryExam = DB::table('exam')
            ->where('exam.id',"=",$id)
            ->where('is_schedule',"=","0");

        if(Auth::user()->role_id != 1 && Auth::user()->role_id != 4){
            $queryExam->where(function($query) {
              return $query->orWhere(['created_by' => Auth::user()->id, 'organization_id' => Auth::user()->id,'teacher_id'=>Auth::user()->id]);
            });
        }

        $exam = $queryExam->first();
        if (!isset($exam->id)) {
          return redirect()->route('admin.exam.index')->with('error','unauthorized access!');
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

        if($exam->organization_id != "" && $exam->organization_id != 0){
          $teacher = DB::table('users')
                  ->select("users.id AS id",'first_name','last_name')
                  ->join("teacher","teacher.user_id","=","users.id")
                  ->where("role_id","=",2)
                  ->where('status',"=",2)
                  ->where("teacher.organization_id","=",$exam->organization_id)
                  ->get();
        }else {
          $teacher = DB::table('users')
                  ->select('id','first_name','last_name')
                  ->where('role_id','=',2)
                  ->where('status','=',2)
                  ->get();
        }

        $teacherObj = array('0' => 'NA');
        foreach ($teacher as $key => $value) {
          $teacherObj[$value->id] = $value->first_name.' '.$value->last_name;
        }

        $exam_categoryData = DB::table('exam_category')
                        ->where('status','=',2)
                        ->get();

        $exam_category = array('0' => 'Other');
        foreach ($exam_categoryData as $key => $value) {
          $exam_category[$value->id] = $value->title;
        }
        $question_type = DB::table('question_type')
                ->select('id','title')
                ->get();

        $questionType = array('0' => 'Both');
        if($exam->questions_type != 0){
          foreach ($question_type as $key => $value) {
            if($exam->questions_type == $value->id)
              $questionType[$value->id] = $value->title;
          }
        }
        $submitType = array('0'=>"Both");
        if($exam->submit_type != 0){
            if($exam->submit_type == 1){
              $submitType[1] = 'Text';
            }else{
              $submitType[2] = 'Numeric';
            }
        }
        $languages = DB::table("languages")
                  ->select('id','title')
                  ->where("status","=",2)
                  ->get();

        $examLanguageObj = DB::table("exam_languages")
                  ->where("exam_id","=",$id)
                  ->get();
        $examLanguage=[];
        foreach ($examLanguageObj as $key => $value) {
          $examLanguage[] = $value->language_id;
        }
        return view('admin.exam.edit', compact('exam','orgObj','teacherObj','questionType','submitType','exam_category','languages','examLanguage'));
    }

    public function update(UpdateExamRequest $request)
    {
        if (! Gate::allows('exam_edit')) {
            return abort(401);
        }
        $id = isset($request->eaxm_id) ? $request->eaxm_id : 0;
        $query = DB::table('exam')
            ->where('exam.id',"=",$id)
            ->where('is_schedule',"=","0")
            ->first();
        if(!isset($query->id)){
          return redirect()->route('admin.exam.index')->with('error','unauthorized access!');
        }

        $exam_section = DB::table('exam_sections')
            ->where('exam_id',"=",$id)
            ->get();

        if(count($exam_section)){
            $total_marks = 0;
            $total_question = 0;
            $exam_duration = 0;
            $cutoff = 0;
            $errors = [];
            foreach ($exam_section as $key => $value) {
              $total_marks += $value->total_marks;
              $total_question += $value->total_questions;
              $exam_duration += $value->section_duration;
              $cutoff += $value->cutoff;
            }
            if($total_marks > $request['total_marks']){
              $errors['total_marks'] = "Total masks shouldn't less than sum of all section total marks.";
            }
            if($total_question > $request['total_questions']){
              $errors['total_questions'] = "Total questions shouldn't less than sum of all section total questions.";
            }
            if($exam_duration > $request['exam_duration']){
              $errors['exam_duration'] = "Exam duration shouldn't less than sum of all section section duration.";
            }
            if($cutoff > $request['passing_marks']){
              $errors['passing_marks'] = "Passing marks shouldn't less than sum of all section cutoff.";
            }
            if(count($errors)){
              return back()->withInput($request->input())->withErrors(new \Illuminate\Support\MessageBag($errors));
            }
        }
        $exam = DB::table('exam')
        ->where('id','=',$id)
        ->first();

        if(isset($request['image_delete']) && $request['image_delete'] == 1){
          DB::table('exam')->where('id', $id)->limit(1)->update(['image_name'=>'']);
          $oldImagePath = env('IMG_UPLOAD_PATH').'img/exam/'.$id.'/'.$exam->image_name;
          if (file_exists($oldImagePath)) {
            @unlink($oldImagePath);
          }
        }
        if(isset($request['file_delete']) && $request['file_delete'] == 1){
          DB::table('exam')->where('id', $id)->limit(1)->update(['file_name'=>'']);
          $oldImagePath = env('IMG_UPLOAD_PATH').'img/exam/'.$id.'/'.$exam->file_name;
          if (file_exists($oldImagePath)) {
            @unlink($oldImagePath);
          }
        }
        $filename = '';
        if ($request->hasFile('file_name')) {
            $images = $request->file_name->getClientOriginalName();
            $images = time().'_'.$images; // Add current time before image name
            $request->file_name->move(env('IMG_UPLOAD_PATH').'img/exam/'.$id.'/',$images);
            $filename = $images;

            $oldImagePath = env('IMG_UPLOAD_PATH').'img/exam/'.$id.'/'.$exam->file_name;
            if (file_exists($oldImagePath)) {
              @unlink($oldImagePath);
            }
        }

        $imagename = '';
        if ($request->hasFile('image_name')) {
            $images = $request->image_name->getClientOriginalName();
            $images = time().'_'.$images; // Add current time before image name
            $request->image_name->move(env('IMG_UPLOAD_PATH').'img/exam/'.$id.'/',$images);
            $imagename = $images;

            $oldImagePath = env('IMG_UPLOAD_PATH').'img/exam/'.$id.'/'.$exam->image_name;
            if (file_exists($oldImagePath)) {
              @unlink($oldImagePath);
            }
        }

        $data = [
          'exam_name' => $request['exam_name'],
          'exam_duration' => isset($request['exam_duration']) && $request['exam_duration'] != ""?$request['exam_duration']:0,
          'exam_category_id' => isset($request['exam_category_id'])?$request['exam_category_id']:0,
          'is_negative_marking' => isset($request['is_negative_marking'])?$request['is_negative_marking']:0,
          'negative_marking_no' => isset($request['negative_marking_no'])?$request['negative_marking_no']:0,
          'video_link' => isset($request['video_link'])?$request['video_link']:"",
          'passing_marks' => isset($request['passing_marks']) && $request['passing_marks'] != "" ? $request['passing_marks']:0,
          'total_marks' => isset($request['total_marks']) && $request['total_marks'] != ""?$request['total_marks']:0,
          'total_questions' => isset($request['total_questions']) && $request['total_questions'] != ""?$request['total_questions']:0,
          'organization_id' =>  isset($request['organization_id'])?$request['organization_id']:0,
          'teacher_id' =>  isset($request['teacher_id'])?$request['teacher_id']:0,
          'questions_type' => isset($request['questions_type'])?$request['questions_type']:0,
          'submit_type' => isset($request['submit_type'])?$request['submit_type']:0,
          'updated_at' => date('Y-m-d'),
          'updated_by' => Auth::user()->id
       ];
        if($filename != ""){
          $data['file_name'] = $filename;
        }
        if($imagename != ""){
          $data['image_name'] = $imagename;
        }

         DB::table('exam')->where('id', $id)->limit(1)->update($data);

         $inputLang = [];
         $outputLang = [];
         if(isset($request['language'])){
           foreach ($request['language'] as $key => $value) {
             $inputLang[] = $value;
           }
         }
         $queryLang = DB::table('exam_languages')->where("exam_id","=",$id)->get();
         foreach ($queryLang as $key => $value) {
           $outputLang[] = $value->language_id;
         }

         if($inputLang !== array_intersect($inputLang, $outputLang) || $outputLang !== array_intersect($outputLang, $inputLang)){
           DB::table('exam_languages')->where('exam_id', $id)->delete();

           $lang=[];
           $count = 0;
           foreach ($request['language'] as $key => $value) {
             $lang[$count]['language_id'] = $value;
             $lang[$count]['exam_id'] = $id;
             $count++;
           }
           $exam_languages = DB::table('exam_languages')->insert($lang);

           foreach ($inputLang as $key => $value) {
              $data = DB::table("exam_instructions")->where("language_id","=",$value)->where("exam_id","=",$id)->first();
              if(!isset($data->id)){
                  DB::table("exam_instructions")->insert(["language_id" =>$value,"exam_id"=>$id ]);
              }
           }
           // $arr_diff = array_diff($outputLang,$inputLang);
           // if(count($arr_diff)){
           //   foreach ($arr_diff as $key => $value) {
           //     DB::table('exam_instructions')->where("language_id",$value)->where('exam_id', $id)->delete();
           //   }
           //    // DB::table('exam_languages')->whereIn("language_id",$arr_diff)->where('exam_id', $id)->delete();
           // }
         }

         return redirect('admin/exam/instructions/'.$id);
    }

    public function showInstructionPage($exam_id){
      if (! Gate::allows('exam_edit')) {
          return abort(401);
      }
      $query = DB::table('exam')
          ->where('exam.id',"=",$exam_id)
          ->where('is_schedule',"=","0")
          ->first();
      if(!isset($query->id)){
        return redirect()->route('admin.exam.index')->with('error','unauthorized access!');
      }
      $exam = DB::table("exam_instructions")->where("exam_id",$exam_id)->count();
      if(!$exam){
        return redirect()->route('admin.exam.index')->with('error','unauthorized access!');
      }
      $exam_instruction = DB::table("exam_instructions")
                          ->select("exam_instructions.id AS id","exam_instructions.language_id as language_id","exam_instructions.exam_id as exam_id","exam_instructions.exam_note as exam_note","languages.title AS title")
                          ->join("languages","languages.id","=","exam_instructions.language_id")
                          ->join("exam_languages","exam_languages.language_id","=","exam_instructions.language_id")
                          ->where("exam_languages.exam_id",$exam_id)
                          ->where("exam_instructions.exam_id",$exam_id)
                          ->get();
      return view('admin.exam.instruction', compact('exam_id','exam_instruction'));
    }
    public function saveInstructionPage(Request $request){
      if (! Gate::allows('exam_edit')) {
        return abort(401);
      }
      $query = DB::table('exam')
          ->where('exam.id',"=",$request->exam_id)
          ->where('is_schedule',"=","0")
          ->first();
      if(!isset($query->id)){
        return redirect()->route('admin.exam.index')->with('error','unauthorized access!');
      }
      $exam = DB::table("exam_instructions")->where("exam_id",$request->exam_id)->count();
      if(!$exam){
        return redirect()->route('admin.exam.index')->with('error','unauthorized access!');
      }
      $exam_instruction = DB::table("exam_instructions")
                          ->select("exam_instructions.id AS id","exam_instructions.language_id as language_id","exam_instructions.exam_id as exam_id","languages.title AS title")
                          ->join("languages","languages.id","=","exam_instructions.language_id")
                          ->join("exam_languages","exam_languages.language_id","=","exam_instructions.language_id")
                          ->where("exam_languages.exam_id",$request->exam_id)
                          ->where("exam_instructions.exam_id",$request->exam_id)
                          ->get();
      $error = [];
      $data = [];
      foreach ($exam_instruction as $key => $value) {
        if(isset($request['instruction_'.$value->language_id])){
          if(isset($request['instruction_'.$value->language_id]) && preg_replace('/\s+/','',str_replace('&nbsp;','',trim(strip_tags($request['instruction_'.$value->language_id])))) == ""){
            $error['instruction_'.$value->language_id] = $value->title." instruction Required!";
          }else{
            $data[$value->language_id] = $request['instruction_'.$value->language_id];
          }
        }else{
          $error['instruction_'.$value->language_id] = $value->title." instruction Required!";
        }
      }
      if(count($error)){
        return back()->withInput($request->input())->withErrors(new \Illuminate\Support\MessageBag($error));
      }
      foreach ($data as $key => $value) {
        DB::table("exam_instructions")->where("language_id","=",$key)->where("exam_id","=",$request->exam_id)->update(['exam_note'=>$value]);
      }
      return redirect('admin/exam/section/'.$request->exam_id);

    }

    public function showSection($exam_id){
      if (! Gate::allows('exam_edit')) {
          return abort(401);
      }
      $query = DB::table('exam')
          ->where('exam.id',"=",$exam_id)
          ->first();

      $is_active = $query->exam_status;
      // if(!isset($query->id)){
      //   return redirect()->route('admin.exam.index')->with('error','unauthorized access!');
      // }
      $exam_section = DB::table("exam_sections")->where("exam_id",$exam_id)->get();

      $examDetail = DB::table("exam")->where("id",$exam_id)->first();

      $question_type = DB::table('question_type')
              ->select('id','title')
              ->get();

      $questionType = array('0' => 'NA');

      foreach ($question_type as $key => $value) {
        $questionType[$value->id] = $value->title;
      }
      foreach ($exam_section as $key => $value) {
        $value->examCompleteStatus = $this->checkSectionStatus($exam_id,$value->id);
      }

      return view('admin.exam.section', compact('exam_id','is_active','examDetail','exam_section','questionType'));
    }

    public function addSection($exam_id){

      if (! Gate::allows('exam_edit')) {
          return abort(401);
      }
      $query = DB::table('exam')
          ->where('exam.id',"=",$exam_id)
          ->where('is_schedule',"=","0")
          ->first();
      if(!isset($query->id)){
        return back()->with('error','unauthorized access!');
      }
      $question_type = DB::table('question_type')
              ->select('id','title')
              ->get();

      $questionType = [];
      $questionReadOnly = false;
      $current_questions_type = $query->questions_type;
      if($query->questions_type == 0){
        $questionType[0] = 'Both';
        foreach ($question_type as $key => $value) {
          $questionType[$value->id] = $value->title;
        }
      }else{
        $questionReadOnly = true;
        foreach ($question_type as $key => $value) {
          if($query->questions_type == $value->id)
            $questionType[$value->id] = $value->title;
        }
      }
      $submitType = [];
      $submitReadOnly = false;
      $current_submit_type = $query->submit_type;
      if($query->submit_type == 0){
        $submitType[0] = 'Both';
        $submitType[1] = 'Text';
        $submitType[2] = 'Numaric';
      }else{
        $submitReadOnly = true;
        if($query->submit_type == 1){
          $submitType[1] = 'Text';
        }else{
          $submitType[2] = 'Numaric';
        }
      }
      return view('admin.exam.addSection', compact('exam_id','questionType','submitType','current_submit_type','questionReadOnly','submitReadOnly','current_questions_type'));

    }

    public function saveSection(StoreExamSectionRequest $request){
      if (! Gate::allows('exam_edit')) {
          return abort(401);
      }
      $query = DB::table('exam')
          ->where('exam.id',"=",$request->exam_id)
          ->where('is_schedule',"=","0")
          ->first();
      if(!isset($query->id)){
        return back()->with('error','unauthorized access!');
      }
      $exam_section = DB::table('exam_sections')
          ->where('exam_id',"=",$request->exam_id)
          ->get();
      $total_marks = 0;
      $total_question = 0;
      $exam_duration = 0;
      $cutoff = 0;
      $errors = [];
      foreach ($exam_section as $key => $value) {
        $total_marks += $value->total_marks;
        $total_question += $value->total_questions;
        $exam_duration += $value->section_duration;
        $cutoff += $value->cutoff;
      }
      if(isset($request['section_duration'])){
        if(($exam_duration+$request['section_duration']) > $query->exam_duration){
          $errors['section_duration'] = "Sum of all section duration shouldn't greater than exam duration.";
        }
      }
      if(isset($request['total_marks'])){
        if(($total_marks+$request['total_marks']) > $query->total_marks){
          $errors['total_marks'] = "Sum of all section marks shouldn't greater than exam total marks.";
        }
      }
      if(isset($request['total_questions'])){
        if(($total_question+$request['total_questions']) > $query->total_questions){
          $errors['total_questions'] = "Sum of all section question shouldn't greater than exam total questions.";
        }
      }
      if(isset($request['cutoff'])){
        if(($cutoff+$request['cutoff']) > $query->passing_marks){
          $errors['cutoff'] = "Sum of all section cutoff shouldn't greater than exam passing marks.";
        }
      }
      if(count($errors)){
        return back()->withInput($request->input())->withErrors(new \Illuminate\Support\MessageBag($errors));
      }
      DB::table("exam_sections")->insert([
        "exam_id" => $request->exam_id,
        "section_name" => $request['section_name'],
        "section_duration" => $request['section_duration'] ? $request['section_duration'] : 0,
        "total_marks" => $request['total_marks'] ? $request['total_marks'] : 0,
        "cutoff" => $request['cutoff'] ? $request['cutoff'] : 0,
        "total_questions" => $request['total_questions'] ? $request['total_questions'] : 0,
        "is_negative_marking" => $request['is_negative_marking'],
        "negative_marking_no" => isset($request['negative_marking_no']) ? $request['negative_marking_no'] : 0,
        "questions_type" => isset($request['questions_type']) ? $request['questions_type'] : 0,
        "submit_type" => isset($request['submit_type']) ? $request['submit_type'] : 0
      ]);
      return redirect('admin/exam/section/'.$request->exam_id);
    }

    public function editSection($exam_id,$section_id){
      $query = DB::table('exam')
          ->where('exam.id',"=",$exam_id)
          ->where('is_schedule',"=","0")
          ->first();
      if(!isset($query->id)){
        return back()->with('error','unauthorized access!');
      }
      $exam_section = DB::table("exam_sections")->where("exam_id",$exam_id)->where("id",$section_id)->first();

      $question_type = DB::table('question_type')
              ->select('id','title')
              ->get();

      $questionType = [];
      $questionReadOnly = false;
      if($query->questions_type == 0){
        $questionType[0] = 'Both';
        if($exam_section->questions_type != 0){
          foreach ($question_type as $key => $value) {
            if($exam_section->questions_type == $value->id)
              $questionType[$value->id] = $value->title;
          }
        }
      }else{
        $questionReadOnly = true;
        foreach ($question_type as $key => $value) {
          if($query->questions_type == $value->id)
            $questionType[$value->id] = $value->title;
        }
      }

      $submitType = [];
      $submitReadOnly = false;
      if($query->submit_type == 0){
        $submitType[0] = 'Both';
        if($exam_section->submit_type == 1){
          $submitType[1] = 'Text';
        }elseif($exam_section->submit_type == 2){
          $submitType[2] = 'Numaric';
        }
      }else{
        $submitReadOnly = true;
        if($query->submit_type == 1){
          $submitType[1] = 'Text';
        }else{
          $submitType[2] = 'Numaric';
        }
      }
      return view('admin.exam.editSection', compact('exam_id','section_id','questionType','questionReadOnly','submitReadOnly','exam_section','submitType'));

    }

    public function updateSection(UpdateExamSectionRequest $request){
      if (! Gate::allows('exam_edit')) {
          return abort(401);
      }
      $query = DB::table('exam')
          ->where('exam.id',"=",$request->exam_id)
          ->where('is_schedule',"=","0")
          ->first();
      if(!isset($query->id)){
        return back()->with('error','unauthorized access!');
      }
      $exam_section = DB::table('exam_sections')
          ->where('exam_id',"=",$request->exam_id)
          ->where('id',"!=",$request->id)
          ->get();
      $total_marks = 0;
      $total_question = 0;
      $exam_duration = 0;
      $cutoff = 0;
      $errors = [];
      foreach ($exam_section as $key => $value) {
        $total_marks += $value->total_marks;
        $total_question += $value->total_questions;
        $exam_duration += $value->section_duration;
        $cutoff += $value->cutoff;
      }
      if(isset($request['section_duration'])){
        if(($exam_duration+$request['section_duration']) > $query->exam_duration){
          $errors['section_duration'] = "Sum of all section duration shouldn't greater than exam duration.";
        }
      }
      if(isset($request['total_marks'])){
        if(($total_marks+$request['total_marks']) > $query->total_marks){
          $errors['total_marks'] = "Sum of all section marks shouldn't greater than exam total marks.";
        }
      }
      if(isset($request['total_questions'])){
        if(($total_question+$request['total_questions']) > $query->total_questions){
          $errors['total_questions'] = "Sum of all section question shouldn't greater than exam total questions.";
        }
      }
      if(isset($request['cutoff'])){
        if(($cutoff+$request['cutoff']) > $query->passing_marks){
          $errors['cutoff'] = "Sum of all section cutoff shouldn't greater than exam passing marks.";
        }
      }
      if(count($errors)){
        return back()->withInput($request->input())->withErrors(new \Illuminate\Support\MessageBag($errors));
      }
      $total_marks = 0;
      $exam_duration = 0;
      $errors = [];
      $exam_questions = DB::table('exam_questions')
          ->where('exam_id',"=",$request->exam_id)
          ->where('section_id',"=",$request->id)
          ->get();
      if(count($exam_questions)){
        foreach ($exam_questions as $key => $value) {
          $total_marks += $value->question_marks;
          $exam_duration += $value->question_duration;
        }
        if(count($exam_questions) > $request['total_questions']){
          $errors['total_questions'] = "Section question shouldn't less than total count of question.";
        }
        if(isset($request['section_duration']) && $request['section_duration'] > 0){
          if($exam_duration > $request['section_duration']){
            $errors['section_duration'] = "Section duration shouldn't less than sum of all question duration.";
          }
        }
        if($total_marks > $request['total_marks']){
          $errors['total_marks'] = "Section marks shouldn't less than sum of all question marks.";
        }
      }
      if(count($errors)){
        return back()->withInput($request->input())->withErrors(new \Illuminate\Support\MessageBag($errors));
      }

      DB::table("exam_sections")->where("id",$request->id)->update([
        "section_name" => $request['section_name'],
        "section_duration" => $request['section_duration'] ? $request['section_duration'] : 0,
        "total_marks" => $request['total_marks'] ? $request['total_marks'] : 0,
        "cutoff" => $request['cutoff'] ? $request['cutoff'] : 0,
        "total_questions" => $request['total_questions'] ? $request['total_questions'] : 0,
        "is_negative_marking" => $request['is_negative_marking'],
        "negative_marking_no" => isset($request['negative_marking_no']) ? $request['negative_marking_no'] : 0,
        "questions_type" => isset($request['questions_type']) ? $request['questions_type'] : 0,
        "submit_type" => isset($request['submit_type']) ? $request['submit_type'] : 0
      ]);

      return redirect('admin/exam/section/'.$request['exam_id']);

    }
    public function showQuestions($exam_id,$section_id){

      if (! Gate::allows('exam_edit')) {
        return abort(401);
      }
      $query = DB::table('exam')
          ->where('exam.id',"=",$exam_id)
          ->first();

      $is_active = $query->exam_status;
      // if(!isset($query->id)){
      //   return redirect()->route('admin.exam.index')->with('error','unauthorized access!');
      // }
          $examQuestions = DB::table('exam_questions')
          ->where('exam_id',"=",$exam_id)
          ->where('section_id',"=",$section_id)
          ->orderBy('question_sequence')
          ->get();

          $questionDetail = [];
          foreach ($examQuestions as $key => $value) {
              $questionQuery = DB::table('question_details')
              ->where('question_id',"=",$value->id)
              ->first();
            $questionDetail[$value->id] = isset($questionQuery->question_detail) ? $questionQuery->question_detail :"";
          }

          $examSection = DB::table('exam_sections')
          ->where('exam_id',"=",$exam_id)
          ->where('id',"=",$section_id)
          ->first();

          $question_type = DB::table('question_type')
                  ->select('id','title')
                  ->get();

          $questionType = array('0' => 'NA');

          foreach ($question_type as $key => $value) {
            $questionType[$value->id] = $value->title;
          }

          $languages = DB::table("languages")
                    ->select('id','title')
                    ->where("status","=",2)
                    ->get();
      // exit(print_r($examQuestions));
      foreach ($examQuestions as $key => $value) {
        $value->examCompleteStatus = $this->checkQuestionsStatus($exam_id,$section_id,$value->id);
      }

      return view('admin.exam.question', compact('exam_id','is_active','section_id','examSection','examQuestions','questionDetail','languages','questionType'));
    }

    public function questionSequence($exam_id,$section_id){
      if (! Gate::allows('exam_edit')) {
        return abort(401);
      }
      $query = DB::table('exam')
          ->where('exam.id',"=",$exam_id)
          ->where('is_schedule',"=","0")
          ->first();
      if(!isset($query->id)){
        return back()->with('error','unauthorized access!');
      }
          $examQuestions = DB::table('exam_questions')
          ->where('exam_id',"=",$exam_id)
          ->where('section_id',"=",$section_id)
          ->orderBy('question_sequence')
          ->get();

          $questionDetail = [];
          foreach ($examQuestions as $key => $value) {
              $questionQuery = DB::table('question_details')
              ->where('question_id',"=",$value->id)
              ->first();
            $questionDetail[$value->id] = $questionQuery;
          }

          $examSection = DB::table('exam_sections')
          ->where('exam_id',"=",$exam_id)
          ->where('id',"=",$section_id)
          ->first();

          $question_type = DB::table('question_type')
                  ->select('id','title')
                  ->get();

          $questionType = array('0' => 'NA');

          foreach ($question_type as $key => $value) {
            $questionType[$value->id] = $value->title;
          }

          $languages = DB::table("languages")
                    ->select('id','title')
                    ->where("status","=",2)
                    ->get();
      // exit(print_r($examQuestions));
      return view('admin.exam.questionSequence', compact('exam_id','section_id','examSection','examQuestions','questionDetail','languages','questionType'));

    }
    public function saveQuestionSequence(Request $request){
      $data = ['error'=>false,"msg"=>"save successfully"];
      if(!isset($request->exam_id) || $request->exam_id == "" || !isset($request->section_id) || $request->section_id == "" || !isset($request->data)){
        $data['error'] = true;
        $data['msg'] = "Failed to get proper data";
        return json_encode($data);
      }
      foreach ($request['data'] as $key => $value) {
        // exit($key."===".$value);
        DB::table("exam_questions")
                     ->where("id",$key)
                     ->where("exam_id",$request['exam_id'])
                     ->where("section_id",$request['section_id'])
                     ->update([
                       "question_sequence" => $value
                     ]);
      }
      return json_encode($data);
    }
    public function addQuestion($exam_id, $section_id){
      $query = DB::table('exam')
          ->where('exam.id',"=",$exam_id)
          ->where('is_schedule',"=","0")
          ->first();
      if(!isset($query->id)){
        return back()->with('error','unauthorized access!');
      }
      $exam_section = DB::table('exam_sections')
          ->where('exam_id',"=",$exam_id)
          ->where('id',$section_id)
          ->first();
      $exam_questions = DB::table('exam_questions')
          ->where('exam_id',"=",$exam_id)
          ->where('section_id',$section_id)
          ->get();
      if($exam_questions != "" && (count($exam_questions) >= $exam_section->total_questions)){
        return back()->with('error',"Cant add new question. Section question's limit exceeded.");
      }
      $totalM = 0;
      $totalD = 0;
      foreach ($exam_questions as $key => $value) {
        $totalM += $value->question_marks;
        $totalD += $value->question_duration;
      }
      if($totalM >= $exam_section->total_marks){
        return back()->with('error',"Cant add new question. Question Marks limit exceeded.");
      }
      if(($exam_section->section_duration != 0 && $totalD >= $exam_section->section_duration)){
        return back()->with('error',"Cant add new question. Question Duration limit exceeded.");
      }
      $exam_by_questions = DB::table('exam_questions')
          ->where('exam_id',"=",$exam_id)
          ->get();
      $totalD = 0;
      foreach ($exam_by_questions as $key => $value) {
        $totalD += $value->question_duration;
      }
      if($totalD >= $query->exam_duration){
        return back()->with('error',"Cant add new question. Question Duration limit exceeded.");
      }
      $question_type = DB::table('question_type')
              ->select('id','title')
              ->get();

      $questionType = array();
      $current_questions_type = $exam_section->questions_type;
      $questionReadOnly = false;
      if($exam_section->questions_type == 0){
        foreach ($question_type as $key => $value) {
          $questionType[$value->id] = $value->title;
        }
      }else{
        $questionReadOnly = true;
        foreach ($question_type as $key => $value) {
          if($exam_section->questions_type == $value->id){
            $questionType[$value->id] = $value->title;
          }
        }
      }

      $submitType = array();
      $current_submit_type = $exam_section->submit_type;
      $submitReadOnly = false;

      if($exam_section->submit_type == 0){
          $submitType[1] = 'Text';
          $submitType[2] = 'Numaric';
      }else{
        if($exam_section->submit_type == 1){
          $submitType[1] = 'Text';
        }elseif($exam_section->submit_type == 2){
          $submitType[2] = 'Numaric';
        }
      }

      $examLanguage = DB::table("exam_languages")
                    ->select("exam_languages.id As id","exam_languages.language_id AS language_id","languages.title as title")
                    ->join("languages","languages.id","=","exam_languages.language_id")
                    ->where("exam_id",$exam_id)
                    ->get();

      return view('admin.exam.addQuestion', compact('exam_id','section_id','examLanguage','questionType','submitType','questionReadOnly','submitReadOnly','current_submit_type','current_questions_type'));
    }

    public function saveQuestion(Request $request){
      $query = DB::table('exam')
          ->where('exam.id',"=",$request['exam_id'])
          ->where('is_schedule',"=","0")
          ->first();
      if(!isset($query->id)){
        return back()->with('error','unauthorized access!');
      }
      $error = [];
      $data = [];
      if(!isset($request['questions_type']) || $request['questions_type'] == ""){
          $error['questions_type'] = "Required field.";
      }
      if(!isset($request['submit_type']) || $request['submit_type'] == ""){
          $error['submit_type'] = "Required field.";
      }
      if(!isset($request['question_marks']) || $request['question_marks'] == "" || $request['question_marks'] < 1){
          $error['question_marks'] = "Required field and at least initial value start from 1.";
      }
      $total_marks = 0;
      $exam_duration = 0;
      $exam_questions = DB::table('exam_questions')
          ->where('exam_id',"=",$request->exam_id)
          ->where('section_id',"=",$request->section_id)
          ->get();

      $exam_by_questions = DB::table('exam_questions')
          ->where('exam_id',"=",$request->exam_id)
          ->get();

      $exam_sections = DB::table('exam_sections')
          ->where('exam_id',"=",$request->exam_id)
          ->where('id',"=",$request->section_id)
          ->first();
      foreach ($exam_questions as $key => $value) {
        $total_marks += $value->question_marks;
        $exam_duration += $value->question_duration;
      }
      if(isset($request['question_duration'])){
        if($exam_sections->section_duration > 0 && ($exam_duration+$request['question_duration']) > $exam_sections->section_duration){
          $error['question_duration'] = "Sum of all question duration shouldn't greater than parent section duration.";
        }else{
          $exam_duration = 0;
          foreach ($exam_by_questions as $key => $value) {
            $exam_duration += $value->question_duration;
          }
          if(($exam_duration+$request['question_duration']) > $query->exam_duration){
            $error['question_duration'] = "Sum of all question duration shouldn't greater than parent section duration.";
          }
        }
      }
      if(($total_marks+$request['question_marks']) > $exam_sections->total_marks){
        $error['question_marks'] = "Sum of all question marks shouldn't greater than parent section total marks.";
      }

      $examLanguage = DB::table("exam_languages")
                    ->select("exam_languages.id As id","exam_languages.language_id AS language_id","languages.title as title")
                    ->join("languages","languages.id","=","exam_languages.language_id")
                    ->where("exam_id",$request['exam_id'])
                    ->get();

      foreach ($examLanguage as $key => $value) {

        if(isset($request['paragraph_detail_'.$value->language_id])){
            $data[$value->language_id]['paragraph_detail'] = $request['paragraph_detail_'.$value->language_id];
        }
        if(isset($request['paragraph_file_'.$value->language_id])){
            $data[$value->language_id]['paragraph_file'] = $request['paragraph_file_'.$value->language_id];
        }
        if(isset($request['paragraph_image_'.$value->language_id])){
            $data[$value->language_id]['paragraph_image'] = $request['paragraph_image_'.$value->language_id];
        }
        if(isset($request['question_file_'.$value->language_id])){
            $data[$value->language_id]['question_file'] = $request['question_file_'.$value->language_id];
        }
        if(isset($request['question_image_'.$value->language_id])){
            $data[$value->language_id]['question_image'] = $request['question_image_'.$value->language_id];
        }

        if(isset($request['question_detail_'.$value->language_id])){
          if(isset($request['question_detail_'.$value->language_id]) && preg_replace('/\s+/','',str_replace('&nbsp;','',trim(strip_tags($request['question_detail_'.$value->language_id])))) == ""){
            $error['question_detail_'.$value->language_id] = $value->title." Question Detail Required!";
          }else{
            $data[$value->language_id]['question_detail'] = $request['question_detail_'.$value->language_id];
          }
        }else{
          $error['question_detail_'.$value->language_id] = $value->title." Question Detail Required!";
        }

        if(isset($request['answer_detail_'.$value->language_id])){
          if(isset($request['answer_detail_'.$value->language_id]) && preg_replace('/\s+/','',str_replace('&nbsp;','',trim(strip_tags($request['answer_detail_'.$value->language_id])))) == ""){
            $error['answer_detail_'.$value->language_id] = $value->title." Answer Detail Required!";
          }else{
            $data[$value->language_id]['answer_detail'] = $request['answer_detail_'.$value->language_id];
          }
        }else{
          $error['answer_detail_'.$value->language_id] = $value->title." Answer Detail Required!";
        }
      }
      if(count($error)){
        return back()->withInput($request->input())->withErrors(new \Illuminate\Support\MessageBag($error));
      }
      // exit(print_r($data));
      $lastQuestion = DB::table("exam_questions")->where('section_id',$request['section_id'])->where('exam_id',$request['exam_id'])->latest('question_sequence')->first();
      $sequence = 1;
      if(isset($lastQuestion->question_sequence)){
        $sequence = ++$lastQuestion->question_sequence;
      }
      $questionId = DB::table("exam_questions")
                    ->insertGetId([
                      "exam_id" => $request['exam_id'],
                      "section_id" => $request['section_id'],
                      "question_type_id" => $request['questions_type'],
                      "answer_type_id"  => $request['submit_type'],
                      "question_marks" => isset($request['question_marks']) ? $request['question_marks'] : 0,
                      "question_duration" => (isset($request['question_duration']) && $request['question_duration'] != "") ? $request['question_duration'] : 0,
                      "question_sequence" => $sequence
                    ]);

      foreach ($data as $key => $value) {
        $paragraph_file = "";
        $paragraph_image = "";
        $question_file = "";
        $question_image = "";
        if (isset($value['paragraph_file'])) {
            $images = $value['paragraph_file']->getClientOriginalName();
            $images = time().rand().'_'.$images; // Add current time before image name
            $value['paragraph_file']->move(env('IMG_UPLOAD_PATH').'img/exam/'.$request['exam_id'].'/'.$request['section_id'].'/'.$questionId.'/',$images);
            $paragraph_file = $images;
        }
        if (isset($value['paragraph_image'])) {
            $images = $value['paragraph_image']->getClientOriginalName();
            $images = time().rand().'_'.$images; // Add current time before image name
            $value['paragraph_image']->move(env('IMG_UPLOAD_PATH').'img/exam/'.$request['exam_id'].'/'.$request['section_id'].'/'.$questionId.'/',$images);
            $paragraph_image = $images;
        }
        if (isset($value['question_file'])) {
            $images = $value['question_file']->getClientOriginalName();
            $images = time().rand().'_'.$images; // Add current time before image name
            $value['question_file']->move(env('IMG_UPLOAD_PATH').'img/exam/'.$request['exam_id'].'/'.$request['section_id'].'/'.$questionId.'/',$images);
            $question_file = $images;
        }
        if (isset($value['question_image'])) {
            $images = $value['question_image']->getClientOriginalName();
            $images = time().rand().'_'.$images; // Add current time before image name
            $value['question_image']->move(env('IMG_UPLOAD_PATH').'img/exam/'.$request['exam_id'].'/'.$request['section_id'].'/'.$questionId.'/',$images);
            $question_image = $images;
        }
        DB::table("question_details")->insertGetId([
          "question_id" => $questionId,
          "paragraph_detail" => isset($value['paragraph_detail']) ? $value['paragraph_detail'] : "",
          "paragraph_file" => $paragraph_file,
          "paragraph_image" => $paragraph_image,
          "question_detail" => $value['question_detail'],
          "question_file"=> $question_file,
          "question_image" => $question_image,
          "answer_detail" => $value['answer_detail'],
          "question_language_id" => $key,
        ]);
      }

      if($request['questions_type'] == 2){
        return redirect('admin/exam/question/option/edit/'.$request['exam_id'].'/'.$request['section_id'].'/'.$questionId);
      }else{
        return redirect('admin/exam/question/'.$request['exam_id'].'/'.$request['section_id']);
      }
    }


    public function editQuestion($exam_id,$section_id,$question_id){
        $query = DB::table('exam')
            ->where('exam.id',"=",$exam_id)
            ->where('is_schedule',"=","0")
            ->first();
        if(!isset($query->id)){
          return back()->with('error','unauthorized access!');
        }
        $exam_section = DB::table('exam_sections')
            ->where('exam_id',"=",$exam_id)
            ->where('id',$section_id)
            ->first();
        $question_type = DB::table('question_type')
                ->select('id','title')
                ->get();


        $examQuestion = DB::table("exam_questions")
                      ->where("exam_id",$exam_id)
                      ->where("section_id",$section_id)
                      ->where("id",$question_id)
                      ->first();
        $examLanguage = DB::table("exam_languages")
                      ->select("exam_languages.id As id","exam_languages.language_id AS language_id","languages.title as title")
                      ->join("languages","languages.id","=","exam_languages.language_id")
                      ->where("exam_id",$exam_id)
                      ->get();

        $examDetailsQuery = DB::table("question_details")
                      ->select(
                        "question_details.id AS id",
                        "question_details.paragraph_detail AS paragraph_detail",
                        "question_details.paragraph_file AS paragraph_file",
                        "question_details.paragraph_image AS paragraph_image",
                        "question_details.question_detail AS question_detail",
                        "question_details.question_file AS question_file",
                        "question_details.question_image AS question_image",
                        "question_details.answer_detail AS answer_detail",
                        "question_details.question_language_id AS language_id",
                        "languages.title As title"
                      )
                      ->join("languages","languages.id","=","question_details.question_language_id")
                      ->where("question_details.question_id",$question_id)
                      ->get();

        $examDetails = [];
        foreach ($examDetailsQuery as $key => $value) {
          $examDetails[$value->language_id]['paragraph_detail'] = $value->paragraph_detail;
          $examDetails[$value->language_id]['paragraph_file'] = $value->paragraph_file;
          $examDetails[$value->language_id]['paragraph_image'] = $value->paragraph_image;
          $examDetails[$value->language_id]['question_detail'] = $value->question_detail;
          $examDetails[$value->language_id]['question_file'] = $value->question_file;
          $examDetails[$value->language_id]['question_image'] = $value->question_image;
          $examDetails[$value->language_id]['answer_detail'] = $value->answer_detail;
          $examDetails[$value->language_id]['title'] = $value->title;
        }

        $questionType = array();
        $questionReadOnly = false;
        if($exam_section->questions_type == 0){
          foreach ($question_type as $key => $value) {
            $questionType[$value->id] = $value->title;
          }
        }else{
          $questionReadOnly = true;
          foreach ($question_type as $key => $value) {
            if($exam_section->questions_type == $value->id){
              $questionType[$value->id] = $value->title;
            }
          }
        }
        $submitType = array();
        $submitReadOnly = false;
        if($exam_section->submit_type == 0){
            $submitType[1] = 'Text';
            $submitType[2] = 'Numaric';
        }else{
          $submitReadOnly = true;
          if($exam_section->submit_type == 1){
            $submitType[1] = 'Text';
          }elseif($exam_section->submit_type == 2){
            $submitType[2] = 'Numaric';
          }
        }
        return view('admin.exam.editQuestion', compact('exam_id','section_id','question_id','examDetails','examQuestion','questionType','submitReadOnly','questionReadOnly','examLanguage','submitType'));
    }

    public function updateQuestion(Request $request){
      $error = [];
      $data = [];
      $query = DB::table('exam')
          ->where('exam.id',"=",$request['exam_id'])
          ->where('is_schedule',"=","0")
          ->first();
      if(!isset($query->id)){
        return redirect()->route('admin.exam.index')->with('error','unauthorized access!');
      }
      if(!isset($request['questions_type']) || $request['questions_type'] == ""){
          $error['questions_type'] = "Required field.";
      }
      if(!isset($request['submit_type']) || $request['submit_type'] == ""){
          $error['submit_type'] = "Required field.";
      }
      if(!isset($request['question_marks']) || $request['question_marks'] == "" || $request['question_marks'] < 1){
          $error['question_marks'] = "Required field and at least initial value start from 1.";
      }
      $total_marks = 0;
      $exam_duration = 0;
      $exam_questions = DB::table('exam_questions')
          ->where('exam_id',"=",$request->exam_id)
          ->where('section_id',"=",$request->section_id)
          ->where('id',"!=",$request->question_id)
          ->get();
      $exam_by_questions = DB::table('exam_questions')
          ->where('exam_id',"=",$request->exam_id)
          ->where('id',"!=",$request->question_id)
          ->get();
      $exam_sections = DB::table('exam_sections')
          ->where('exam_id',"=",$request->exam_id)
          ->where('id',"=",$request->section_id)
          ->first();
      foreach ($exam_questions as $key => $value) {
        $total_marks += $value->question_marks;
        $exam_duration += $value->question_duration;
      }
      if(isset($request['question_duration'])){
        if($exam_sections->section_duration > 0 && ($exam_duration+$request['question_duration']) > $exam_sections->section_duration){
          $error['question_duration'] = "Sum of all question duration shouldn't greater than parent section duration.";
        }else{
          $exam_duration = 0;
          foreach ($exam_by_questions as $key => $value) {
            $exam_duration += $value->question_duration;
          }
          if(($exam_duration+$request['question_duration']) > $query->exam_duration){
            $error['question_duration'] = "Sum of all question duration shouldn't greater than parent section duration.";
          }
        }
      }
      if(($total_marks+$request['question_marks']) > $exam_sections->total_marks){
        $error['question_marks'] = "Sum of all question marks shouldn't greater than parent section total marks.";
      }

      $examLanguage = DB::table("exam_languages")
                    ->select("exam_languages.id As id","exam_languages.language_id AS language_id","languages.title as title")
                    ->join("languages","languages.id","=","exam_languages.language_id")
                    ->where("exam_id",$request['exam_id'])
                    ->get();

      foreach ($examLanguage as $key => $value) {

        if(isset($request['paragraph_detail_'.$value->language_id])){
            $data[$value->language_id]['paragraph_detail'] = $request['paragraph_detail_'.$value->language_id];
        }
        if(isset($request['paragraph_file_'.$value->language_id])){
            $data[$value->language_id]['paragraph_file'] = $request['paragraph_file_'.$value->language_id];
        }
        if(isset($request['paragraph_file_'.$value->language_id.'_delete']) && $request['paragraph_file_'.$value->language_id.'_delete'] == 1){
          $questionDetail = DB::table("question_details")->where("question_id",$request['question_id'])->where("question_language_id",$value->language_id)->first();

          DB::table("question_details")->where("question_id",$request['question_id'])->where("question_language_id",$value->language_id)->update(['paragraph_file'=>'']);
          $oldImagePath = env('IMG_UPLOAD_PATH').'img/exam/'.$request['exam_id'].'/'.$request['section_id'].'/'.$request['question_id'].'/'.$questionDetail->paragraph_file;
           if (file_exists($oldImagePath)) {
               @unlink($oldImagePath);
           }
        }
        if(isset($request['paragraph_image_'.$value->language_id.'_delete']) && $request['paragraph_image_'.$value->language_id.'_delete'] == 1){
          $questionDetail = DB::table("question_details")->where("question_id",$request['question_id'])->where("question_language_id",$value->language_id)->first();

          DB::table("question_details")->where("question_id",$request['question_id'])->where("question_language_id",$value->language_id)->update(['paragraph_image'=>'']);
          $oldImagePath = env('IMG_UPLOAD_PATH').'img/exam/'.$request['exam_id'].'/'.$request['section_id'].'/'.$request['question_id'].'/'.$questionDetail->paragraph_image;
           if (file_exists($oldImagePath)) {
               @unlink($oldImagePath);
           }
        }
        if(isset($request['question_file_'.$value->language_id.'_delete']) && $request['question_file_'.$value->language_id.'_delete'] == 1){
          $questionDetail = DB::table("question_details")->where("question_id",$request['question_id'])->where("question_language_id",$value->language_id)->first();

          DB::table("question_details")->where("question_id",$request['question_id'])->where("question_language_id",$value->language_id)->update(['question_file'=>'']);
          $oldImagePath = env('IMG_UPLOAD_PATH').'img/exam/'.$request['exam_id'].'/'.$request['section_id'].'/'.$request['question_id'].'/'.$questionDetail->question_file;
           if (file_exists($oldImagePath)) {
               @unlink($oldImagePath);
           }
        }
        if(isset($request['question_image_'.$value->language_id.'_delete']) && $request['question_image_'.$value->language_id.'_delete'] == 1){
          $questionDetail = DB::table("question_details")->where("question_id",$request['question_id'])->where("question_language_id",$value->language_id)->first();

          DB::table("question_details")->where("question_id",$request['question_id'])->where("question_language_id",$value->language_id)->update(['question_image'=>'']);
          $oldImagePath = env('IMG_UPLOAD_PATH').'img/exam/'.$request['exam_id'].'/'.$request['section_id'].'/'.$request['question_id'].'/'.$questionDetail->question_image;
           if (file_exists($oldImagePath)) {
               @unlink($oldImagePath);
           }
         }
        if(isset($request['paragraph_image_'.$value->language_id])){
            $data[$value->language_id]['paragraph_image'] = $request['paragraph_image_'.$value->language_id];
        }
        if(isset($request['question_file_'.$value->language_id])){
            $data[$value->language_id]['question_file'] = $request['question_file_'.$value->language_id];
        }
        if(isset($request['question_image_'.$value->language_id])){
            $data[$value->language_id]['question_image'] = $request['question_image_'.$value->language_id];
        }

        if(isset($request['question_detail_'.$value->language_id])){
          if(isset($request['question_detail_'.$value->language_id]) && preg_replace('/\s+/','',str_replace('&nbsp;','',trim(strip_tags($request['question_detail_'.$value->language_id])))) == ""){
            $error['question_detail_'.$value->language_id] = $value->title." Question Detail Required!";
          }else{
            $data[$value->language_id]['question_detail'] = $request['question_detail_'.$value->language_id];
          }
        }else{
          $error['question_detail_'.$value->language_id] = $value->title." Question Detail Required!";
        }

        if(isset($request['answer_detail_'.$value->language_id])){
          if(isset($request['answer_detail_'.$value->language_id]) && preg_replace('/\s+/','',str_replace('&nbsp;','',trim(strip_tags($request['answer_detail_'.$value->language_id])))) == ""){
            $error['answer_detail_'.$value->language_id] = $value->title." Answer Detail Required!";
          }else{
            $data[$value->language_id]['answer_detail'] = $request['answer_detail_'.$value->language_id];
          }
        }else{
          $error['answer_detail_'.$value->language_id] = $value->title." Answer Detail Required!";
        }
      }
      if(count($error)){
        // exit(print_r($error));
        return back()->withInput($request->input())->withErrors(new \Illuminate\Support\MessageBag($error));
      }
      // exit(print_r($data));
      $questionId = DB::table("exam_questions")
                    ->where("id",$request['question_id'])
                    ->where("exam_id",$request['exam_id'])
                    ->where("section_id",$request['section_id'])
                    ->update([
                      "question_type_id" => $request['questions_type'],
                      "answer_type_id"  => $request['submit_type'],
                      "question_marks" => isset($request['question_marks']) ? $request['question_marks'] : 0,
                      "question_duration" => (isset($request['question_duration']) && $request['question_duration']!="") ? $request['question_duration'] : 0
                    ]);

      foreach ($data as $key => $value) {

        $questionDetail = DB::table("question_details")->where("question_id",$request['question_id'])->where("question_language_id",$key)->first();

        $updateData = [
          "paragraph_detail" => isset($value['paragraph_detail']) ? $value['paragraph_detail'] : "",
          "question_detail" => $value['question_detail'],
          "answer_detail" => $value['answer_detail'],
        ];

        if (isset($value['paragraph_file'])) {
            $images = "";
            $oldImagePath = "";
            $images = $value['paragraph_file']->getClientOriginalName();
            $images = time().rand().'_'.$images; // Add current time before image name
            $value['paragraph_file']->move(env('IMG_UPLOAD_PATH').'img/exam/'.$request['exam_id'].'/'.$request['section_id'].'/'.$request['question_id'].'/',$images);
            $updateData["paragraph_file"] = $images;

            if(isset($questionDetail->paragraph_file)){
              $oldImagePath = env('IMG_UPLOAD_PATH').'img/exam/'.$request['exam_id'].'/'.$request['section_id'].'/'.$request['question_id'].'/'.$questionDetail->paragraph_file;
               if (file_exists($oldImagePath)) {
                   @unlink($oldImagePath);
               }
             }
        }
        if (isset($value['paragraph_image'])) {
          $images = "";
          $oldImagePath = "";

            $images = $value['paragraph_image']->getClientOriginalName();
            $images = time().rand().'_'.$images; // Add current time before image name
            $value['paragraph_image']->move(env('IMG_UPLOAD_PATH').'img/exam/'.$request['exam_id'].'/'.$request['section_id'].'/'.$request['question_id'].'/',$images);
            $updateData["paragraph_image"] = $images;

            if(isset($questionDetail->paragraph_image)){
              $oldImagePath = env('IMG_UPLOAD_PATH').'img/exam/'.$request['exam_id'].'/'.$request['section_id'].'/'.$request['question_id'].'/'.$questionDetail->paragraph_image;
               if (file_exists($oldImagePath)) {
                   @unlink($oldImagePath);
               }
            }
        }
        if (isset($value['question_file'])) {
          $images = "";
          $oldImagePath = "";

            $images = $value['question_file']->getClientOriginalName();
            $images = time().rand().'_'.$images; // Add current time before image name
            $value['question_file']->move(env('IMG_UPLOAD_PATH').'img/exam/'.$request['exam_id'].'/'.$request['section_id'].'/'.$request['question_id'].'/',$images);
            $updateData["question_file"] = $images;

             if(isset($questionDetail->question_file)){
               $oldImagePath = env('IMG_UPLOAD_PATH').'img/exam/'.$request['exam_id'].'/'.$request['section_id'].'/'.$request['question_id'].'/'.$questionDetail->question_file;
                if (file_exists($oldImagePath)) {
                    @unlink($oldImagePath);
                }
             }
        }
        if (isset($value['question_image'])) {
          $images = "";
          $oldImagePath = "";

            $images = $value['question_image']->getClientOriginalName();
            $images = time().rand().'_'.$images; // Add current time before image name
            $value['question_image']->move(env('IMG_UPLOAD_PATH').'img/exam/'.$request['exam_id'].'/'.$request['section_id'].'/'.$request['question_id'].'/',$images);
            $updateData["question_image"] = $images;

             if(isset($questionDetail->question_image)){
               $oldImagePath = env('IMG_UPLOAD_PATH').'img/exam/'.$request['exam_id'].'/'.$request['section_id'].'/'.$request['question_id'].'/'.$questionDetail->question_image;
                if (file_exists($oldImagePath)) {
                    @unlink($oldImagePath);
                }
             }
        }

        if(isset($questionDetail->id)){
          DB::table("question_details")->where("id",$questionDetail->id)->where("question_id",$request['question_id'])->where("question_language_id",$key)->update($updateData);
        }else{
          $newQuestion= DB::table("question_details")->insertGetId([
            "question_id" => $request['question_id'],
            "paragraph_detail" => isset($updateData['paragraph_detail']) ? $updateData['paragraph_detail'] : "",
            "paragraph_file" => isset($updateData["paragraph_file"]) ? $updateData["paragraph_file"] : "",
            "paragraph_image" => isset($updateData["paragraph_image"]) ? $updateData["paragraph_image"] : "",
            "question_detail" => $updateData['question_detail'],
            "question_file"=> isset($updateData["question_file"]) ? $updateData["question_file"] : "",
            "question_image" => isset($updateData["question_image"]) ? $updateData["question_image"] : "",
            "answer_detail" => $updateData['answer_detail'],
            "question_language_id" => $key,
          ]);
        }

      }
      if($request['questions_type'] == 2){
        return redirect('admin/exam/question/option/edit/'.$request['exam_id'].'/'.$request['section_id'].'/'.$request['question_id']);
      }else{
        return redirect('admin/exam/question/'.$request['exam_id'].'/'.$request['section_id']);
      }
    }


    public function viewQuestion($exam_id,$section_id,$question_id){
        $query = DB::table('exam')
            ->where('exam.id',"=",$exam_id)
            ->where('is_schedule',"=","0")
            ->first();

        $question_type = DB::table('question_type')
                ->select('id','title')
                ->get();

        $questionSubmitType = array(0=>"Both",1=>"Text",2=>"Numaric");
        $questionType = array(0=>"Both");

        foreach ($question_type as $key => $value) {
          $questionType[$value->id] = $value->title;
        }

        $examQuestion = DB::table("exam_questions")
                      ->where("exam_id",$exam_id)
                      ->where("section_id",$section_id)
                      ->where("id",$question_id)
                      ->first();

        $examDetails = DB::table("question_details")
                      ->select(
                        "question_details.id AS id",
                        "question_details.paragraph_detail AS paragraph_detail",
                        "question_details.paragraph_file AS paragraph_file",
                        "question_details.paragraph_image AS paragraph_image",
                        "question_details.question_detail AS question_detail",
                        "question_details.question_file AS question_file",
                        "question_details.question_image AS question_image",
                        "question_details.answer_detail AS answer_detail",
                        "question_details.question_language_id AS language_id",
                        "languages.title As title"
                      )
                      ->join("languages","languages.id","=","question_details.question_language_id")
                      ->join('exam_languages','exam_languages.language_id',"=","question_details.question_language_id")
                      ->where("exam_languages.exam_id",$exam_id)
                      ->where("question_details.question_id",$question_id)
                      ->get();

        foreach ($examDetails as $key => $value) {
          $examOption = DB::table("question_options")
                        ->select(
                            "question_options.option_value AS option_value",
                            "question_options.option_image AS option_image",
                            "question_options.is_option_correct AS is_option_correct",
                            "option_label.title AS option_label"
                          )
                        ->where("question_details_id",$value->id)
                        ->join('option_label','option_label.id','=','question_options.option_label_id')
                        ->get();
          $value->options = $examOption;
        }
        // exit(print_r($examDetails));
        return view('admin.exam.viewQuestion', compact('exam_id','section_id','question_id','examDetails','examQuestion','questionType','questionSubmitType'));
    }

    public function editOption($exam_id,$section_id,$question_id){
      $query = DB::table('exam')
          ->where('exam.id',"=",$exam_id)
          ->where('is_schedule',"=","0")
          ->first();
      if(!isset($query->id)){
        return back()->with('error','unauthorized access!');
      }

      $questionStatus = $this->checkQuestionsStatus($exam_id,$section_id,$question_id);
      if(!$questionStatus['question_detail']['status']){
        return back()->with('error','Complete Question Detail first.');
      }

      $examDetails = DB::table("question_details")
                    ->select(
                      "question_details.id AS id",
                      "question_details.paragraph_detail AS paragraph_detail",
                      "question_details.paragraph_file AS paragraph_file",
                      "question_details.paragraph_image AS paragraph_image",
                      "question_details.question_detail AS question_detail",
                      "question_details.question_file AS question_file",
                      "question_details.question_image AS question_image",
                      "question_details.answer_detail AS answer_detail",
                      "question_details.question_language_id AS language_id",
                      "languages.title As title"
                    )
                    ->join("languages","languages.id","=","question_details.question_language_id")
                    ->join("exam_languages","exam_languages.language_id","=","question_details.question_language_id")
                    ->where("exam_languages.exam_id",$exam_id)
                    ->where("question_details.question_id",$question_id)
                    ->get();

      $examData = [];
      foreach ($examDetails as $key => $value) {
        $examOption = DB::table("question_options")
                      ->where("question_details_id",$value->id)
                      ->get();


          foreach ($examOption as $keyOption => $valueOption) {
            $examData[$valueOption->option_label_id]['option_label_id'] = $valueOption->option_label_id;
            $examData[$valueOption->option_label_id]['is_option_correct'] = $valueOption->is_option_correct;
            $examData[$valueOption->option_label_id][$value->language_id]['id'] = $valueOption->id;
            $examData[$valueOption->option_label_id][$value->language_id]['option_value'] = $valueOption->option_value;
            $examData[$valueOption->option_label_id][$value->language_id]['option_image'] = $valueOption->option_image;
          }
      }
      // exit(print_r($examData));
      $examLanguageQuery = DB::table("exam_languages")
                    ->select("exam_languages.id As id","exam_languages.language_id AS language_id","languages.title as title")
                    ->join("languages","languages.id","=","exam_languages.language_id")
                    ->where("exam_id",$exam_id)
                    ->get();
      $examLanguage = [];
      foreach ($examLanguageQuery as $key => $value) {
        $examLanguage[$value->language_id] = $value->title;
      }

      $labelQuery = DB::table("option_label")
                    ->get();
      $optionLabel = [];
      foreach ($labelQuery as $key => $value) {
        $optionLabel[$value->id] = $value->title;
      }


      return view('admin.exam.editOption', compact('exam_id','section_id','question_id','examData','examLanguage','optionLabel'));
    }

    public function saveOption(Request $request){
        $data = ["error"=>true,"msg" => "something went wrong!"];
        $examLanguageQuery = DB::table("exam_languages")
                      ->select("exam_languages.id As id","exam_languages.language_id AS language_id","languages.title as title")
                      ->join("languages","languages.id","=","exam_languages.language_id")
                      ->where("exam_id",$request->exam_id)
                      ->get();
        $examLanguage = [];
        foreach ($examLanguageQuery as $key => $value) {
          $examLanguage[$value->language_id] = $value->title;
        }
        // exit(print_r($request->all()));
        if(isset($request->exam_id) && isset($request->section_id) && isset($request->question_id)){
            if(isset($request['check']) && $request['check'] == 2 && isset($request['idSet']) ){
              foreach ($request['idSet'] as $key => $id) {
                $opt = DB::table("question_options")->where("id",$id)->first();
                DB::table("question_options")->where("id",$id)->delete();
                if($opt->option_image != ""){
                  $oldImagePath = env('IMG_UPLOAD_PATH').'img/exam/'.$request->exam_id.'/'.$request->section_id.'/'.$request->question_id.'/'.$opt->option_image;
                  if (file_exists($oldImagePath)) {
                      @unlink($oldImagePath);
                  }
                }
              }
              $data["error"] = false;
              $data["msg"] = "Option Deleted successfully!";
            }elseif(isset($request['check']) && $request['check'] == 1 ){
              $label = [];
              foreach ($examLanguage as $id => $val) {
                $question = DB::table("question_details")->where("question_id",$request->question_id)->where("question_language_id",$id)->first();
                $option = DB::table("question_options")->where("question_details_id",$question->id)->where("option_label_id",trim($request['option_label_'.$id]))->where('id', '!=' , $request['option_id_'.$id])->get();
                if(count($option)){
                  $label[] = $request['option_label_'.$id];
                }
              }
              if(count($label)){
                $data["error"] = true;
                $data["msg"] = "Option Label should be unique!";
                $data["data"] = $label;
                return json_encode($data);
              }
              $label = 0;
              $isOpCorrect = 0;
              foreach ($examLanguage as $id => $val) {
                $opt = DB::table("question_options")->where("id",$request['option_id_'.$id])->first();
                $question = DB::table("question_details")->where("question_id",$request->question_id)->where("question_language_id",$id)->first();

                if(isset($request['option_img_delete_'.$id]) && $request['option_img_delete_'.$id] == 1){
                    DB::table("question_options")->where("id",$request['option_id_'.$id])->update(['option_image'=>'']);
                    if(isset($opt->option_image) && $opt->option_image != ""){
                      $oldImagePath = env('IMG_UPLOAD_PATH').'img/exam/'.$request->exam_id.'/'.$request->section_id.'/'.$request->question_id.'/'.$opt->option_image;
                      if (file_exists($oldImagePath)) {
                          @unlink($oldImagePath);
                      }
                    }
                }

                $file = "";
                if(isset($request['option_image_'.$id])){
                  $images = $request['option_image_'.$id]->getClientOriginalName();
                  $images = time().rand().'_'.$images; // Add current time before image name
                  $request['option_image_'.$id]->move(env('IMG_UPLOAD_PATH').'img/exam/'.$request->exam_id.'/'.$request->section_id.'/'.$request->question_id.'/',$images);
                  $file = $images;
                    if(isset($opt->option_image) && $opt->option_image != ""){
                      $oldImagePath = env('IMG_UPLOAD_PATH').'img/exam/'.$request->exam_id.'/'.$request->section_id.'/'.$request->question_id.'/'.$opt->option_image;
                      if (file_exists($oldImagePath)) {
                          @unlink($oldImagePath);
                      }
                    }
                }

                $update = [
                  "option_label_id" => $request['option_label_'.$id],
                  "option_value" => $request['option_value_'.$id],
                  "is_option_correct" => $request['is_option_correct_'.$id],
                ];
                $label = $request['option_label_'.$id];
                $isOpCorrect = $request['is_option_correct_'.$id];
                if($file != ""){
                  $update['option_image'] = $file;
                }
                if(isset($opt->id)){
                  $res[$id] = DB::table("question_options")->where("id",$request['option_id_'.$id])->update($update);
                }else{
                  $update['question_details_id'] = $question->id;
                  $res[$id] = DB::table("question_options")->insertGetId($update);
                }
              }
              $question = DB::table("question_details")->where("question_id",$request->question_id)->get();
              foreach ($question as $key => $value) {
                 DB::table("question_options")->where("question_details_id",$value->id)->where("option_label_id",$label)->update(['is_option_correct' => $isOpCorrect]);
              }
              $data["error"] = false;
              $data["msg"] = "Option Updated successfully!";

            }elseif (isset($request['check']) && $request['check'] == 0){
              $label = [];
              foreach ($examLanguage as $id => $val) {
                $question = DB::table("question_details")->where("question_id",$request->question_id)->where("question_language_id",$id)->first();
                $option = DB::table("question_options")->where("question_details_id",$question->id)->where("option_label_id",trim($request['option_label_'.$id]))->get();
                if(count($option)){
                  $label[] = $request['option_label_'.$id];
                }
              }
              if(count($label)){
                $data["error"] = true;
                $data["msg"] = "Option Label should be unique!";
                $data["data"] = $label;
                return json_encode($data);
              }
              foreach ($examLanguage as $id => $val) {

                $file = "";
                if(isset($request['option_image_'.$id])){
                  $images = $request['option_image_'.$id]->getClientOriginalName();
                  $images = time().rand().'_'.$images; // Add current time before image name
                  $request['option_image_'.$id]->move(env('IMG_UPLOAD_PATH').'img/exam/'.$request->exam_id.'/'.$request->section_id.'/'.$request->question_id.'/',$images);
                  $file = $images;

                }
                $question = DB::table("question_details")->where("question_id",$request->question_id)->where("question_language_id",$id)->first();
                $insert = [
                  "question_details_id" => $question->id,
                  "option_label_id" => $request['option_label_'.$id],
                  "option_value" => $request['option_value_'.$id],
                  "option_image" => $file,
                  "is_option_correct" => $request['is_option_correct_'.$id],
                ];
                $res[$id] = DB::table("question_options")->insertGetId($insert);
              }
              $data["error"] = false;
              $data["msg"] = "Option Save successfully!";
              $data["data"] = $res;
            }
        }
      return json_encode($data);
    }

    public function destroySection($section_id){
      if (! Gate::allows('exam_delete')) {
          return abort(401);
      }
      $section = DB::table('exam_sections')
          ->where('id',$section_id)
          ->first();

      if(!isset($section->id)){
        return back()->with('error', 'Invalid Section.');
      }
      $query = DB::table('exam')
          ->where('exam.id',"=",$section->exam_id)
          ->where('is_schedule',"=","0")
          ->first();
      if(!isset($query->id)){
        return redirect()->route('admin.exam.index')->with('error','unauthorized access!');
      }
      $this->deleteSection($section->exam_id,$section_id);

      return back()->with('success', 'Section deleted successfully.');
    }

    public function destroyQuestion($question_id){
        if (! Gate::allows('exam_delete')) {
            return abort(401);
        }
        $question = DB::table('exam_questions')
            ->where('id',$question_id)
            ->first();

        if(!isset($question->id)){
          return back()->with('error', 'Invalid Question.');
        }
        $query = DB::table('exam')
            ->where('exam.id',"=",$question->exam_id)
            ->where('is_schedule',"=","0")
            ->first();
        if(!isset($query->id)){
          return redirect()->route('admin.exam.index')->with('error','unauthorized access!');
        }
        $this->deleteQuestion($question->exam_id,$question->section_id,$question_id);
        return back()->with('success', 'Question deleted successfully.');
    }

    private function deleteSection($exam_id,$section_id){
      DB::table('exam_sections')->where('id', $section_id)->delete();
      $question = DB::table('exam_questions')
          ->where('section_id',$section_id)
          ->get();
      foreach ($question as $key => $value) {
          $this->deleteQuestion($value->exam_id,$value->section_id,$value->id);
      }
      $this->deleteFiles(env('IMG_UPLOAD_PATH').'img/exam/'.$exam_id.'/'.$section_id.'/');
    }
    private function deleteQuestion($exam_id,$section_id,$question_id){
      $questionDetail = DB::table('question_details')
          ->where('question_details.question_id','=',$question_id)
          ->get();

      DB::table('exam_questions')->where('id', $question_id)->delete();
      DB::table('question_details')->where('question_id', $question_id)->delete();
      foreach ($questionDetail as $key => $value) {
        if($value->paragraph_file != ""){
          $oldImagePath = env('IMG_UPLOAD_PATH').'img/exam/'.$exam_id.'/'.$section_id.'/'.$value->question_id.'/'.$value->paragraph_file;
          if (file_exists($oldImagePath)) {
              @unlink($oldImagePath);
          }
        }
        if($value->paragraph_image != ""){
          $oldImagePath = env('IMG_UPLOAD_PATH').'img/exam/'.$exam_id.'/'.$section_id.'/'.$value->question_id.'/'.$value->paragraph_image;
          if (file_exists($oldImagePath)) {
              @unlink($oldImagePath);
          }
        }
        if($value->question_file != ""){
          $oldImagePath = env('IMG_UPLOAD_PATH').'img/exam/'.$exam_id.'/'.$section_id.'/'.$value->question_id.'/'.$value->question_file;
          if (file_exists($oldImagePath)) {
              @unlink($oldImagePath);
          }
        }
        if($value->question_image != ""){
          $oldImagePath = env('IMG_UPLOAD_PATH').'img/exam/'.$exam_id.'/'.$section_id.'/'.$value->question_id.'/'.$value->question_image;
          if (file_exists($oldImagePath)) {
              @unlink($oldImagePath);
          }
        }
        $this->deleteOption($exam_id,$section_id,$value->question_id,$value->id);
      }

      $this->deleteFiles(env('IMG_UPLOAD_PATH').'img/exam/'.$exam_id.'/'.$section_id.'/'.$question_id.'/');
    }
    private function deleteOption($exam_id,$section_id,$question_id,$question_details_id){
      $questinOpt = DB::table("question_options")->where("question_details_id",$question_details_id)->get();
      DB::table('question_options')->where('question_details_id', $question_details_id)->delete();
      foreach ($questinOpt as $keyOpt => $valueOpt) {

        if($valueOpt->option_image != ""){
          $oldImagePath = env('IMG_UPLOAD_PATH').'img/exam/'.$exam_id.'/'.$section_id.'/'.$question_id.'/'.$valueOpt->option_image;
          if (file_exists($oldImagePath)) {
              @unlink($oldImagePath);
          }
        }

      }
    }
    /**
     * Display User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('exam_view')) {
            return abort(401);
        }

        $user = DB::table('users')
                ->select('role_id')
                ->where('id','=',Auth::user()->id)
                ->first();

        $queryExam = DB::table('exam')
            ->select('exam.id AS id','exam_name','exam_duration','is_negative_marking','video_link','status.title AS status','questions_type','submit_type','total_marks','total_questions','organization_id','teacher_id','negative_marking_no','passing_marks','image_name','file_name','exam_category.title AS exam_category')
            ->join('status', 'exam.exam_status', '=', 'status.id')
            ->join('exam_category','exam_category.id','=','exam.exam_category_id')
            ->where('exam.id',"=",$id);

        if(Auth::user()->role_id != 1 && Auth::user()->role_id != 4){
            $queryExam->where(function($query) {
              return $query->orWhere(['created_by' => Auth::user()->id, 'organization_id' => Auth::user()->id,'teacher_id'=>Auth::user()->id]);
            });
        }

        $exam = $queryExam->first();
        if(!isset($exam->id)){
          return redirect()->route('admin.exam.index')->with('error','unauthorized access!');
        }

        $languages = DB::table('languages')
                ->where('status','=',2)
                ->get();

        $languagesObj = array();
        foreach ($languages as $key => $value) {
          $languagesObj[$value->id] = $value->title;
        }

        $examLangQuery = DB::table('exam_languages')
            ->where('exam_id',"=",$exam->id)
            ->get();

        $examLang = "";
        $examLangObj = [];
        foreach ($examLangQuery as $key => $value) {
          $examLangObj[] = $value->language_id;
          $examLang .= $languagesObj[$value->language_id].", ";
        }
        $examLang = trim($examLang,", ");
        $examInstruction = DB::table('exam_instructions')
            ->select("exam_note","title")
            ->where('exam_id',"=",$exam->id)
            ->whereIn('language_id',$examLangObj)
            ->join('languages',"languages.id","=","exam_instructions.language_id")
            ->get();

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


        $question_type = DB::table('question_type')
                        ->get();

        $questionsType = [0 => "Both"];
        foreach ($question_type as $key => $value) {
          $questionsType[$value->id] = $value->title;
        }
        $submitType= [ 0 => "Both", 1 => "Text", 2 => "Numeric"];

        return view('admin.exam.show', compact('exam', 'teacherObj', 'orgObj', 'examInstruction','languagesObj','examLang','questionsType','submitType'));
    }



    public function destroy($id)
    {
        if (! Gate::allows('exam_delete')) {
            return abort(401);
        }

        $exam = DB::table('exam')
            ->where('id','=',$id)
            ->where('is_schedule',"=","0")
            ->first();

        if(!isset($exam->id)){
          return redirect()->route('admin.exam.index');
        }

        $oldImagePath = env('IMG_UPLOAD_PATH').'img/exam/'.$id.'/'.$exam->file_name;
        if (file_exists($oldImagePath)) {
            @unlink($oldImagePath);
        }
        $oldImagePath = env('IMG_UPLOAD_PATH').'img/exam/'.$id.'/'.$exam->image_name;
        if (file_exists($oldImagePath)) {
            @unlink($oldImagePath);
        }

        DB::table('exam')->where('id', $id)->delete();
        DB::table('exam_languages')->where('exam_id', $id)->delete();
        DB::table('exam_instructions')->where('exam_id', $id)->delete();

        $section = DB::table("exam_sections")->where("exam_id",$id)->get();
        foreach ($section as $key => $value) {
          $this->deleteSection($value->exam_id,$value->id);
        }

        $this->deleteFiles(env('IMG_UPLOAD_PATH').'img/exam/'.$id.'/');
        return back()->with('success', 'Exam deleted successfully.');
    }

    private function deleteFiles($target) {
        if(is_dir($target)){
            $files = glob( $target . '*', GLOB_MARK ); //GLOB_MARK adds a slash to directories returned

            foreach( $files as $file ){
                $this->deleteFiles( $file );
            }

            rmdir( $target );
        } elseif(is_file($target)) {
            unlink( $target );
        }
    }

    public function updateStatus(Request $request){
      if (! Gate::allows('exam_edit')) {
          return abort(401);
      }
      // exit(print_r($request->all()));
      $examStatus = $this->checkExamStatus($request->examId);
      if($examStatus['exam_section']['status'] && $examStatus['section_question']['status'] && $examStatus['question_detail']['status'] && $examStatus['question_option']['status']){
        DB::table('exam')->where('id', $request->examId)->limit(1)
        ->update(array('exam_status' => $request->exam_status,
         'updated_at' => date('Y-m-d'),
        'updated_by' => Auth::user()->id));

        return redirect()->route('admin.exam.index')->with('success',"Exam Status changed successfully.");
      }else{
        return redirect()->route('admin.exam.index')->with('error',"Complete exam detail first!");
      }
    }

    public function showUploadScreen(){

        if (! Gate::allows('exam_access')) {
            return abort(401);
        }

        return view('admin.exam.showUploadScreen');
    }


    public function bulkUpload(Request $request){
        if (! Gate::allows('exam_create')) {
            return abort(401);
        }
        $this->validate($request, [
         'file_name'  => 'required|mimes:xls,xlsx'
        ]);

        $path = $request->file('file_name')->getRealPath();

        $data = Excel::load($path)->get()->toArray();
        if(count($data) != 2){
          return back()->with('error', 'Invalid Sheet - Exam sheet and Question Required!');

        }
        $examSheet = $data[0];
        $questionSheet = $data[1];
        $mysqlData = array();
        $examKeys = array('exam_no'	, 'exam_name',	'exam_duration'	,'exam_category_id' ,'is_negative_marking','video_link','passing_marks', 'exam_note', 'organization_id','teacher_id');
        $questinKey = array('exam_no'	,'question_no','question_detail'	,'questiontype_id'	,'marks'	,'time','explained_answer','objective_question_a','objective_question_b'	,'objective_question_c','objective_question_d','objective_answer');

        foreach ($examSheet as $key => $value) {
          foreach ($examKeys as $keySet) {
            if(!array_key_exists($keySet,$value)){
              return back()->with('error', $keySet.' Key is missing in Exam sheet.');
            }
            if($value[$keySet] == "" && $value[$keySet] != 0){
              return back()->with('error', $keySet.' Key is required in Exam sheet.');
            }
          }
          $mysqlData[$value['exam_no']]['exam_name'] = $value['exam_name'];
          $mysqlData[$value['exam_no']]['exam_duration'] = $value['exam_duration'];
          $mysqlData[$value['exam_no']]['exam_category_id'] = $value['exam_category_id'];
          $mysqlData[$value['exam_no']]['is_negative_marking'] = $value['is_negative_marking'];
          $mysqlData[$value['exam_no']]['negative_marking_no'] = isset($value['negative_marking_no']) ? $value['negative_marking_no'] : 0;
          $mysqlData[$value['exam_no']]['video_link'] = $value['video_link'];
          $mysqlData[$value['exam_no']]['passing_marks'] = $value['passing_marks'];
          $mysqlData[$value['exam_no']]['exam_note'] = $value['exam_note'];
          $mysqlData[$value['exam_no']]['organization_id'] = $value['organization_id'];
          $mysqlData[$value['exam_no']]['teacher_id'] = $value['teacher_id'];
          $mysqlData[$value['exam_no']]['question'] = array();
        }
        foreach ($questionSheet as $key => $value) {
          foreach ($questinKey as $keySet) {
            if(!array_key_exists($keySet,$value)){
              return back()->with('error', $keySet.' Key is missing in Question sheet.');
            }
            if($value[$keySet] == ""){
              return back()->with('error', $keySet.' Key is required in Question sheet.');
            }
          }
          $count = $value['question_no'];
          $mysqlData[$value['exam_no']]['question'][$count]['question_detail'] = $value['question_detail'];
          $mysqlData[$value['exam_no']]['question'][$count]['questiontype_id'] = $value['questiontype_id'];
          $mysqlData[$value['exam_no']]['question'][$count]['marks'] = $value['marks'];
          $mysqlData[$value['exam_no']]['question'][$count]['time'] = $value['time'];
          $mysqlData[$value['exam_no']]['question'][$count]['explained_answer'] = $value['explained_answer'];
          $mysqlData[$value['exam_no']]['question'][$count]['objective_answer'] = $value['objective_answer'];

          $oprtionA = '-';
          $oprtionB = '-';
          $oprtionC = '-';
          $oprtionD = '-';
          $oprtionE = '-';
          $oprtionF = '-';
          if( $value['objective_question_a'] != ""){
              $oprtionA = $value['objective_question_a'];
          }
          if($value['objective_question_b'] != ""){
              $oprtionB = $value['objective_question_b'];
          }
          if($value['objective_question_c'] != ""){
              $oprtionC = $value['objective_question_c'];
          }
          if($value['objective_question_d'] != ""){
              $oprtionD = $value['objective_question_d'];
          }
          if(isset($value['objective_question_e']) && $value['objective_question_e'] != ""){
              $oprtionE = $value['objective_question_e'];
          }
          if(isset($value['objective_question_f']) && $value['objective_question_f'] != ""){
              $oprtionF = $value['objective_question_f'];
          }
          $obj_question = $oprtionA."#$#$#".$oprtionB."#$#$#".$oprtionC."#$#$#".$oprtionD."#$#$#".$oprtionE."#$#$#".$oprtionF;
          $mysqlData[$value['exam_no']]['question'][$count]['objective_question'] = $obj_question;
        }

        // exit(print_r($mysqlData));
        if(count($mysqlData) < 1){
          return back()->with('error', 'Blank Sheet not allowed.');
        }

        foreach ($mysqlData as $key => $value) {
              $exam_id = DB::table('exam')->insertGetId(
                  [
                   'exam_name' => $value['exam_name'],
                   'exam_duration' => $value['exam_duration'],
                   'exam_category_id' => $value['exam_category_id'],
                   'is_negative_marking' => $value['is_negative_marking'],
                   'negative_marking_no' => $value['negative_marking_no'],
                   'video_link' => $value['video_link'],
                   'passing_marks' => $value['passing_marks'],
                   'total_question' => 0,
                   'total_marks' => 0,
                   'exam_note' =>  $value['exam_note'],
                   'organization_id' =>  $value['organization_id'],
                   'teacher_id' =>  $value['teacher_id'],
                   'file_name' => "",
                   'created_at' => date('Y-m-d'),
                   'created_by' => Auth::user()->id
                 ]
              );
              $question_data = array();
              $totalMarks = 0;
              $totalQuestion = 0;
              foreach ($value['question'] as $questionValue) {
                  $totalQuestion++;
                  $totalMarks += $questionValue['marks'];
                  $question_data[] = array(
                    "exam_id" => $exam_id,
                    "question_detail" => $questionValue['question_detail'],
                    "question_type_id" => $questionValue['questiontype_id'],
                    "marks" => $questionValue['marks'],
                    "time" => $questionValue['time'],
                    "sub_answer" => $questionValue['explained_answer'],
                    "obj_question" => $questionValue['objective_question'],
                    "obj_answer" => $questionValue['objective_answer'],
                    "file_name" => "",
                  );
              }
              $exam_questions = DB::table('exam_questions')->insert($question_data);
              $exam = DB::table('exam')->where('id',$exam_id)->update(['total_marks'=>$totalMarks,'total_question'=>$totalQuestion]);
        }

        return back()->with('success', 'Sheet Imported successfully.');
    }


    private function checkExamStatus($exam_id){
        $examStatus = [
          "exam_section" => [
            "status" => true,
            "msg" => "Exam section is not created"
          ],
          "section_question" => [
            "status" => true,
            "msg" => "Section Question is not created"
          ],
          "question_detail" => [
            "status" => true,
            "msg" => "Question Detail is not completed"
          ],
          "question_option" => [
            "status" => true,
            "msg" => "Question option is not created"
          ]
        ];
        $exam_languages = DB::table("exam_languages")->select("language_id")->where("exam_id",$exam_id)->get();

        $exam_section = DB::table("exam_sections")->where("exam_id",$exam_id)->get();
        if($exam_section!="" && !count($exam_section)){
          $examStatus['exam_section']['status'] = false;
          $examStatus['section_question']['status'] = false;
          $examStatus['question_detail']['status'] = false;
          $examStatus['question_option']['status'] = false;
        }else{
          foreach ($exam_section as $key => $value) {
            $section_question = DB::table("exam_questions")->where("exam_id",$exam_id)->where('section_id',$value->id)->get();
            if($section_question != "" && !count($section_question)){
              $examStatus['section_question']['status'] = false;
              $examStatus['question_detail']['status'] = false;
              $examStatus['question_option']['status'] = false;
              break;
            }else{
              foreach ($section_question as $qkey => $qvalue) {
                foreach ($exam_languages as $lkey => $lvalue) {
                  $question_detail = DB::table("question_details")->where('question_id',$qvalue->id)->where('question_language_id',$lvalue->language_id)->first();
                  if(!isset($question_detail->id)){
                    $examStatus['question_detail']['status'] = false;
                    $examStatus['question_option']['status'] = false;
                    break;
                  }else{
                    if($qvalue->question_type_id == 2){
                      $question_options = DB::table("question_options")->where('question_details_id',$question_detail->id)->get();
                      if($question_options != "" && !count($question_options)){
                        $examStatus['question_option']['status'] = false;
                      }
                    }
                  }
                }
              }

            }
          }
        }
        return $examStatus;
    }

    private function checkSectionStatus($exam_id,$section_id){
        $examStatus = [
          "section_question" => [
            "status" => true,
            "msg" => "Section Question is not created"
          ],
          "question_detail" => [
            "status" => true,
            "msg" => "Question Detail is not completed"
          ],
          "question_option" => [
            "status" => true,
            "msg" => "Question option is not created"
          ]
        ];
        $exam_languages = DB::table("exam_languages")->select("language_id")->where("exam_id",$exam_id)->get();

        $exam_section = DB::table("exam_sections")->where("exam_id",$exam_id)->where('id',$section_id)->first();
        if($exam_section !="" && !isset($exam_section->id)){
          $examStatus['exam_section']['status'] = false;
          $examStatus['section_question']['status'] = false;
          $examStatus['question_detail']['status'] = false;
          $examStatus['question_option']['status'] = false;
        }else{
          // foreach ($exam_section as $key => $value) {
            $section_question = DB::table("exam_questions")->where("exam_id",$exam_id)->where('section_id',$section_id)->get();
            if($section_question != "" && !count($section_question)){
              $examStatus['section_question']['status'] = false;
              $examStatus['question_detail']['status'] = false;
              $examStatus['question_option']['status'] = false;
            }else{
              foreach ($section_question as $qkey => $qvalue) {
                foreach ($exam_languages as $lkey => $lvalue) {
                  $question_detail = DB::table("question_details")->where('question_id',$qvalue->id)->where('question_language_id',$lvalue->language_id)->first();
                  if(!isset($question_detail->id)){
                    $examStatus['question_detail']['status'] = false;
                    $examStatus['question_option']['status'] = false;
                    break;
                  }else{
                    if($qvalue->question_type_id == 2){
                      $question_options = DB::table("question_options")->where('question_details_id',$question_detail->id)->get();
                      if($question_options != "" && !count($question_options)){
                        $examStatus['question_option']['status'] = false;
                      }
                    }
                  }
                }
              }

            }
          // }
        }
        return $examStatus;
    }

    private function checkQuestionsStatus($exam_id,$section_id,$question_id){
        $examStatus = [
          "question_detail" => [
            "status" => true,
            "msg" => "Question Detail is not completed"
          ],
          "question_option" => [
            "status" => true,
            "msg" => "Question option is not created"
          ]
        ];
        $exam_languages = DB::table("exam_languages")->select("language_id")->where("exam_id",$exam_id)->get();

        $exam_section = DB::table("exam_sections")->where("exam_id",$exam_id)->where('id',$section_id)->first();
        if($exam_section !="" && !isset($exam_section->id)){
          $examStatus['exam_section']['status'] = false;
          $examStatus['section_question']['status'] = false;
          $examStatus['question_detail']['status'] = false;
          $examStatus['question_option']['status'] = false;
        }else{
          // foreach ($exam_section as $key => $value) {
            $section_question = DB::table("exam_questions")->where("exam_id",$exam_id)->where('section_id',$section_id)->where('id',$question_id)->first();
            if($section_question != "" && !isset($section_question->id)){
              $examStatus['section_question']['status'] = false;
              $examStatus['question_detail']['status'] = false;
              $examStatus['question_option']['status'] = false;
            }else{
              // foreach ($section_question as $qkey => $qvalue) {
                foreach ($exam_languages as $lkey => $lvalue) {
                  $question_detail = DB::table("question_details")->where('question_id',$section_question->id)->where('question_language_id',$lvalue->language_id)->first();
                  if(!isset($question_detail->id)){
                    $examStatus['question_detail']['status'] = false;
                    $examStatus['question_option']['status'] = false;
                    break;
                  }else{
                    if($section_question->question_type_id == 2){
                      $question_options = DB::table("question_options")->where('question_details_id',$question_detail->id)->get();
                      if($question_options != "" && !count($question_options)){
                        $examStatus['question_option']['status'] = false;
                      }
                    }
                  }
                }
              // }

            }
          // }
        }
        return $examStatus;
    }

}

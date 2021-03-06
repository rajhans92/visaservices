<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Hash;
use Auth;

class UncheckPaperController extends Controller
{
    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('uncheck_paper_access')) {
            return abort(401);
        }


        $queryExam = DB::table('exam_schedule')
                      ->select('exam_schedule.id AS id','exam_schedule.exam_id AS exam_id','exam_schedule.exam_display_name AS exam_display_name','exam_schedule.start_date AS start_date','exam_schedule.end_date As end_date','exam_schedule.result_date AS result_date','exam_schedule.user_limit AS user_limit','users.first_name AS first_name','users.last_name AS last_name','exam.exam_name AS exam_name')
                      ->join('exam', 'exam.id', '=', 'exam_schedule.exam_id')
                      ->join('users', 'users.id', '=', 'exam_schedule.sponsored_by')
                      ->where('exam_schedule.end_date','<',date('Y-m-d h:i:s'))
                      ->where('exam_schedule.result_date','>=',date('Y-m-d h:i:s'))
                      ->where('exam_schedule.is_result','=',0);

        if(Auth::user()->role_id != 1 && Auth::user()->role_id != 4){
            $queryExam->where(function($query) {
              return $query->orWhere(['exam.created_by' => Auth::user()->id, 'exam.organization_id' => Auth::user()->id,'exam.teacher_id'=>Auth::user()->id]);
            });
        }
        $exam_schedule = $queryExam->get();

        foreach ($exam_schedule as $key => $value) {
          $total_paper_checked_obj = DB::select(DB::raw('SELECT is_checked, COUNT(is_checked) AS count FROM exam_registered_users_'.$value->id.' GROUP BY is_checked'));
          $value->total_paper_checked = 0;
          $value->total_paper_count = 0;
          foreach ($total_paper_checked_obj as $val) {
              $value->total_paper_count += $val->count;
              if($val->is_checked == 1){
                $value->total_paper_checked = $val->count;
              }
          }
        }


        return view('admin.uncheck-paper.index', compact('exam_schedule'));
    }


    /**
     * Show the form for editing User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function paperChecking(Request $request)
    {
        if (! Gate::allows('uncheck_paper_edit')) {
            return abort(401);
        }
        $user_id = $request->user_id;
        $exam_id = $request->exam_id;
        $exam_schedule_id = $request->exam_schedule_id;

        $show_papers = DB::table('exam_submit_papers_'.$exam_schedule_id)
                      ->where('exam_submit_papers_'.$exam_schedule_id.'.user_id','=',$user_id)
                      ->where('exam_submit_papers_'.$exam_schedule_id.'.exam_schedule_id','=',$exam_schedule_id)
                      ->get();

        $examDetail = DB::table('exam')
                      ->where('id',$exam_id)
                      ->first();

        $userDetail = DB::table('users')
                      ->where('id',$user_id)
                      ->first();

        $user_name = $userDetail->first_name.' '.$userDetail->last_name;
        $exam_name = $examDetail->exam_name;

        $question_type = DB::table('question_type')
                ->select('id','title')
                ->get();

        $questionType = array();
        foreach ($question_type as $key => $value) {
          $questionType[$value->id] = $value->title;
        }
        $languages = DB::table("languages")
                  ->select('id','title')
                  ->where("status","=",2)
                  ->get();
        $languagesType = array();
        foreach ($languages as $key => $value) {
          $languagesType[$value->id] = $value->title;
        }
        $optionLabelQuery = DB::table("option_label")
                  ->select('id','title')
                  ->where("status","=",2)
                  ->get();
        $optionLabel = [];
        foreach ($optionLabelQuery as $key => $value) {
          $optionLabel[$value->id] = $value->title;
        }
        $htmlString = '<div id="tabs">';
        $htmlSection ='<ul>';
        $htmlData = '';
        $show_papers_data = [];
        foreach ($show_papers as $key => $value) {
          $show_papers_data[$value->section_id][] =  $value;
        }
        foreach ($show_papers_data as $sectionId => $submitData) {
          $examSectionQuery = DB::table('exam_sections')
                        ->where('exam_id',$exam_id)
                        ->where('id',$sectionId)
                        ->first();
          $htmlSection .= '<li><a href="#tabs-'.$sectionId.'">'.$examSectionQuery->section_name.' ('.count($show_papers_data[$sectionId]).' Questions)</a></li>';
          $htmlData .= '<div id="tabs-'.$sectionId.'">';
          $questinData = '';
          $count = 1;
          foreach ($submitData as $key => $value) {
            $examQuestionQuery = DB::table('exam_questions')
                          ->where('exam_id',$exam_id)
                          ->where('id',$value->question_id)
                          ->first();
            $n_marking = 0;
            if($examSectionQuery->is_negative_marking == '1'){
              $n_marking = $examSectionQuery->negative_marking_no;
            }elseif($examDetail->is_negative_marking == "1"){
              $n_marking = $examDetail->negative_marking_no;
            }

            $questinData .= '<details class="parent_detail">';
            $questinData .= '<summary class="parent_summary"><b>Question '.$count++.' :- </b>'.$questionType[$examQuestionQuery->question_type_id].' , '.$examQuestionQuery->question_marks.' Marks, -'.$n_marking.' negative, '.($value->is_checked ? "<b class='checked is_checked_label_".$value->question_id."'>Checked</b>" : "<b class='unchecked is_checked_label_".$value->question_id."'>Unchecked</b>").' --> Answer = '.($value->is_checked ? $value->is_correct ? "<b class='checked is_correct_label_".$value->question_id."'>Correct</b>" :"<b class='unchecked is_correct_label_".$value->question_id."'>Wrong</b>"   : "<b class='unchecked is_correct_label_".$value->question_id."'>NA</b>").'</summary>';

            $examQuestionDetailQuery = DB::table('question_details')
                          ->where('question_id',$examQuestionQuery->id)
                          ->get();

            $questByLang = '';
            foreach ($examQuestionDetailQuery as $keyDetail => $valueDetail) {
              $questByLang .= '<details class="child_detail">';
              $questByLang .= '<summary>'.$languagesType[$valueDetail->question_language_id].'</summary>';
              $questByLang .= '<div class="details_content"><p>'.$valueDetail->paragraph_detail.'</p><br>';
              if($valueDetail->paragraph_file != ""){
                $questByLang .= '<p><b>File :- </b><a href="'.env('IMG_URL').'/img/exam/'.$exam_id.'/'.$sectionId.'/'.$examQuestionQuery->id.'/'.$valueDetail->paragraph_file.'" target="_blank">click</a></p>';
              }
              if($valueDetail->paragraph_image != ""){
                $questByLang .= '<p><b>Image :- </b><img src="'.env('IMG_URL').'/img/exam/'.$exam_id.'/'.$sectionId.'/'.$examQuestionQuery->id.'/'.$valueDetail->paragraph_image.'" height="100" width="100" /></p>';
              }
              $questByLang .= '<p>'.$valueDetail->question_detail.'</p>';
              if($valueDetail->question_file != ""){
                $questByLang .= '<p><b>File :-</b> <a href="'.env('IMG_URL').'/img/exam/'.$exam_id.'/'.$sectionId.'/'.$examQuestionQuery->id.'/'.$valueDetail->question_file.'" target="_blank">click</a></p>';
              }
              if($valueDetail->question_image != ""){
                $questByLang .= '<p><b>Image :- </b><img src="'.env('IMG_URL').'/img/exam/'.$exam_id.'/'.$sectionId.'/'.$examQuestionQuery->id.'/'.$valueDetail->question_image.'" height="100" width="100" /></p><br>';
              }
              if($examQuestionQuery->question_type_id ==2){
                $examQuestionDetailLabelQuery = DB::table('question_options')
                              ->where('question_details_id',$valueDetail->id)
                              ->get();

                $examQuestionDetailLabel = '';
                $correct = '<p><b>Correct Answer :- </b>';
                foreach ($examQuestionDetailLabelQuery as $keyOption => $valueOption) {
                  $examQuestionDetailLabel .= '<p> <b>'.$optionLabel[$valueOption->option_label_id].'.</b> '.$valueOption->option_value;
                    if($valueOption->option_image != ""){
                      $img = '<img src="'.env('IMG_URL').'/img/exam/'.$exam_id.'/'.$sectionId.'/'.$examQuestionQuery->id.'/'.$valueOption->option_image.'" height="50" width="50" />';
                      $examQuestionDetailLabel .= $img;
                    }
                    $examQuestionDetailLabel .= '</p>';
                    if($valueOption->is_option_correct){
                      $correct .= $optionLabel[$valueOption->option_label_id].', ';
                    }
                }
                $correct = trim($correct,", ");
                $questByLang .= $examQuestionDetailLabel.$correct.'</p><p><b>Objective answer by user :- </b>'.$optionLabel[$value->option_label_id].'</p>';
              }elseif($examQuestionQuery->question_type_id ==1){
                $questByLang .= '<p><b>Subjective answer by user :- </b>'.$value->sub_answer.'</p>';
              }
              $questByLang .= '<p><b>Answer Explained :- </b>'.$valueDetail->answer_detail.'</p>';
              $questByLang .= '</div></details>';

            }
            $questByLang .= '<br><div class="row"> <div class="col-xs-3 form-group"><label for="isCorrect'.$value->question_id.'" class="control-label">Answer Is Correct?</label> <select class="form-control" id="isCorrect'.$value->question_id.'" name="is_correct"><option value="1" '.($value->is_correct==1?"selected":"").'>Correct</option> <option value="0" '.($value->is_correct==0?"selected":"").'>Wrong</option> </select> </div> <div class="col-xs-3 form-group"> <label for="isChecked'.$value->question_id.'" class="control-label">Answer Is Checked?</label><select class="form-control" id="isChecked'.$value->question_id.'" name="is_checked"> <option value="0" '.($value->is_checked==0?"selected":"").'>Uncheck</option> <option value="1" '.($value->is_checked==1?"selected":"").'>Checked</option> </select> </div> <div class="col-xs-3 form-group"><label for="question_note'.$value->question_id.'" class="control-label">Teacher Notes</label> <input type="text" height= "100px" id="question_note'.$value->question_id.'"  class="form-control" value="'.$value->teacher_note.'"> </div> <div class="col-xs-3 form-group"><input class="btn btn-xm btn-danger submitBtn" data-id="'.$value->question_id.'" data-section="'.$sectionId.'" type="button" style="margin-top:26px;" value="Submit Result"> </div> </div>';
            $questinData .= $questByLang.'</details>';
          }
          $htmlData .= $questinData.'</div>';
        }
        $htmlSection .= '</ul>';
        $htmlString .= $htmlSection.$htmlData.'</div>';
        // exit(print_r($examSection));
        return view('admin.uncheck-paper.edit', compact('exam_schedule_id','exam_id','user_id','htmlString','exam_name','user_name'));
    }

    /**
     * Update User in storage.
     *
     * @param  \App\Http\Requests\UpdateUsersRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function updatePaper(Request $request){
       $responsedata = array("error" => true, "msg" => "Unable to update");

       if (! Gate::allows('exam_schedule_edit')) {
           return json_encode($responsedata);
       }
       // exit(print_r($request->all()));
       $section_id = $request->section_id;

       $table = 'exam_submit_papers_'.$request->exam_schedule_id;
       $data = DB::table($table)
               ->where($table.'.section_id', $request->section_id)
               ->where($table.'.question_id', $request->id)
               ->where($table.'.user_id', $request->user_id)
               ->first();

        $correct_ans = $request->is_correct;
        if($request->is_checked == 0)
          $correct_ans = 0;

       $quetionData = array(
         "is_correct" => $correct_ans,
         "is_checked" => $request->is_checked,
         "teacher_note" => $request->question_note,
         "updated_at" => date("Y-m-d h:i:s"),
         "updated_by" => Auth::user()->id
       );
       DB::table('exam_submit_papers_'.$request->exam_schedule_id)->where('section_id', $request->section_id)->where('question_id', $request->id)->where('user_id', $request->user_id)->limit(1)
       ->update($quetionData);

       if($data->is_correct == $request->is_correct && $data->is_checked == $request->is_checked){
         $responsedata["error"] = false;
         $responsedata["msg"] = "Data successfully updated";
         return json_encode($responsedata);
       }
       $exam_schedule = DB::table('exam_schedule')
                     ->select('is_negative_marking','negative_marking_no')
                     ->join('exam', 'exam.id', '=', 'exam_schedule.exam_id')
                     ->where('exam_schedule.id','=',$request->exam_schedule_id)
                     ->first();

      $exam = DB::table('exam')
                     ->where('id','=',$request->exam_id)
                     ->first();

       $exam_section = DB::table('exam_sections')
                    ->where('id','=',$request->section_id)
                    ->first();

        $exam_question = DB::table('exam_questions')
                     ->where('section_id', $request->section_id)
                     ->where('id',$request->id)
                     ->first();
       $user_exam = DB::table('exam_registered_users_'.$request->exam_schedule_id)
                     ->select('marks_get','correct_ans','wrong_ans')
                     ->where('user_id','=',$request->user_id)
                     ->first();

       if($data->is_checked != 1 && $request->is_checked == 1 && $request->is_correct == 1){
          $user_exam->marks_get += $exam_question->question_marks;
          $user_exam->correct_ans++;
       }

       if($data->is_checked != 1 && $request->is_checked == 1 && $request->is_correct == 2){

           if($exam_section->is_negative_marking == 1){
             $user_exam->marks_get -= $exam_section->negative_marking_no;
           }elseif($exam->is_negative_marking == 1){
             $user_exam->marks_get -= $exam->negative_marking_no;
           }
          $user_exam->wrong_ans++;
       }

       if($data->is_checked == 1 && $request->is_checked != 1 && $data->is_correct == 1){
          $user_exam->marks_get -= $exam_question->question_marks;
          $user_exam->correct_ans--;
       }

       if($data->is_checked == 1 && $request->is_checked != 1 && $data->is_correct == 2){
          if($exam_section->is_negative_marking == 1){
            $user_exam->marks_get += $exam_section->negative_marking_no;
          }elseif($exam->is_negative_marking == 1){
            $user_exam->marks_get += $exam->negative_marking_no;
          }

          $user_exam->wrong_ans--;
       }

       if($data->is_checked == 1 && $request->is_checked == 1 && $data->is_correct == 1 && $request->is_correct == 2){

          $user_exam->marks_get -= $exam_question->question_marks;

           if($exam_section->is_negative_marking == 1){
             $user_exam->marks_get -= $exam_section->negative_marking_no;
           }elseif($exam->is_negative_marking == 1){
             $user_exam->marks_get -= $exam->negative_marking_no;
           }

          $user_exam->correct_ans--;
          $user_exam->wrong_ans++;
       }

       if($data->is_checked == 1 && $request->is_checked == 1 && $data->is_correct == 2 && $request->is_correct == 1){
            $user_exam->marks_get += $exam_question->question_marks;

            if($exam_section->is_negative_marking == 1){
              $user_exam->marks_get += $exam_section->negative_marking_no;
            }elseif($exam->is_negative_marking == 1){
              $user_exam->marks_get += $exam->negative_marking_no;
            }

            $user_exam->correct_ans++;
            $user_exam->wrong_ans--;
       }


       $userData = array(
         "marks_get" => $user_exam->marks_get,
         "correct_ans" => $user_exam->correct_ans,
         "wrong_ans" => $user_exam->wrong_ans
       );
       DB::table('exam_registered_users_'.$request->exam_schedule_id)->where('user_id','=',$request->user_id)->limit(1)
       ->update($userData);

       $responsedata["error"] = false;
       $responsedata["msg"] = "Data successfully updated";
       return json_encode($responsedata);
     }

    public function update(Request $request, $id){

    }


    /**
     * Display User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('uncheck_paper_view')) {
            return abort(401);
        }
        $tableName = 'exam_registered_users_'.$id;
        $user_exam = DB::table($tableName)
                      ->select($tableName.'.id AS id',$tableName.'.user_id AS user_id',
                      $tableName.'.exam_schedule_id AS exam_schedule_id',
                      $tableName.'.exam_review AS exam_review',
                      $tableName.'.is_checked AS is_checked',
                      $tableName.'.marks_get AS marks_get',
                      $tableName.'.correct_ans AS correct_ans',
                      $tableName.'.wrong_ans AS wrong_ans',
                      $tableName.'.attempt_questions AS attempt_questions',
                      $tableName.'.non_attempt_questions AS non_attempt_questions',
                      $tableName.'.total_questions AS total_questions',
                      $tableName.'.total_marks AS total_marks',
                      'users.first_name AS first_name',
                      'users.last_name AS last_name')
                      ->join('users', 'users.id', '=', $tableName.'.user_id')
                      ->get();

        $exam_schedule = DB::table('exam_schedule')
                      ->select('exam_id','total_marks','total_questions','is_negative_marking','negative_marking_no')
                      ->join('exam', 'exam.id', '=', 'exam_schedule.exam_id')
                      ->where('exam_schedule.id','=',$id)
                      ->first();

        foreach ($user_exam as $value) {
              $value->question_checked = DB::table('exam_submit_papers_'.$value->exam_schedule_id)
                            ->where('user_id','=',$value->user_id)
                            ->where('is_checked',"=",1)
                            ->count();
              $value->question_attempt = DB::table('exam_submit_papers_'.$value->exam_schedule_id)
                            ->where('user_id','=',$value->user_id)
                            ->count();
        }

        return view('admin.uncheck-paper.userSubmitList', compact('user_exam','exam_schedule'));
    }


    /**
     * Remove User from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function isChecked(Request $request){

      if (! Gate::allows('uncheck_paper_checked')) {
          return abort(401);
      }
      // exit(print_r($request->all()));
      $paper =  DB::table('exam_submit_papers_'.$request->exam_schedule_id)
                  ->where('exam_submit_papers_'.$request->exam_schedule_id.'.user_id','=',$request->user_id)
                  ->where('exam_submit_papers_'.$request->exam_schedule_id.'.exam_schedule_id','=',$request->exam_schedule_id)
                  ->where('exam_submit_papers_'.$request->exam_schedule_id.'.is_checked','=',0)
                  ->count();
      if( $paper > 0){
        return redirect('admin/uncheck-paper/'.$request->exam_schedule_id)->with('error','All Question should be checked first!');
      }

      DB::table('exam_registered_users_'.$request->exam_schedule_id)->where('id', $request->userExamId)->limit(1)
      ->update(array('is_checked' => $request->is_checked));

      return redirect('admin/uncheck-paper/'.$request->exam_schedule_id)->with('success','Paper status updated.');
    }

    public function examMove(Request $request){
          if (! Gate::allows('uncheck_paper_checked')) {
              return abort(401);
          }
          // exit(print_r($request->all()));
          $paper =  DB::table('exam_registered_users_'.$request->exam_schedule_id)
                      ->where('exam_registered_users_'.$request->exam_schedule_id.'.is_checked','=',0)
                      ->count();

          if( $paper > 0){
            return redirect('admin/uncheck-paper')->with('error','All Paper should be checked first!');
          }
          DB::table('exam_schedule')->where('id', $request->exam_schedule_id)->limit(1)
          ->update(array('is_result' => $request->is_result,'updated_at'=>date("Y-m-d h:i:s"),'updated_by'=>Auth::user()->id));

          return redirect('admin/uncheck-paper')->with('success','Exam Move to Result Section');
    }

    public function showPaper(Request $request)
    {
        if (! Gate::allows('uncheck_paper_view')) {
            return abort(401);
        }
        $user_id = $request->user_id;
        $exam_id = $request->exam_id;
        $exam_schedule_id = $request->exam_schedule_id;

        $show_papers = DB::table('exam_submit_papers_'.$exam_schedule_id)
                      ->where('exam_submit_papers_'.$exam_schedule_id.'.user_id','=',$user_id)
                      ->where('exam_submit_papers_'.$exam_schedule_id.'.exam_schedule_id','=',$exam_schedule_id)
                      ->get();

        $examDetail = DB::table('exam')
                      ->where('id',$exam_id)
                      ->first();

        $question_type = DB::table('question_type')
                ->select('id','title')
                ->get();

        $questionType = array();
        foreach ($question_type as $key => $value) {
          $questionType[$value->id] = $value->title;
        }
        $languages = DB::table("languages")
                  ->select('id','title')
                  ->where("status","=",2)
                  ->get();
        $languagesType = array();
        foreach ($languages as $key => $value) {
          $languagesType[$value->id] = $value->title;
        }
        $optionLabelQuery = DB::table("option_label")
                  ->select('id','title')
                  ->where("status","=",2)
                  ->get();
        $optionLabel = [];
        foreach ($optionLabelQuery as $key => $value) {
          $optionLabel[$value->id] = $value->title;
        }
        $htmlString = '<div id="tabs">';
        $htmlSection ='<ul>';
        $htmlData = '';
        $show_papers_data = [];
        $show_papers_section_data = [];
        foreach ($show_papers as $key => $value) {
          $show_papers_data[$value->section_id][] =  $value;
        }
        foreach ($show_papers_data as $sectionId => $submitData) {
          $examSectionQuery = DB::table('exam_sections')
                        ->where('exam_id',$exam_id)
                        ->where('id',$sectionId)
                        ->first();
          $htmlSection .= '<li><a href="#tabs-'.$sectionId.'">'.$examSectionQuery->section_name.' ('.count($show_papers_data[$sectionId]).' Questions)</a></li>';
          $htmlData .= '<div id="tabs-'.$sectionId.'">';
          $questinData = '';
          $count = 1;
          $show_papers_section_data[$sectionId]['section_name']        = $examSectionQuery->section_name;
          $show_papers_section_data[$sectionId]['total_marks']         = $examSectionQuery->total_marks;
          $show_papers_section_data[$sectionId]['cutoff']              = $examSectionQuery->cutoff;
          $show_papers_section_data[$sectionId]['total_questions']     = $examSectionQuery->total_questions;
          $show_papers_section_data[$sectionId]['is_negative_marking'] = $examSectionQuery->is_negative_marking;
          $show_papers_section_data[$sectionId]['negative_marking_no'] = $examSectionQuery->negative_marking_no;
          $show_papers_section_data[$sectionId]['attempt_questions']   = count($submitData);
          $show_papers_section_data[$sectionId]['cutoff']              = $examSectionQuery->cutoff;
          $show_papers_section_data[$sectionId]['correct_ans']   = 0;
          $show_papers_section_data[$sectionId]['wrong_ans']   = 0;
          $show_papers_section_data[$sectionId]['total_marks']   = 0.00;

          foreach ($submitData as $key => $value) {
            $examQuestionQuery = DB::table('exam_questions')
                          ->where('exam_id',$exam_id)
                          ->where('id',$value->question_id)
                          ->first();
           $n_marking = 0;
           if($examSectionQuery->is_negative_marking == '1'){
             $n_marking = $examSectionQuery->negative_marking_no;
           }elseif($examDetail->is_negative_marking == "1"){
             $n_marking = $examDetail->negative_marking_no;
           }

           if($value->is_checked == 1 && $value->is_correct == 1){
             $show_papers_section_data[$sectionId]['correct_ans']   += 1;
             $show_papers_section_data[$sectionId]['total_marks']   += $examQuestionQuery->question_marks;

           }elseif($value->is_checked == 1 && $value->is_correct == 0){
             $show_papers_section_data[$sectionId]['wrong_ans']   += 1;

             if($examSectionQuery->is_negative_marking == '1'){
               $show_papers_section_data[$sectionId]['total_marks'] -= $examSectionQuery->negative_marking_no;
             }elseif($examDetail->is_negative_marking == "1"){
               $show_papers_section_data[$sectionId]['total_marks'] -= $examDetail->negative_marking_no;
             }
           }

            $questinData .= '<details class="parent_detail">';
            $questinData .= '<summary class="parent_summary"><b>Question '.$count++.' :- </b>'.$questionType[$examQuestionQuery->question_type_id].' , '.$examQuestionQuery->question_marks.' Marks, -'.$n_marking.' negative, '.($value->is_checked ? "<b class='checked is_checked_label_".$value->question_id."'>Checked</b>" : "<b class='unchecked is_checked_label_".$value->question_id."'>Unchecked</b>").' --> Answer = '.($value->is_checked ? $value->is_correct ? "<b class='checked is_correct_label_".$value->question_id."'>Correct</b>" :"<b class='unchecked is_correct_label_".$value->question_id."'>Wrong</b>"   : "<b class='unchecked is_correct_label_".$value->question_id."'>NA</b>").'</summary>';

            $examQuestionDetailQuery = DB::table('question_details')
                          ->where('question_id',$examQuestionQuery->id)
                          ->get();

            $questByLang = '';
            foreach ($examQuestionDetailQuery as $keyDetail => $valueDetail) {

              $questByLang .= '<details class="child_detail">';
              $questByLang .= '<summary>'.$languagesType[$valueDetail->question_language_id].'</summary>';
              $questByLang .= '<div class="details_content"><p>'.$valueDetail->paragraph_detail.'</p><br>';
              if($valueDetail->paragraph_file != ""){
                $questByLang .= '<p><b>File :- </b><a href="'.env('IMG_URL').'/img/exam/'.$exam_id.'/'.$sectionId.'/'.$examQuestionQuery->id.'/'.$valueDetail->paragraph_file.'" target="_blank">click</a></p>';
              }
              if($valueDetail->paragraph_image != ""){
                $questByLang .= '<p><b>Image :- </b><img src="'.env('IMG_URL').'/img/exam/'.$exam_id.'/'.$sectionId.'/'.$examQuestionQuery->id.'/'.$valueDetail->paragraph_image.'" height="100" width="100" /></p>';
              }
              $questByLang .= '<p>'.$valueDetail->question_detail.'</p>';
              if($valueDetail->question_file != ""){
                $questByLang .= '<p><b>File :-</b> <a href="'.env('IMG_URL').'/img/exam/'.$exam_id.'/'.$sectionId.'/'.$examQuestionQuery->id.'/'.$valueDetail->question_file.'" target="_blank">click</a></p>';
              }
              if($valueDetail->question_image != ""){
                $questByLang .= '<p><b>Image :- </b><img src="'.env('IMG_URL').'/img/exam/'.$exam_id.'/'.$sectionId.'/'.$examQuestionQuery->id.'/'.$valueDetail->question_image.'" height="100" width="100" /></p><br>';
              }
              if($examQuestionQuery->question_type_id ==2){
                $examQuestionDetailLabelQuery = DB::table('question_options')
                              ->where('question_details_id',$valueDetail->id)
                              ->get();

                $examQuestionDetailLabel = '';
                $correct = '<p><b>Correct Answer :- </b>';
                foreach ($examQuestionDetailLabelQuery as $keyOption => $valueOption) {
                  $examQuestionDetailLabel .= '<p> <b>'.$optionLabel[$valueOption->option_label_id].'.</b> '.$valueOption->option_value;
                    if($valueOption->option_image != ""){
                      $img = '<img src="'.env('IMG_URL').'/img/exam/'.$exam_id.'/'.$sectionId.'/'.$examQuestionQuery->id.'/'.$valueOption->option_image.'" height="50" width="50" />';
                      $examQuestionDetailLabel .= $img;
                    }
                    $examQuestionDetailLabel .= '</p>';
                    if($valueOption->is_option_correct){
                      $correct .= $optionLabel[$valueOption->option_label_id].', ';
                    }
                }
                $correct = trim($correct,", ");
                $questByLang .= $examQuestionDetailLabel.$correct.'</p><p><b>Objective answer by user :- </b>'.$optionLabel[$value->option_label_id].'</p>';
              }elseif($examQuestionQuery->question_type_id ==1){
                $questByLang .= '<p><b>Subjective answer by user :- </b>'.$value->sub_answer.'</p>';
              }
              $questByLang .= '<p><b>Answer Explained :- </b>'.$valueDetail->answer_detail.'</p>';
              $questByLang .= '</div></details>';

            }
            $questinData .= $questByLang.'</details>';
          }
          $htmlData .= $questinData.'</div>';
        }
        $htmlSection .= '</ul>';
        $htmlString .= $htmlSection.$htmlData.'</div>';
        // exit(print_r($examSection));

        $tableName = 'exam_registered_users_'.$exam_schedule_id;
        $user_exam = DB::table($tableName)
                      ->select($tableName.'.id AS id',$tableName.'.user_id AS user_id',
                      $tableName.'.exam_schedule_id AS exam_schedule_id',
                      $tableName.'.exam_review AS exam_review',
                      $tableName.'.is_checked AS is_checked',
                      $tableName.'.marks_get AS marks_get',
                      $tableName.'.correct_ans AS correct_ans',
                      $tableName.'.wrong_ans AS wrong_ans',
                      $tableName.'.attempt_questions AS attempt_questions',
                      $tableName.'.non_attempt_questions AS non_attempt_questions',
                      $tableName.'.total_questions AS total_questions',
                      $tableName.'.total_marks AS total_marks',
                      'users.first_name AS first_name',
                      'users.last_name AS last_name')
                      ->join('users', 'users.id', '=', $tableName.'.user_id')
                      ->where($tableName.'.user_id',$user_id)
                      ->first();

        return view('admin.uncheck-paper.showPaper',  compact('exam_schedule_id','exam_id','user_id','htmlString','user_exam','examDetail','show_papers_section_data'));

    }

    public function autocheckPaper(Request $request){

        if (! Gate::allows('uncheck_paper_checked')) {
            return abort(401);
        }
        // $exam_schedule = DB::table("exam_schedule")->where("id","=",$request->exam_schedule_id)->first();
        $question_set =array();

        $exam = DB::table('exam')->where("id","=",$request->exam_id)->first();
        $exam_section = DB::table('exam_sections')->where("exam_id","=",$request->exam_id)->get();

        foreach ($exam_section as $value) {
          $question_set[$value->id]['data'] = $value;
          $questions = DB::table('exam_questions')->where("section_id","=",$value->id)->get();
          foreach ($questions as $valueQuestion) {
            $question_set[$value->id][$valueQuestion->id]['data'] = $valueQuestion;
            $questionsDetail = DB::table('question_details')->where("question_id","=",$valueQuestion->id)->get();
            foreach ($questionsDetail as $valueDetail) {
                $questionsDetailOptions = DB::table('question_options')->where("question_details_id","=",$valueDetail->id)->get();
                foreach ($questionsDetailOptions as $valueOption) {
                  $question_set[$value->id][$valueQuestion->id][$valueOption->option_label_id] = $valueOption->is_option_correct;
                }
            }
          }
        }

        $anser_sheet = DB::table('exam_registered_users_'.$request->exam_schedule_id)->get();


        foreach ($anser_sheet as $value) {
            $uncheck_paper = DB::table('exam_submit_papers_'.$request->exam_schedule_id)->where("exam_id","=",$request->exam_id)->where("user_id","=",$value->user_id)->get();
            $total_marks = 0;
            $correct_ans = 0;
            $wrong_ans = 0;
            foreach ($uncheck_paper as $value1) {
                if($value1->question_type_id == 2 ){
                  $isCorrect = 0;
                  if(isset($question_set[$value1->section_id][$value1->question_id][$value1->option_label_id]) && $question_set[$value1->section_id][$value1->question_id][$value1->option_label_id] == 1){
                      $isCorrect = 1;
                      $correct_ans++;
                      $total_marks += $question_set[$value1->section_id][$value1->question_id]['data']->question_marks;
                    }else{
                      if($question_set[$value1->section_id]['data']->is_negative_marking == 1){

                        $total_marks -= $question_set[$value1->section_id]['data']->negative_marking_no;

                      }elseif($exam->is_negative_marking == 1){

                        $total_marks -= $exam->negative_marking_no;

                      }
                      $wrong_ans++;
                    }
                    DB::table('exam_submit_papers_'.$request->exam_schedule_id)->where("exam_id","=",$request->exam_id)->where("user_id","=",$value->user_id)->where("id","=",$value1->id)->update(['is_correct' => $isCorrect,"is_checked" => 1]);

                }elseif($value1->question_type_id == 1 && $value1->is_checked == 1){
                    if($value1->is_correct == 1){
                      $correct_ans++;
                      $total_marks += $question_set[$value1->section_id][$value1->question_id]['data']->question_marks;
                    }elseif($value1->is_correct == 2){

                      if($question_set[$value1->section_id]['data']->is_negative_marking == 1){

                        $total_marks -= $question_set[$value1->section_id]['data']->negative_marking_no;

                      }elseif($exam->is_negative_marking == 1){

                        $total_marks -= $exam->negative_marking_no;

                      }

                      $wrong_ans++;
                    }
                }
            }
            $userData = array(
              "marks_get" => $total_marks,
              "correct_ans" => $correct_ans,
              "wrong_ans" => $wrong_ans
            );
            DB::table('exam_registered_users_'.$request->exam_schedule_id)->where('user_id','=',$value->user_id)->limit(1)
            ->update($userData);
        }
        return redirect()->route('admin.uncheck-paper.index');

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

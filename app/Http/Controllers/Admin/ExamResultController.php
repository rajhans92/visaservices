<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Hash;
use Auth;

class ExamResultController extends Controller
{
    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
     public function index()
     {
         if (! Gate::allows('exam_result_access')) {
             return abort(401);
         }


         $queryExam = DB::table('exam_schedule')
                       ->select('exam_schedule.id AS id','exam_schedule.exam_id AS exam_id','exam_schedule.exam_display_name AS exam_display_name','exam_schedule.start_date AS start_date','exam_schedule.end_date As end_date','exam_schedule.result_date AS result_date','exam_schedule.user_limit AS user_limit','users.first_name AS first_name','users.last_name AS last_name','exam.exam_name AS exam_name')
                       ->join('exam', 'exam.id', '=', 'exam_schedule.exam_id')
                       ->join('users', 'users.id', '=', 'exam_schedule.sponsored_by')
                       ->where('exam_schedule.end_date','<=',date('Y-m-d h:i:s'))
                       ->where('exam_schedule.is_result','=',1);

         if(Auth::user()->role_id != 1 && Auth::user()->role_id != 4){
             $queryExam->where(function($query) {
               return $query->orWhere(['exam.created_by' => Auth::user()->id, 'exam.organization_id' => Auth::user()->id,'exam.teacher_id'=>Auth::user()->id]);
             });
         }

          $exam_schedule = $queryExam->get();

         $total_paper_count = array();
         foreach ($exam_schedule as $key => $value) {
             $total_paper_obj = DB::table('exam_registered_users_'.$value->id)->count();
             $total_paper_count[$value->id] = $total_paper_obj;
         }
         return view('admin.exam-result.index', compact('exam_schedule',"total_paper_count"));
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
    public function store(StoreOrganizationRequest $request)
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
    public function update(UpdateOrganizationRequest $request, $id)
    {

    }


    /**
     * Display User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      if (! Gate::allows('exam_result_view')) {
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
                    $tableName.'.rank AS rank',
                    $tableName.'.total_marks AS total_marks',
                    'users.first_name AS first_name',
                    'users.last_name AS last_name')
                    ->join('users', 'users.id', '=', $tableName.'.user_id')
                    ->orderBy('rank')
                    ->get();

      $exam_schedule = DB::table('exam_schedule')
                    ->select('exam_id','total_marks','total_questions','is_negative_marking','negative_marking_no')
                    ->join('exam', 'exam.id', '=', 'exam_schedule.exam_id')
                    ->where('exam_schedule.id','=',$id)
                    ->first();

      return view('admin.exam-result.userSubmitList', compact('user_exam','exam_schedule'));
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
          $show_papers_section_data[$sectionId]['marks_get']   = 0.00;

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
             $show_papers_section_data[$sectionId]['marks_get']   += $examQuestionQuery->question_marks;

           }elseif($value->is_checked == 1 && $value->is_correct == 0){
             $show_papers_section_data[$sectionId]['wrong_ans']   += 1;

             if($examSectionQuery->is_negative_marking == '1'){
               $show_papers_section_data[$sectionId]['marks_get'] -= $examSectionQuery->negative_marking_no;
             }elseif($examDetail->is_negative_marking == "1"){
               $show_papers_section_data[$sectionId]['marks_get'] -= $examDetail->negative_marking_no;
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

        return view('admin.exam-result.showPaper',  compact('exam_schedule_id','exam_id','user_id','htmlString','user_exam','examDetail','show_papers_section_data'));

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
    public function winnerList(Request $request){
      if (! Gate::allows('exam_result_view')) {
          return abort(401);
      }
      $id = $request->exam_schedule_id;
      $exam_schedule = DB::table('exam_schedule')
                    ->select('no_of_winner','exam_id','total_marks','total_questions')
                    ->join('exam', 'exam.id', '=', 'exam_schedule.exam_id')
                    ->where('exam_schedule.id','=',$id)
                    ->first();

      $tableName = 'exam_registered_users_'.$id;
      $user_exam = DB::table($tableName)
                    ->select($tableName.'.id AS id',$tableName.'.user_id AS user_id',
                    $tableName.'.exam_schedule_id AS exam_schedule_id',
                    $tableName.'.exam_review AS exam_review',
                    $tableName.'.marks_get AS marks_get',
                    $tableName.'.correct_ans AS correct_ans',
                    $tableName.'.wrong_ans AS wrong_ans',
                    $tableName.'.rank AS rank',
                    'users.first_name AS first_name',
                    'users.last_name AS last_name')
                    ->join('users', 'users.id', '=', $tableName.'.user_id')
                    ->where($tableName.'.exam_schedule_id','=',$id)
                    ->orderBy('rank','ASC')
                    ->limit($exam_schedule->no_of_winner)
                    ->get();

      return view('admin.exam-result.winnerList', compact('user_exam','exam_schedule'));
    }

    public function autoWinner(Request $request){
          $anser_sheet = DB::table('exam_registered_users_'.$request->exam_schedule_id)->orderBy('marks_get','desc')->orderBy('wrong_ans','asc')->get();
          $count = 1;
          $rankSet = [];
          foreach ($anser_sheet as $key => $value) {
            $rankSet[$value->marks_get][$value->wrong_ans][] = $value->id;

          }
          foreach ($rankSet as $value) {
              foreach ($value as $val) {
                DB::table('exam_registered_users_'.$request->exam_schedule_id)->whereIn('id',$val)
                ->update(['rank' => $count++]);// code...
              }
          }
          return redirect()->route('admin.exam-result.index');

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

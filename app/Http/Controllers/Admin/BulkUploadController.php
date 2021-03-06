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

class BulkUploadController extends Controller
{

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

    public function bulkUploadExam(Request $request){
        if (! Gate::allows('exam_create')) {
            return abort(401);
        }
        $this->validate($request, [
         'file_name'  => 'required|mimes:xls,xlsx'
        ]);

        $path = $request->file('file_name')->getRealPath();
        $data = Excel::load($path)->get()->toArray();
        // exit(print_r($data));
        if(count($data) != 5){
          return back()->with('error', 'Invalid Sheet - Exam sheet and Question Required!');
        }

        $examSheet = $data[0];
        $instructionSheet = $data[1];
        $sectionSheet = $data[2];
        $questionSheet = $data[3];
        $objectSheet = $data[4];
        $rowData = array();
        $examKeys = array('exam_name' => true, 'exam_language' => true,	'exam_category' => true	,'organization' => true ,'teacher' => true,'exam_duration' => true,'total_marks' => true, 'passing_marks' => true, 'total_questions' => true,'video_link' => true,'negative_marking' => true,'negative_marking_no' => false,'questions_type' => true,'submit_type' => true);
        $instructionKeys = array('exam_name' => true, 'language' => true,	'instruction' => true);

        $sectionKeys = array('exam_name' => true, 'section_name' => true,	'negative_marking' => true,	'negative_marking_no' => false	,'total_marks'  => true,'cutoff' => true,'total_questions' => true,'section_duration' => true, 'questions_type' => true, 'submit_type' => true);

        $questionKey = array('exam_name' => true, 'section_name' => true,'question_sequence' => true,'question_language' => true	,'questions_type' => true	,'submit_type' => true,'question_marks' => true,'question_duration' => true,'paragraph_detail' => false	,'question_detail' => true,'answer_detail' => true);

        $objectKey = array('exam_name' => true, 'section_name' => true,'question_sequence' => true	,'question_language' => true	,'option_label' => true	,'option_value' => true,'is_option_correct' => true);

        $returnData = array();
        $returnData = $this->keyValidation("exam",$examSheet,$examKeys,$rowData);
        if($returnData['status']){
          return back()->with('error', "exam ====> ".$returnData['msg']);
        }
        $rowData = $returnData['data'];

        $returnData = array();
        $returnData = $this->keyValidation("instruction",$instructionSheet,$instructionKeys,$rowData);
        if($returnData['status']){
          return back()->with('error', "instruction ====> ".$returnData['msg']);
        }
        $rowData = $returnData['data'];

        $returnData = array();
        $returnData = $this->keyValidation("section",$sectionSheet,$sectionKeys,$rowData);
        if($returnData['status']){
          return back()->with('error', "section ====> ".$returnData['msg']);
        }
        $rowData = $returnData['data'];

        $returnData = array();
        $returnData = $this->keyValidation("question",$questionSheet,$questionKey,$rowData);
        if($returnData['status']){
          return back()->with('error', "question ====> ".$returnData['msg']);
        }
        $rowData = $returnData['data'];

        $returnData = array();
        $returnData = $this->keyValidation("object",$objectSheet,$objectKey,$rowData);
        if($returnData['status']){
          return back()->with('error', "object ====> ".$returnData['msg']);
        }
        $rowData = $returnData['data'];
        // exit(print_r($rowData));
        // ---------------------------------------------------------------------------------------
        foreach($rowData as $key => $value){
              $exam_id = DB::table('exam')->insertGetId(
                  [
                   'exam_name' => $value['exam_name'],
                   'exam_duration' => $value['exam_duration'],
                   'exam_category_id' => $value['exam_category'],
                   'is_negative_marking' => $value['negative_marking'],
                   'negative_marking_no' => (isset($value['negative_marking_no']) && $value['negative_marking_no'] != "") ? $value['negative_marking_no'] : 0,
                   'video_link' => $value['video_link'],
                   'passing_marks' => $value['passing_marks'],
                   'total_questions' => $value['total_questions'],
                   'total_marks' => $value['total_marks'],
                   'organization_id' =>  $value['organization'],
                   'teacher_id' =>  $value['teacher'],
                   'submit_type' =>  $value['submit_type'],
                   'questions_type' =>  $value['questions_type'],
                   'file_name' => "",
                   'has_sections' =>  (isset($value['section']) && count($value['section']) ? 1 : 0),
                   'no_of_sections' =>  (isset($value['section']) && count($value['section']) ? count($value['section']) : 0),
                   'created_at' => date('Y-m-d'),
                   'created_by' => Auth::user()->id
                 ]
              );
              if($exam_id){
                $tempLang = explode(',',trim($value['exam_language']));
                $tempData = [];
                foreach ($tempLang as $keyLang => $valueLang) {
                  $tempData[] = ['language_id'=> $valueLang, "exam_id" => $exam_id];
                }
                DB::table('exam_languages')->insert($tempData);
                $tempData = [];
                foreach ($value['instruction'] as $keyInst => $valueInst) {
                  $tempData[] = ['language_id'=> $keyInst, "exam_id" => $exam_id,"exam_note"=>$valueInst];
                }
                DB::table('exam_instructions')->insert($tempData);
                foreach ($value['section'] as $keySection => $valueSection) {
                  $exam_section_id = DB::table('exam_sections')->insertGetId(
                                [
                                  "exam_id" => $exam_id,
                                  "section_name" => $valueSection['section_name'],
                                  "questions_type" =>$valueSection['questions_type'],
                                  "submit_type" =>$valueSection['submit_type'],
                                  "section_duration" =>$valueSection['section_duration'],
                                  "total_marks" =>$valueSection['total_marks'],
                                  "cutoff" =>$valueSection['cutoff'],
                                  "total_questions" =>$valueSection['total_questions'],
                                  "is_negative_marking" =>$valueSection['negative_marking'],
                                  "negative_marking_no" =>(isset($valueSection['negative_marking_no']) && $valueSection['negative_marking_no'] != "") ? $valueSection['negative_marking_no'] : 0
                                ]
                              );
                    if($exam_section_id){
                        foreach ($valueSection['question'] as $keyQuestion => $valueQuestion) {
                          $exam_section_question_id = DB::table('exam_questions')->insertGetId(
                                        [
                                          "exam_id" => $exam_id,
                                          "section_id" => $exam_section_id,
                                          "question_type_id" =>$valueQuestion['questions_type'],
                                          "answer_type_id" =>$valueQuestion['submit_type'],
                                          "question_marks" =>$valueQuestion['question_marks'],
                                          "question_duration" =>$valueQuestion['question_duration'],
                                          "question_sequence" =>$valueQuestion['question_sequence'],
                                        ]
                                      );
                          if($exam_section_question_id){
                            foreach ($valueQuestion['languages'] as $keyQuestionLang => $valueQuestionLang) {
                              $exam_section_question_detail_id = DB::table('question_details')->insertGetId(
                                            [
                                              "question_id" => $exam_section_question_id,
                                              "paragraph_detail" => $valueQuestionLang['paragraph_detail'],
                                              "question_detail" =>$valueQuestionLang['question_detail'],
                                              "answer_detail" =>$valueQuestionLang['answer_detail'],
                                              "question_language_id" =>$valueQuestionLang['question_language']
                                            ]
                                          );
                              if($exam_section_question_detail_id && count($valueQuestionLang['object'])){
                                $tempArr = [];
                                foreach ($valueQuestionLang['object'] as $keyQuestionObj => $valueQuestionObj) {
                                    $tempArr[] = [
                                        "question_details_id" => $exam_section_question_detail_id,
                                        "option_label_id" => $keyQuestionObj,
                                        "option_value" => $valueQuestionObj['option_value'],
                                        "is_option_correct" => $valueQuestionObj['is_option_correct'],
                                    ];
                                }
                                if(count($tempArr)){
                                  DB::table('question_options')->insert($tempArr);
                                }

                              }
                            }
                          }
                        }
                    }
                }
              }
        }

        return back()->with('success', 'Sheet Imported successfully.');

    }

    private function keyValidation($type,$sheetData,$requiredKey,$dataSet){
        $errorMsg = "";
        $errorStatus = false;
        foreach ($sheetData as $key => $value) {
          $totalMarks = 0;
          $totalQuestion = 0;
          $totalDuration = 0;
          $passingMarks = 0;
          foreach ($requiredKey as $keySet => $keySetData) {
            if($keySetData == true && !array_key_exists($keySet,$value)){
              $errorStatus = true;
              $errorMsg .= $keySet.' Key is missing in Exam sheet. <br>';
              continue;
            }
            if($keySetData == true && strval($value[$keySet]) != '0' && $value[$keySet] == ""){
              $errorStatus = true;
              $errorMsg .= $keySet.' Key is required in Exam sheet. <br>';
              continue;
            }
          }

          if($type == "exam"){
            if($this->isUniqueExamName($value['exam_name'])){
              $errorStatus = true;
              $errorMsg .= 'exam_name Key have invalid data ('.$value["exam_name"].'). <br>';
              continue;
            }
            if($this->isExamLangValid($value['exam_language'])){
              $errorStatus = true;
              $errorMsg .= 'exam_language Key have invalid data ('.$value["exam_language"].'). <br>';
              continue;
            }
            if($this->isExamCatValid($value['exam_category'])){
              $errorStatus = true;
              $errorMsg .= 'exam_category Key have invalid data ('.$value["exam_category"].'). <br>';
              continue;
            }
            if($this->isExamOrgValid($value['organization'])){
              $errorStatus = true;
              $errorMsg .= 'organization Key have invalid data ('.$value["organization"].'). <br>';
              continue;
            }
            if($this->isExamTecherValid($value['teacher'])){
              $errorStatus = true;
              $errorMsg .= 'teacher Key have invalid data ('.$value["teacher"].'). <br>';
              continue;
            }
            if($this->isExamNegTypeValid($value['negative_marking'])){
              $errorStatus = true;
              $errorMsg .= 'negative_marking Key have invalid data ('.$value["negative_marking"].'). <br>';
              continue;
            }
            if($this->isExamQuestTypeValid($value['questions_type'])){
              $errorStatus = true;
              $errorMsg .= 'questions_type Key have invalid data ('.$value["questions_type"].'). <br>';
              continue;
            }
            if($this->isExamSubmitTypeValid($value['submit_type'])){
              $errorStatus = true;
              $errorMsg .= 'submit_type Key have invalid data ('.$value["submit_type"].'). <br>';
              continue;
            }
            $dataSet[$value['exam_name']] = $value;
            $dataSet[$value['exam_name']]['instruction'] = [];
            $dataSet[$value['exam_name']]['section'] = [];
          }
          if($type == "instruction"){
            if(!in_array($value['language'],explode(",",trim($dataSet[$value['exam_name']]['exam_language'])))){
              $errorStatus = true;
              $errorMsg .= 'Exam Language Invalid. <br>';
              continue;
            }
            if(!array_key_exists($value['exam_name'],$dataSet)){
              $errorStatus = true;
              $errorMsg .= 'Exam name Invalid. <br>';
              continue;
            }
            $dataSet[$value['exam_name']]['instruction'][$value['language']] = $value['instruction'];
          }
          if($type == "section"){
            $totalMarks += $value['total_marks'];
            $totalQuestion += $value['total_questions'];
            $totalDuration += $value['section_duration'];
            $passingMarks += $value['cutoff'];
            if($dataSet[$value['exam_name']]['total_marks'] < $totalMarks){
              $errorStatus = true;
              $errorMsg .= 'section total marks must be less then exam marks. <br>';
              continue;
            }
            if($dataSet[$value['exam_name']]['total_questions'] < $totalQuestion){
              $errorStatus = true;
              $errorMsg .= 'section total questions must be less then exam questions. <br>';
              continue;
            }
            if($dataSet[$value['exam_name']]['exam_duration'] < $totalDuration){
              $errorStatus = true;
              $errorMsg .= 'section total duration must be less then exam duration. <br>';
              continue;
            }
            if($dataSet[$value['exam_name']]['passing_marks'] < $passingMarks){
              $errorStatus = true;
              $errorMsg .= 'section total duration must be less then exam duration. <br>';
              continue;
            }
            if($dataSet[$value['exam_name']]['questions_type'] != 0 && $dataSet[$value['exam_name']]['questions_type'] != $value['questions_type']){
              $errorStatus = true;
              $errorMsg .= 'section question type must be same as exam question type. <br>';
              continue;
            }
            if($dataSet[$value['exam_name']]['submit_type'] != 0 && $dataSet[$value['exam_name']]['submit_type'] != $value['submit_type']){
              $errorStatus = true;
              $errorMsg .= 'section submit type must be same as exam submit type. <br>';
              continue;
            }
            $dataSet[$value['exam_name']]['section'][$value['section_name']] = $value;
            $dataSet[$value['exam_name']]['section'][$value['section_name']]['question'] = [];
          }
          if($type == "question"){

            $dataSet[$value['exam_name']]['section'][$value['section_name']]['question'][$value['question_sequence']]['questions_type'] = $value['questions_type'];
            $dataSet[$value['exam_name']]['section'][$value['section_name']]['question'][$value['question_sequence']]['submit_type'] = $value['submit_type'];
            $dataSet[$value['exam_name']]['section'][$value['section_name']]['question'][$value['question_sequence']]['question_marks'] = $value['question_marks'];
            $dataSet[$value['exam_name']]['section'][$value['section_name']]['question'][$value['question_sequence']]['question_duration'] = $value['question_duration'];
            $dataSet[$value['exam_name']]['section'][$value['section_name']]['question'][$value['question_sequence']]['question_sequence'] = $value['question_sequence'];

            $dataSet[$value['exam_name']]['section'][$value['section_name']]['question'][$value['question_sequence']]['languages'][$value['question_language']]['paragraph_detail'] = $value['paragraph_detail'];
            $dataSet[$value['exam_name']]['section'][$value['section_name']]['question'][$value['question_sequence']]['languages'][$value['question_language']]['question_detail'] = $value['question_detail'];
            $dataSet[$value['exam_name']]['section'][$value['section_name']]['question'][$value['question_sequence']]['languages'][$value['question_language']]['answer_detail'] = $value['answer_detail'];
            $dataSet[$value['exam_name']]['section'][$value['section_name']]['question'][$value['question_sequence']]['languages'][$value['question_language']]['question_language'] = $value['question_language'];
            $dataSet[$value['exam_name']]['section'][$value['section_name']]['question'][$value['question_sequence']]['languages'][$value['question_language']]['object'] = [];

          }
          if($type == "object"){
            $dataSet[$value['exam_name']]['section'][$value['section_name']]['question'][$value['question_sequence']]['languages'][$value['question_language']]['object'][$value['option_label']]  = $value;
          }
        }
        return array("status" =>$errorStatus,"msg"=>$errorMsg,"data"=>$dataSet);
    }
    private function isUniqueExamName($examName){
      $status = false;
      $exam = DB::table("exam")->where("exam_name",$examName)->count();
      if($exam){
        $status = true;
      }
      return $status;
    }
    private function isExamLangValid($examLang){
      $langArr = explode(",",trim($examLang));
      $status = false;
      $langCount = DB::table("languages")->whereIn('id',$langArr)->where("status",2)->count();
      if($langCount != count($langArr)){
        $status = true;
      }
      return $status;
    }

    private function isExamCatValid($examCatId){
      $status = false;
      $exam = DB::table("exam_category")->where("id",$examCatId)->where("status",2)->count();
      if(!$exam){
        $status = true;
      }
      return $status;
    }

    private function isExamOrgValid($orgId){
      $status = false;
      $exam = DB::table("users")->where("id",$orgId)->where("role_id",5)->where("status",2)->count();
      if(!$exam){
        $status = true;
      }
      return $status;
    }

    private function isExamTecherValid($teacherId){
      $status = false;
      $exam = DB::table("users")->where("id",$teacherId)->where("role_id",2)->where("status",2)->count();
      if(!$exam){
        $status = true;
      }
      return $status;
    }

    private function isExamNegTypeValid($examNegType){
      $status = false;
      if(!in_array($examNegType,[0,1])){
        $status = true;
      }
      return $status;
    }

    private function isExamQuestTypeValid($typeId){
      $status = false;
      $exam = DB::table("question_type")->where("id",$typeId)->count();
      if($typeId !=0 && !$exam){
        $status = true;
      }
      return $status;
    }

    private function isExamSubmitTypeValid($examNegType){
      $status = false;
      if(!in_array(intval($examNegType),[0,1,2])){
        $status = true;
      }
      return $status;
    }
}

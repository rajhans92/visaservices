<?php
// Route::get('/', 'HomeController@index');


// Authentication Routes...
$this->get('verify-email/{token}', 'Auth\RegisterController@showVerifyScreen');
$this->get('/', 'Auth\LoginController@showLoginForm')->name('auth.login');
$this->get('login', 'Auth\LoginController@showLoginForm')->name('auth.login');
$this->post('login',  [
    'uses'          => 'Auth\LoginController@login',
    'middleware'    => 'checkstatus',
])->name('auth.login');
$this->post('logout', 'Auth\LoginController@logout')->name('auth.logout');

// Registration Routes...
// $this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('auth.register');
// $this->post('register', 'Auth\RegisterController@register')->name('auth.register');

// Change Password Routes...

// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('auth.password.reset');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('auth.password.reset');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset')->name('auth.password.reset');

Route::group(['middleware' => ['admin'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/', 'Admin\DashboardController@index');

    Route::get('change_password', 'Auth\ChangePasswordController@showChangePasswordForm')->name('auth.change_password');
    Route::patch('change_password', 'Auth\ChangePasswordController@changePassword')->name('auth.change_password');

    Route::resource('user-profile', 'Admin\UserProfileController');

    Route::resource('permissions', 'Admin\PermissionsController');
    Route::post('permissions_mass_destroy', ['uses' => 'Admin\PermissionsController@massDestroy', 'as' => 'permissions.mass_destroy']);
    Route::resource('roles', 'Admin\RolesController');
    Route::post('roles_mass_destroy', ['uses' => 'Admin\RolesController@massDestroy', 'as' => 'roles.mass_destroy']);
    Route::resource('org', 'Admin\OrganizationController');
    Route::post('org_update_status', ['uses' => 'Admin\OrganizationController@updateStatus', 'as' => 'org.update_status']);
    Route::resource('teacher', 'Admin\TeacherController');
    Route::post('teacher_update_status', ['uses' => 'Admin\TeacherController@updateStatus', 'as' => 'teacher.update_status']);
    Route::get('teacher/list/{exam_id}', 'Admin\TeacherController@getTeacherList');

    Route::resource('student', 'Admin\StudentController');
    Route::post('student_update_status', ['uses' => 'Admin\StudentController@updateStatus', 'as' => 'student.update_status']);

    Route::resource('subadmin', 'Admin\SubadminController');
    Route::post('subadmin_update_status', ['uses' => 'Admin\SubadminController@updateStatus', 'as' => 'subadmin.update_status']);


    Route::resource('exam', 'Admin\ExamController');
    Route::get('exam/instructions/{exam_id}', ['uses' => 'Admin\ExamController@showInstructionPage', 'as' => 'exam.showInstruction']);
    Route::post('exam/instructions/{exam_id}', ['uses' => 'Admin\ExamController@saveInstructionPage', 'as' => 'exam.saveInstruction']);

    Route::get('exam/section/{exam_id}', ['uses' => 'Admin\ExamController@showSection', 'as' => 'exam.showSection']);
    Route::post('exam/section/{exam_id}', ['uses' => 'Admin\ExamController@saveSection', 'as' => 'exam.saveSection']);
    Route::get('exam/section/add/{exam_id}', ['uses' => 'Admin\ExamController@addSection', 'as' => 'exam.addSection']);
    Route::get('exam/section/edit/{exam_id}/{section_id}', ['uses' => 'Admin\ExamController@editSection', 'as' => 'exam.editSection']);
    Route::put('exam/section/edit/{id}', ['uses' => 'Admin\ExamController@updateSection', 'as' => 'exam.updateSection']);
    Route::delete('exam/section/{section_id}',['uses' => 'Admin\ExamController@destroySection', 'as' => 'exam.destroySection']);
    Route::get('exam/question/{exam_id}/{section_id}', ['uses' => 'Admin\ExamController@showQuestions', 'as' => 'exam.showQuestion']);
    Route::get('exam/questions/sequence/{exam_id}/{section_id}', ['uses' => 'Admin\ExamController@questionSequence', 'as' => 'exam.questionSequence']);
    Route::post('exam/questions/sequence/{exam_id}/{section_id}', ['uses' => 'Admin\ExamController@saveQuestionSequence', 'as' => 'exam.saveQuestionSequence']);
    Route::get('exam/question/add/{exam_id}/{section_id}', ['uses' => 'Admin\ExamController@addQuestion', 'as' => 'exam.addQuestion']);
    Route::post('exam/question/add/{exam_id}/{section_id}', ['uses' => 'Admin\ExamController@saveQuestion', 'as' => 'exam.saveQuestion']);
    Route::get('exam/question/edit/{exam_id}/{section_id}/{question_id}', ['uses' => 'Admin\ExamController@editQuestion', 'as' => 'exam.editQuestion']);
    Route::post('exam/question/edit/{exam_id}/{section_id}/{question_id}', ['uses' => 'Admin\ExamController@updateQuestion', 'as' => 'exam.updateQuestion']);
    Route::get('exam/question-view/{exam_id}/{section_id}/{question_id}', ['uses' => 'Admin\ExamController@viewQuestion', 'as' => 'exam.viewQuestion']);
    Route::get('exam/question/option/edit/{exam_id}/{section_id}/{question_id}', ['uses' => 'Admin\ExamController@editOption', 'as' => 'exam.editOption']);
    Route::post('exam/question/option/edit/{exam_id}/{section_id}/{question_id}', ['uses' => 'Admin\ExamController@saveOption', 'as' => 'exam.saveOption']);
    Route::delete('exam/question/{question_id}',['uses' => 'Admin\ExamController@destroyQuestion', 'as' => 'exam.destroyQuestion']);

    Route::post('exam_update_status', ['uses' => 'Admin\ExamController@updateStatus', 'as' => 'exam.update_status']);


    Route::get('exam-excel/upload', 'Admin\ExamController@showUploadScreen');

    Route::resource('exam-category', 'Admin\ExamCategoryController');
    Route::post('exam_category_update_status', ['uses' => 'Admin\ExamCategoryController@updateStatus', 'as' => 'exam-category.update_status']);

    Route::resource('language', 'Admin\LanguageController');
    Route::post('language_update_status', ['uses' => 'Admin\LanguageController@updateStatus', 'as' => 'language.update_status']);

    Route::resource('exam-slider', 'Admin\ExamSliderController');
    Route::post('exam_slider_update_status', ['uses' => 'Admin\ExamSliderController@updateStatus', 'as' => 'exam-slider.update_status']);


    Route::get('list/exam-category', 'Admin\ExamCategoryController@onlyView');
    Route::get('list/org', 'Admin\OrganizationController@onlyView');
    Route::get('list/teacher', 'Admin\TeacherController@onlyView');


    Route::resource('exam-schedule', 'Admin\ExamScheduleController');
    Route::post('exam_schedule_update_status', ['uses' => 'Admin\ExamScheduleController@updateStatus', 'as' => 'exam-schedule.update_status']);

    Route::resource('exam-result', 'Admin\ExamResultController');
    Route::get('exam-result/show-paper/{exam_schedule_id}/{exam_id}/{user_id}', 'Admin\ExamResultController@showPaper');
    Route::post('autowinner', ['uses' => 'Admin\ExamResultController@autoWinner', 'as' => 'exam-result.autowinner']);
    Route::get('exam-result/winner-list/{exam_schedule_id}', 'Admin\ExamResultController@winnerList');

    Route::resource('uncheck-paper', 'Admin\UncheckPaperController');
    Route::post('uncheck_paper_is_checked', ['uses' => 'Admin\UncheckPaperController@isChecked', 'as' => 'uncheck-paper.is_checked']);
    Route::post('move_to_result', ['uses' => 'Admin\UncheckPaperController@examMove', 'as' => 'uncheck-paper.move_to_result']);
    Route::get('uncheck-paper/paper/{exam_schedule_id}/{exam_id}/{user_id}', ['uses' => 'Admin\UncheckPaperController@paperChecking', 'as' => 'uncheck-paper.uncheck_paper_checking']);

    Route::put('uncheck-paper/paper/{submit_question_id}', 'Admin\UncheckPaperController@updatePaper');
    Route::get('uncheck-paper/show-paper/{exam_schedule_id}/{exam_id}/{user_id}', 'Admin\UncheckPaperController@showPaper');
    Route::post('autocheck_paper', ['uses' => 'Admin\UncheckPaperController@autocheckPaper', 'as' => 'uncheck-paper.autocheck_paper']);

    Route::post('exam_excel_upload', ['uses' => 'Admin\BulkUploadController@bulkUploadExam', 'as' => 'exam.bulk_upload']);

});

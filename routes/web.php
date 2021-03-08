<?php
// Route::get('/', 'HomeController@index');

$this->get('/', 'Front\LandingController@index');
$this->get('/about', 'Front\AboutController@index');

// Authentication Routes...
$this->get('verify-email/{token}', 'Auth\RegisterController@showVerifyScreen');

$this->get('admin/login', 'Auth\LoginController@showLoginForm')->name('auth.login');
$this->post('admin/login',  [
    'uses'          => 'Auth\LoginController@login'
])->name('auth.login');

$this->get('admin/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('auth.password.reset');
$this->post('admin/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('auth.password.reset');
$this->get('admin/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('admin/password/reset', 'Auth\ResetPasswordController@reset')->name('auth.password.reset');
$this->post('admin/logout', 'Auth\LoginController@logout')->name('auth.logout');

Route::group(['middleware' => ['admin'], 'prefix' => 'admin', 'as' => 'admin.'], function () {

    Route::get('change_password', 'Auth\ChangePasswordController@showChangePasswordForm')->name('auth.change_password');
    Route::patch('change_password', 'Auth\ChangePasswordController@changePassword')->name('auth.change_password');
    Route::get('/', 'Admin\DashboardController@index');
    Route::get('/header-section', 'Admin\HeaderFooterController@index')->name('header.index');
    Route::get('/header-section/{menu_id}', 'Admin\HeaderFooterController@editHeader')->name('header.edit');
    Route::put('/header-section/{menu_id}', 'Admin\HeaderFooterController@updateHeader')->name('header.update');;

    Route::get('/footer-section', 'Admin\HeaderFooterController@footerList')->name('footer.index');
    Route::get('/footer-section/tags/{lang_id}', 'Admin\HeaderFooterController@footerTagEdit')->name('footer.tags');
    Route::put('/footer-section/tags/{lang_id}', 'Admin\HeaderFooterController@footerTagUpdate')->name('footer.tagsUpdate');
    Route::get('/footer-section/logo/{lang_id}', 'Admin\HeaderFooterController@footerLogoEdit')->name('footer.logo');
    Route::put('/footer-section/logo/{lang_id}', 'Admin\HeaderFooterController@footerLogoUpdate')->name('footer.logoUpdate');
    Route::get('/footer-section/office/{lang_id}', 'Admin\HeaderFooterController@footerOfficeEdit')->name('footer.office');
    Route::put('/footer-section/office/{lang_id}', 'Admin\HeaderFooterController@footerOfficeUpdate')->name('footer.officeUpdate');
    Route::get('/footer-section/social/{lang_id}', 'Admin\HeaderFooterController@footerSocialEdit')->name('footer.social');
    Route::get('/footer-section/disclaimer/{lang_id}', 'Admin\HeaderFooterController@footerDisclaimerEdit')->name('footer.disclaimer');
    Route::put('/footer-section/disclaimer/{lang_id}', 'Admin\HeaderFooterController@footerDisclaimerUpdate')->name('footer.disclaimerUpdate');
    Route::get('/footer-section/company/{lang_id}', 'Admin\HeaderFooterController@footerCompanyEdit')->name('footer.company');
    Route::put('/footer-section/company/{lang_id}', 'Admin\HeaderFooterController@footerCompanyUpdate')->name('footer.companyUpdate');

    // Route::resource('user-profile', 'Admin\UserProfileController');
    //
    // Route::resource('permissions', 'Admin\PermissionsController');
    // Route::post('permissions_mass_destroy', ['uses' => 'Admin\PermissionsController@massDestroy', 'as' => 'permissions.mass_destroy']);
    // Route::resource('roles', 'Admin\RolesController');
    // Route::post('roles_mass_destroy', ['uses' => 'Admin\RolesController@massDestroy', 'as' => 'roles.mass_destroy']);

});

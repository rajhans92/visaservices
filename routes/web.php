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

    Route::get('/country', 'Admin\CountryController@index')->name('country.index');
    Route::get('/country/add', 'Admin\CountryController@createCountry')->name('country.create');
    Route::post('/country/add', 'Admin\CountryController@storeCountry')->name('country.create');
    Route::get('/country/edit/{id}', 'Admin\CountryController@editCountry')->name('country.edit');
    Route::put('/country/edit/{id}', 'Admin\CountryController@updateCountry')->name('country.edit');
    Route::put('/country/status', 'Admin\CountryController@editStatusCountry')->name('country.status');
    Route::delete('/country/destroy/{id}', 'Admin\CountryController@destroyCountry')->name('country.destroy');

    Route::get('/header-section', 'Admin\HeaderFooterController@index')->name('header.index');
    Route::get('/header-section/{menu_id}', 'Admin\HeaderFooterController@editHeader')->name('header.edit');
    Route::put('/header-section/{menu_id}', 'Admin\HeaderFooterController@updateHeader')->name('header.update');;

    Route::get('/home-page', 'Admin\HomeController@index')->name('home.index');
    Route::get('/home-page/search-section/{lang_id}', 'Admin\HomeController@searchSection')->name('home.searchSection');
    Route::get('/home-page/client-review/{lang_id}', 'Admin\HomeController@clientReview')->name('home.clientReview');
    Route::put('/home-page/client-review/{lang_id}', 'Admin\HomeController@clientReviewUpdate')->name('home.clientReviewUpdate');

    Route::get('/home-page/popular-visa/{lang_id}', 'Admin\HomeController@popularVisa')->name('home.popularVisa');
    Route::put('/home-page/popular-visa/{lang_id}', 'Admin\HomeController@popularVisaUpdate')->name('home.popularVisaUpdate');

    Route::get('/home-page/section-review/{lang_id}', 'Admin\HomeController@sectionReview')->name('home.sectionReview');
    Route::put('/home-page/section-review/{lang_id}', 'Admin\HomeController@sectionReviewUpdate')->name('home.sectionReviewUpdate');

    Route::get('/home-page/section-search/{lang_id}', 'Admin\HomeController@sectionSearch')->name('home.sectionSearch');
    Route::put('/home-page/section-search/{lang_id}', 'Admin\HomeController@sectionSearchUpdate')->name('home.sectionSearchUpdate');


    Route::get('/home-page/section-2/{lang_id}', 'Admin\HomeController@section2List')->name('home.section2List');
    Route::put('/home-page/section-2/{lang_id}', 'Admin\HomeController@section2Update')->name('home.section2Update');

    Route::get('/home-page/section-3/{lang_id}', 'Admin\HomeController@section3List')->name('home.section3List');
    Route::put('/home-page/section-3/{lang_id}', 'Admin\HomeController@section3Update')->name('home.section3Update');

    Route::get('/home-page/section-info/{lang_id}', 'Admin\HomeController@infoList')->name('home.infoList');
    Route::put('/home-page/section-info/{lang_id}', 'Admin\HomeController@infoUpdate')->name('home.infoUpdate');

    Route::get('/footer-section', 'Admin\HeaderFooterController@footerList')->name('footer.index');
    Route::get('/footer-section/tags/{lang_id}', 'Admin\HeaderFooterController@footerTagEdit')->name('footer.tags');
    Route::put('/footer-section/tags/{lang_id}', 'Admin\HeaderFooterController@footerTagUpdate')->name('footer.tagsUpdate');
    Route::get('/footer-section/logo/{lang_id}', 'Admin\HeaderFooterController@footerLogoEdit')->name('footer.logo');
    Route::put('/footer-section/logo/{lang_id}', 'Admin\HeaderFooterController@footerLogoUpdate')->name('footer.logoUpdate');
    Route::get('/footer-section/office/{lang_id}', 'Admin\HeaderFooterController@footerOfficeEdit')->name('footer.office');
    Route::put('/footer-section/office/{lang_id}', 'Admin\HeaderFooterController@footerOfficeUpdate')->name('footer.officeUpdate');
    Route::get('/footer-section/social/{lang_id}', 'Admin\HeaderFooterController@footerSocialEdit')->name('footer.social');
    Route::put('/footer-section/social/{lang_id}', 'Admin\HeaderFooterController@footerSocialUpdate')->name('footer.social');
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

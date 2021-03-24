<?php
use Illuminate\Support\Facades\DB;

// Route::get('/', 'HomeController@index');
$pages = DB::table('route_visa')->get();

$this->get('/', 'Front\LandingController@index');
$this->get('/about', 'Front\AboutController@index');
$this->get("/api/country-list/{country}", 'Front\LandingController@apiCountryList');
$this->get("/apply-online/{country}", 'Front\VisaController@applyOnline');
$this->post("/apply-online", 'Front\VisaController@applyOnlineSave')->name('apply.save');
$this->get("/apply-online-review/{slug}", 'Front\VisaController@applyOnlineReview')->name('apply.review');

if(!empty($pages)){
  foreach ($pages as $page){
    Route::get('/'.$page->visa_url, $page->class.'@'.$page->method);
   }
}

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

    Route::get('/visa', 'Admin\VisaController@index')->name('visa.index');
    Route::get('/visa/add', 'Admin\VisaController@createVisa')->name('visa.create');
    Route::post('/visa/add', 'Admin\VisaController@storeVisa')->name('visa.create');
    Route::get('/visa/edit/{id}', 'Admin\VisaController@editVisa')->name('visa.edit');
    Route::put('/visa/edit/{id}', 'Admin\VisaController@updateVisa')->name('visa.edit');
    Route::delete('/visa/destroy/{id}', 'Admin\VisaController@destroyVisa')->name('visa.destroy');

    Route::get('/visa/faq/{id}', 'Admin\VisaController@faqVisa')->name('visa.faqList');
    Route::get('/visa/faq-create/{id}', 'Admin\VisaController@faqCreateVisa')->name('visa.faqCreate');
    Route::post('/visa/faq-create/{id}', 'Admin\VisaController@faqStoreVisa')->name('visa.faqCreate');
    Route::get('/visa/faq-edit/{id}/{faqId}', 'Admin\VisaController@faqEditVisa')->name('visa.faqEdit');
    Route::put('/visa/faq-edit/{id}/{faqId}', 'Admin\VisaController@faqUpdateVisa')->name('visa.faqUpdate');
    Route::delete('/visa/faq-delete/{id}/{faqId}', 'Admin\VisaController@faqDeleteVisa')->name('visa.faqDelete');


    Route::get('/country', 'Admin\CountryController@index')->name('country.index');
    Route::get('/country/add', 'Admin\CountryController@createCountry')->name('country.create');
    Route::post('/country/add', 'Admin\CountryController@storeCountry')->name('country.create');
    Route::get('/country/edit/{id}', 'Admin\CountryController@editCountry')->name('country.edit');
    Route::put('/country/edit/{id}', 'Admin\CountryController@updateCountry')->name('country.edit');
    Route::put('/country/status', 'Admin\CountryController@editStatusCountry')->name('country.status');
    Route::delete('/country/destroy/{id}', 'Admin\CountryController@destroyCountry')->name('country.destroy');

    Route::get('/country/port-of-arrival/{country_id}', 'Admin\CountryController@portOfArrivalCountry')->name('country.portOfArrivalCountry');
    Route::get('/country/port-of-arrival-add/{country_id}', 'Admin\CountryController@portOfArrivalAddCountry')->name('country.portOfArrivalAddCountry');
    Route::post('/country/port-of-arrival-add/{country_id}', 'Admin\CountryController@portOfArrivalStoreCountry')->name('country.portOfArrivalStoreCountry');
    Route::get('/country/port-of-arrival-edit/{country_id}/{port_id}', 'Admin\CountryController@portOfArrivalEditCountry')->name('country.portOfArrivalEditCountry');
    Route::put('/country/port-of-edit/{country_id}/{port_id}', 'Admin\CountryController@portOfArrivalUpdateCountry')->name('country.portOfArrivalUpdateCountry');
    Route::delete('/country/port-of-edit/{country_id}/{port_id}', 'Admin\CountryController@portOfArrivalDeleteCountry')->name('country.portOfArrivalDeleteCountry');


    Route::get('/header-section', 'Admin\HeaderFooterController@index')->name('header.index');
    Route::get('/header-section/add', 'Admin\HeaderFooterController@createHeader')->name('header.create');
    Route::post('/header-section/add', 'Admin\HeaderFooterController@storeHeader')->name('header.store');
    Route::get('/header-section/edit/{menu_id}', 'Admin\HeaderFooterController@editHeader')->name('header.edit');
    Route::put('/header-section/edit/{menu_id}', 'Admin\HeaderFooterController@updateHeader')->name('header.update');;
    Route::post('/header-section/status', 'Admin\HeaderFooterController@updateStatusMenu')->name('header.updateMenuStatus');;
    Route::delete('/header-section/delete/{menu_id}', 'Admin\HeaderFooterController@deleteMenu')->name('header.destroyMenu');;

    Route::get('/visa-application/list', 'Admin\ApplicationController@index')->name('application.index');
    Route::get('/visa-application/detail/{application_id}', 'Admin\ApplicationController@applicationDetail')->name('application.detail');


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


});

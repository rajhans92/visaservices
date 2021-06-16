<?php
use Illuminate\Support\Facades\DB;

// Route::get('/', 'HomeController@index');
$pages = DB::table('route_visa')->get();

$this->get('/', 'Front\LandingController@index');
$this->get('/about', 'Front\AboutController@index');
$this->get("/api/country-list/{country}", 'Front\LandingController@apiCountryList');
$this->get("/apply-online/{url}", 'Front\VisaController@applyOnline');
$this->post("/apply-online", 'Front\VisaController@applyOnlineSave')->name('apply.save');
$this->post("/apply-online-update/{url}/{slug}", 'Front\VisaController@applyOnlineUpdate')->name('apply.onlineUpdate');
$this->get("/apply-online/{url}/{slug}", 'Front\VisaController@applyOnlineEdit')->name('apply.edit');
$this->get("/apply-online-review/{slug}", 'Front\VisaController@applyOnlineReview')->name('apply.review');
$this->post("/apply-online-review/{slug}", 'Front\VisaController@applyOnlineReviewSave')->name('apply.reviewSave');
$this->post("/apply-contact-us", 'Front\VisaController@applyContactUs')->name('apply.cotactUs');

$this->post("/services-contact-us", 'Front\ServicesController@serviceContactUs')->name('service.cotactUs');

$this->get("/services-online/{url}", 'Front\ServicesController@applyOnline');
$this->post("/services-online", 'Front\ServicesController@applyOnlineSave')->name('services.save');
$this->get("/services-online-review/{slug}", 'Front\ServicesController@applyOnlineReview')->name('services.review');
$this->post("/services-online-review/{slug}", 'Front\ServicesController@applyOnlineReviewSave')->name('services.reviewSave');
$this->get("/services-online/{url}/{slug}", 'Front\ServicesController@applyOnlineEdit')->name('services.edit');
$this->post("/services-online-update/{url}/{slug}", 'Front\ServicesController@applyOnlineUpdate')->name('services.onlineUpdate');

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

    Route::get('/services', 'Admin\ServicesController@index')->name('services.index');
    Route::get('/services/add', 'Admin\ServicesController@createServices')->name('services.create');
    Route::post('/services/add', 'Admin\ServicesController@storeServices')->name('services.create');
    Route::get('/services/edit/{id}', 'Admin\ServicesController@editServices')->name('services.edit');
    Route::put('/services/edit/{id}', 'Admin\ServicesController@updateServices')->name('services.edit');
    Route::delete('/services/destroy/{id}', 'Admin\ServicesController@destroyServices')->name('services.destroy');

    Route::get('/services/apply/{services_id}', 'Admin\ServicesController@applyDetailList')->name('services.applyDetailList');
    Route::post('/services/apply/{services_id}', 'Admin\ServicesController@applyDetailSave')->name('services.applyDetailSave');

    Route::get('/faq', 'Admin\FaqController@list')->name('faq.list');
    Route::get('/faq/create', 'Admin\FaqController@create')->name('faq.create');
    Route::post('/faq/create', 'Admin\FaqController@save')->name('faq.save');
    Route::get('/faq/edit/{id}', 'Admin\FaqController@edit')->name('faq.edit');
    Route::put('/faq/edit/{id}', 'Admin\FaqController@update')->name('faq.update');
    Route::delete('/faq/delete/{id}', 'Admin\FaqController@delete')->name('faq.delete');


    Route::get('/services/faq/{id}', 'Admin\ServicesController@faqServices')->name('services.faqList');
    Route::get('/services/faq-create/{id}', 'Admin\ServicesController@faqCreateServices')->name('services.faqCreate');
    Route::post('/services/faq-create/{id}', 'Admin\ServicesController@faqStoreServices')->name('services.faqCreate');
    Route::get('/services/faq-edit/{id}/{faqId}', 'Admin\ServicesController@faqEditServices')->name('services.faqEdit');
    Route::put('/services/faq-edit/{id}/{faqId}', 'Admin\ServicesController@faqUpdateServices')->name('services.faqUpdate');
    Route::delete('/services/faq-delete/{id}/{faqId}', 'Admin\ServicesController@faqDeleteServices')->name('services.faqDelete');

    Route::get('/services/data-entry/{services_id}', 'Admin\ServicesController@dataEntryList')->name('services.dataEntryList');
    Route::get('/services/data-entry-upload/{services_id}', 'Admin\ServicesController@dataEntryUpdate')->name('services.dataEntryUpdate');
    Route::post('/services/data-entry-upload/{services_id}', 'Admin\ServicesController@dataEntrySave')->name('services.dataEntrySave');
    Route::get('/service-contact/list', 'Admin\ServicesController@contactList')->name('services.contactList');

    Route::get('/service-application/list', 'Admin\ServicesController@applicationList')->name('services.applicationList');
    Route::get('/service-application/detail/{application_id}', 'Admin\ServicesController@applicationDetail')->name('services.applicationDetail');


    Route::get('/visa', 'Admin\VisaController@index')->name('visa.index');
    Route::get('/visa/add', 'Admin\VisaController@createVisa')->name('visa.create');
    Route::post('/visa/add', 'Admin\VisaController@storeVisa')->name('visa.create');
    Route::get('/visa/edit/{id}', 'Admin\VisaController@editVisa')->name('visa.edit');
    Route::put('/visa/edit/{id}', 'Admin\VisaController@updateVisa')->name('visa.edit');
    Route::delete('/visa/destroy/{id}', 'Admin\VisaController@destroyVisa')->name('visa.destroy');

    Route::get('/blog', 'Admin\BlogController@index')->name('blog.index');
    Route::get('/blog/add', 'Admin\BlogController@create')->name('blog.create');
    Route::post('/blog/add', 'Admin\BlogController@store')->name('blog.create');
    Route::get('/blog/edit/{id}', 'Admin\BlogController@edit')->name('blog.edit');
    Route::put('/blog/edit/{id}', 'Admin\BlogController@update')->name('blog.update');
    Route::delete('/blog/destroy/{id}', 'Admin\BlogController@destroy')->name('blog.destroy');

    Route::get('/blog/category', 'Admin\BlogController@categoryList')->name('blog.categoryList');
    Route::get('/blog/category/add', 'Admin\BlogController@categoryAdd')->name('blog.categoryAdd');
    Route::post('/blog/category/add', 'Admin\BlogController@categoryStore')->name('blog.categoryStore');
    Route::get('/blog/category/edit/{id}', 'Admin\BlogController@categoryEdit')->name('blog.categoryEdit');
    Route::put('/blog/category/edit/{id}', 'Admin\BlogController@categoryUpdate')->name('blog.categoryUpdate');
    Route::delete('/blog/category/destroy/{id}', 'Admin\BlogController@categoryDestroy')->name('blog.categoryDestroy');


    Route::get('/visa/apply/{visa_id}', 'Admin\VisaController@applyDetailList')->name('visa.applyDetailList');
    Route::post('/visa/apply/{visa_id}', 'Admin\VisaController@applyDetailSave')->name('visa.applyDetailSave');


    Route::get('/visa/faq/{id}', 'Admin\VisaController@faqVisa')->name('visa.faqList');
    Route::get('/visa/faq-create/{id}', 'Admin\VisaController@faqCreateVisa')->name('visa.faqCreate');
    Route::post('/visa/faq-create/{id}', 'Admin\VisaController@faqStoreVisa')->name('visa.faqCreate');
    Route::get('/visa/faq-edit/{id}/{faqId}', 'Admin\VisaController@faqEditVisa')->name('visa.faqEdit');
    Route::put('/visa/faq-edit/{id}/{faqId}', 'Admin\VisaController@faqUpdateVisa')->name('visa.faqUpdate');
    Route::delete('/visa/faq-delete/{id}/{faqId}', 'Admin\VisaController@faqDeleteVisa')->name('visa.faqDelete');

    Route::get('/visa/type-of-visa/{visa_id}', 'Admin\VisaController@typeOfVisaList')->name('visa.typeOfVisaList');
    Route::get('/visa/type-of-visa-upload/{visa_id}', 'Admin\VisaController@typeOfVisaUpload')->name('visa.typeOfVisaUpload');
    Route::post('/visa/type-of-visa-upload/{visa_id}', 'Admin\VisaController@typeOfVisaSave')->name('visa.typeOfVisaSave');

    Route::get('/embassies', 'Admin\EmbassiesController@index')->name('embassies.index');
    Route::get('/embassies/upload', 'Admin\EmbassiesController@embassiesNameUpload')->name('embassies.embassiesNameUpload');
    Route::post('/embassies/upload', 'Admin\EmbassiesController@embassiesNameSave')->name('embassies.embassiesNameSave');
    Route::get('/embassies/edit/{embassies_id}', 'Admin\EmbassiesController@embassiesNameEdit')->name('embassies.embassiesNameEdit');
    Route::post('/embassies/edit/{embassies_id}', 'Admin\EmbassiesController@embassiesNameUpdate')->name('embassies.embassiesNameUpdate');
    Route::delete('/embassies/delete/{embassies_id}', 'Admin\EmbassiesController@embassiesNameDelete')->name('embassies.embassiesNameDelete');


    Route::get('/embassies/{embassies_id}', 'Admin\EmbassiesController@embassiesList')->name('embassies.embassiesList');
    Route::get('/embassies/upload/{embassies_id}', 'Admin\EmbassiesController@embassiesUpload')->name('embassies.embassiesUpload');
    Route::post('/embassies/upload/{embassies_id}', 'Admin\EmbassiesController@embassiesSave')->name('embassies.embassiesSave');
    Route::get('/embassies/edit/{embassies_id}/{id}', 'Admin\EmbassiesController@embassiesEdit')->name('embassies.embassiesEdit');
    Route::post('/embassies/edit/{embassies_id}/{id}', 'Admin\EmbassiesController@embassiesUpdate')->name('embassies.embassiesUpdate');
    Route::delete('/embassies/delete/{embassies_id}/{id}', 'Admin\EmbassiesController@embassiesDelete')->name('embassies.embassiesDelete');


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
    Route::get('/visa-application/tracking/{application_id}', 'Admin\ApplicationController@trackingDetail')->name('application.trackingDetail');
    Route::post('/visa-application/tracking/{application_id}', 'Admin\ApplicationController@trackingDetailUpdate')->name('application.trackingDetailUpdate');

    Route::get('/visa-contact/list', 'Admin\ApplicationController@contactList')->name('application.contactList');


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

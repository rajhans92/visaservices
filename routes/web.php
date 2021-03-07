<?php
// Route::get('/', 'HomeController@index');

$this->get('/', 'Front\LandingController@index');

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

    // Route::resource('user-profile', 'Admin\UserProfileController');
    //
    // Route::resource('permissions', 'Admin\PermissionsController');
    // Route::post('permissions_mass_destroy', ['uses' => 'Admin\PermissionsController@massDestroy', 'as' => 'permissions.mass_destroy']);
    // Route::resource('roles', 'Admin\RolesController');
    // Route::post('roles_mass_destroy', ['uses' => 'Admin\RolesController@massDestroy', 'as' => 'roles.mass_destroy']);

});

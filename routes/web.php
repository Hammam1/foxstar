<?php
Route::get('', function () { return redirect('/admin/home'); });
Route::get('/home', function () { return redirect('/admin/home'); });

//Route::get('/auth/redirect/{provider}', 'SocialController@redirect');
//Route::get('/callback/{provider}', 'SocialController@callback');
	
// Authentication Routes...
//$this->get('register', 'Auth\RegisterController@showRegistrationForm');
$this->get('login', 'Auth\LoginController@showLoginForm')->name('auth.login');
$this->post('login', 'Auth\LoginController@login')->name('auth.login');
$this->post('logout', 'Auth\LoginController@logout')->name('auth.logout');
//$this->post('register', 'Auth\RegisterController@register')->name('register.login');

// Change Password Routes...
$this->get('change_password', 'Auth\ChangePasswordController@showChangePasswordForm')->name('auth.change_password');
$this->patch('change_password', 'Auth\ChangePasswordController@changePassword')->name('auth.change_password');

// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('auth.password.reset');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('auth.password.reset');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset')->name('auth.password.reset');

Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/home', 'HomeController@index');
    Route::resource('permissions', 'Admin\PermissionsController');
	Route::post('permissions_mass_destroy', ['uses' => 'Admin\PermissionsController@massDestroy', 'as' => 'permissions.mass_destroy']);
	Route::resource('rings', 'Admin\RingController');
	Route::post('rings_mass_destroy', ['uses' => 'Admin\RingController@massDestroy', 'as' => 'rings.mass_destroy']);
	Route::resource('categories', 'Admin\CategoryController');
    Route::post('categories_mass_destroy', ['uses' => 'Admin\CategoryController@massDestroy', 'as' => 'categories.mass_destroy']);
	Route::resource('roles', 'Admin\RolesController');
    Route::post('roles_mass_destroy', ['uses' => 'Admin\RolesController@massDestroy', 'as' => 'roles.mass_destroy']);
    Route::resource('users', 'Admin\UsersController');
    Route::post('users_mass_destroy', ['uses' => 'Admin\UsersController@massDestroy', 'as' => 'users.mass_destroy']);

});

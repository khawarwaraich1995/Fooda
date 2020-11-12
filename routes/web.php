<?php
print_r("ada");exit;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('admin/login');
});

Route::get('403_page', function () {
  return view('403-page');
});

Route::group(['prefix' => 'admin'], function(){
  Auth::routes();
});
Route::group(['prefix' => 'admin','middleware' => ['auth'],'as' => 'admin:'], function () {

  Route::get('/home', 'HomeController@index')->name('home');

  //Profile Routes (Admin)
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);

  //Outlet Routes
  Route::group(['middleware' => 'check.permissions:Outlets'], function(){
  Route::get('outlets', ['as' => 'outlets', 'uses' => 'OutletController@index']);
  Route::get('outlets/create', ['as' => 'outlet.create', 'uses' => 'OutletController@create']);
  Route::post('outlets/add', ['as' => 'outlet.add', 'uses' => 'OutletController@store']);
  Route::any('outlets/update/{id}', ['as' => 'outlet.update', 'uses' => 'OutletController@store']);
  Route::get('outlets/edit/{id}', ['as' => 'outlet.edit', 'uses' => 'OutletController@edit']);
  Route::post('outlets/change_status', ['as' => 'outlet.status', 'uses' => 'OutletController@change_status']);
  });

  //Company Routes
  Route::group(['middleware' => 'check.permissions:Company'], function(){
  Route::get('company', ['as' => 'company', 'uses' => 'CompanyController@index']);
  Route::get('company/create', ['as' => 'company.create', 'uses' => 'CompanyController@create']);
  Route::any('company/add', ['as' => 'company.add', 'uses' => 'CompanyController@store']);
  Route::any('company/update/{id}', ['as' => 'company.update', 'uses' => 'CompanyController@store']);
  Route::get('company/edit/{id}', ['as' => 'company.edit', 'uses' => 'CompanyController@edit']);
  Route::post('company/change_status', ['as' => 'company.status', 'uses' => 'CompanyController@change_status']);
  });

  //Users Routes
  Route::group(['middleware' => 'check.permissions:Users'], function(){
  Route::get('users', ['as' => 'users', 'uses' => 'UserController@index']);
  Route::get('users/create', ['as' => 'user.create', 'uses' => 'UserController@create']);
  Route::post('users/add', ['as' => 'user.add', 'uses' => 'UserController@store']);
  Route::any('users/update/{id}', ['as' => 'user.update', 'uses' => 'UserController@store']);
  Route::get('users/edit/{id}', ['as' => 'user.edit', 'uses' => 'UserController@edit']);
  Route::post('users/change_status', ['as' => 'user.status', 'uses' => 'UserController@change_status']);
  });

  //Roles and Permissions Management Routes
  Route::group(['middleware' => 'check.permissions:Roles & Permissions'], function(){
  Route::get('roles', ['as' => 'roles', 'uses' => 'RolesController@index']);
  Route::get('roles/create', ['as' => 'role.create', 'uses' => 'RolesController@create']);
  Route::post('roles/add', ['as' => 'role.add', 'uses' => 'RolesController@store']);
  Route::any('roles/update/{id}', ['as' => 'role.update', 'uses' => 'RolesController@store']);
  Route::get('roles/edit/{id}', ['as' => 'role.edit', 'uses' => 'RolesController@edit']);
  Route::post('roles/change_status', ['as' => 'role.status', 'uses' => 'RolesController@change_status']);
  Route::get('roles/permission-modules/{id}', ['as' => 'role.permission-modules', 'uses' => 'RolesController@permission_modules']);
  Route::post('roles/permission-modules/update/{id}', ['as' => 'permissions-modules.update', 'uses' => 'RolesController@permission_modules_update']);
  });

  //Permissions Management
  Route::group(['middleware' => 'check.permissions:Permissions Management'], function(){
  Route::get('permissions', ['as' => 'permissions', 'uses' => 'PermissionsController@index']);
  Route::post('permissions/add', ['as' => 'permissions.add', 'uses' => 'PermissionsController@store']);
  Route::any('permissions/update/{id}', ['as' => 'permissions.update', 'uses' => 'PermissionsController@store']);
  });

  //Settings
  Route::group(['middleware' => 'check.permissions:Settings'], function(){
  Route::get('settings', ['as' => 'settings', 'uses' => 'SettingsController@index']);
  Route::post('settings/add-uploads', ['as' => 'settings.add-uploads', 'uses' => 'SettingsController@store_images']);
  Route::any('settings/update-uploads/{id}', ['as' => 'settings.update-uploads', 'uses' => 'SettingsController@store_images']);
  });

});

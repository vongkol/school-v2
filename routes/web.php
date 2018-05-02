<?php

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
header('Access-Control-Allow-Origin: *');
header( 'Access-Control-Allow-Headers: Authorization, Content-Type' );
Route::get('/',"HomeController@index");

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
// user route
Route::get('/user', "UserController@index");
Route::get('/user/profile', "UserController@load_profile");
Route::get('/user/reset-password', "UserController@reset_password");
Route::post('/user/change-password', "UserController@change_password");
Route::get('/user/finish', "UserController@finish_page");
Route::post('/user/update-profile', "UserController@update_profile");
Route::get('/user/delete/{id}', "UserController@delete");
Route::get('/user/create', "UserController@create");
Route::post('/user/save', "UserController@save");
Route::get('/user/edit/{id}', "UserController@edit");
Route::post('/user/update', "UserController@update");
Route::get('/user/update-password/{id}', "UserController@load_password");
Route::post('/user/save-password', "UserController@update_password");
Route::get('/user/branch/{id}', "UserController@branch");
Route::post('/user/branch/save', "UserController@add_branch");
Route::get('/user/branch/delete/{id}', "UserController@delete_branch");
// role
Route::get('/role', "RoleController@index");
Route::get('/role/create', "RoleController@create");
Route::post('/role/save', "RoleController@save");
Route::get('/role/delete/{id}', "RoleController@delete");
Route::get('/role/edit/{id}', "RoleController@edit");
Route::post('/role/update', "RoleController@update");
Route::get('/role/permission/{id}', "PermissionController@index");
Route::post('/rolepermission/save', "PermissionController@save");
// branch
Route::get('/branch', "BranchController@index");
Route::get('/branch/create', "BranchController@create");
Route::post('/branch/save', "BranchController@save");
Route::get('/branch/delete/{id}', "BranchController@delete");
Route::get('/branch/edit/{id}', "BranchController@edit");
Route::post('/branch/update', "BranchController@update");
// class or level of study
Route::get('/class', "ClassController@index");
Route::get('/class/create', "ClassController@create");
Route::get('/class/edit/{id}', "ClassController@edit");
Route::post('/class/save', "ClassController@save");
Route::get('/class/delete/{id}', "ClassController@delete");
Route::post('/class/update', "ClassController@update");
// shift
Route::get('/shift', "ShiftController@index");
Route::get('/shift/create', "ShiftController@create");
Route::get('/shift/edit/{id}', "ShiftController@edit");
Route::post('/shift/save', "ShiftController@save");
Route::get('/shift/delete/{id}', "ShiftController@delete");
Route::post('/shift/update', "ShiftController@update");
// item category
Route::get('/item-category', "ItemCategoryController@index");
Route::get('/item-category/create', "ItemCategoryController@create");
Route::get('/item-category/edit/{id}', "ItemCategoryController@edit");
Route::post('/item-category/save', "ItemCategoryController@save");
Route::get('/item-category/delete/{id}', "ItemCategoryController@delete");
Route::post('/item-category/update', "ItemCategoryController@update");
// position
Route::get('/position', "PositionController@index");
Route::get('/position/create', "PositionController@create");
Route::get('/position/edit/{id}', "PositionController@edit");
Route::post('/position/save', "PositionController@save");
Route::get('/position/delete/{id}', "PositionController@delete");
Route::post('/position/update', "PositionController@update");
// staff
Route::get('/staff', "StaffController@index");
Route::get('/staff/create', "StaffController@create");
Route::get('/staff/edit/{id}', "StaffController@edit");
Route::post('/staff/save', "StaffController@save");
Route::get('/staff/delete/{id}', "StaffController@delete");
Route::get('/staff/detail/{id}', "StaffController@detail");
Route::post('/staff/update', "StaffController@update");
// school year
Route::get('/school-year', "SchoolYearController@index");
Route::get('/school-year/create', "SchoolYearController@create");
Route::get('/school-year/edit/{id}', "SchoolYearController@edit");
Route::get('/school-year/delete/{id}', "SchoolYearController@delete");
Route::post("/school-year/save", "SchoolYearController@save");
Route::post('/school-year/update', "SchoolYearController@update");
// room
Route::get('/room', "RoomController@index");
Route::get('/room/create', "RoomController@create");
Route::get('/room/edit/{id}', "RoomController@edit");
Route::get('/room/delete/{id}', "RoomController@delete");
Route::post('/room/save', "RoomController@save");
Route::post('/room/update', "RoomController@update");
// subject
Route::get('/subject', "SubjectController@index");
Route::get('/subject/create', "SubjectController@create");
Route::get('/subject/edit/{id}', "SubjectController@edit");
Route::get('/subject/delete/{id}', "SubjectController@delete");
Route::post('/subject/save', "SubjectController@save");
Route::post('/subject/update', "SubjectController@update");
// students
Route::get('/student', "StudentController@index");
Route::get('/student/create', "StudentController@create");
Route::post("/student/save" ,"StudentController@save");
Route::get('/student/detail/{id}', "StudentController@detail");
Route::post('/student/update', "StudentController@update");
Route::get('/student/delete/{id}', "StudentController@delete");
// provinces
Route::get('/province', "ProvinceController@index");
Route::get('/province/create', "ProvinceController@create");
Route::get('/province/delete/{id}', "ProvinceController@delete");
Route::get('/province/edit/{id}', "ProvinceController@edit");
Route::post('/province/save', "ProvinceController@save");
Route::post('/province/update', "ProvinceController@update");
// district
Route::resource('/district', "DistrictController");
Route::get('/district/delete/{id}', "DistrictController@destroy");
Route::get('/district/edit/{id}', "DistrictController@edit");
Route::post('/district/up', "DistrictController@update");
Route::get('/district/get/{id}', "DistrictController@getDistrict");
// commune 
Route::get('/commune', "CommuneController@index");
Route::get('/commune/create', "CommuneController@create");
Route::get('/commune/edit/{id}', "CommuneController@edit");
Route::get('/commune/delete/{id}', "CommuneController@delete");
Route::post('/commune/save', "CommuneController@save");
Route::post('/commune/update', "CommuneController@update");
// village
Route::get('/village', "VillageController@index");
Route::get('/village/create', "VillageController@create");
Route::get('/village/edit/{id}', "VillageController@edit");
Route::get('/village/delete/{id}', "VillageController@delete");
Route::post('/village/save', "VillageController@save");
Route::post('/village/update', "VillageController@update");
// family route
Route::post('/family/save', "FamilyController@save");
Route::get('/family/delete/{id}', "FamilyController@delete");
// document
Route::post('/document/save', "DocumentController@save");
Route::get('/document/delete/{id}', "DocumentController@delete");
// staff document
Route::post('/staff-document/save', "StaffDocumentController@save");
Route::get('/staff-document/delete/{id}', "StaffDocumentController@delete");
// health
Route::post('/health/save', "HealthController@save");
Route::get('/health/delete/{id}', "HealthController@delete");
// registration
Route::get("/registration/delete/{id}", "RegistrationController@delete");
Route::post("/registration/save", "RegistrationController@save");
// reports
Route::get('/report', "ReportController@index");
// printing
Route::get('/printing', "PrintingController@index");
Route::get('/printing/province', "PrintingController@by_province");
Route::get('/printing/school', "PrintingController@by_school");
// test
Route::get('/test', "TestController@index");
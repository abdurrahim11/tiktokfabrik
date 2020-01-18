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

Route::get("/",[
    'as'    => "/",
    "uses"  => 'frontendController@dashboard'
]);

Route::get("/register-package",[
    'as'    => "/",
    "uses"  => 'frontendController@index'
]);

Route::get("/plancreate",[
    'as'    => "/plancreate",
    "uses"  => 'paymentController@createPlan'
]);

Route::get("/agreement",[
    'as'    => "/agreement",
    "uses"  => 'paypalUserController@agreement'
]);

Route::get("/showPlans",[
    'as'    => "/showPlans",
    "uses"  => 'paymentController@showPlans'
]);
Route::get("/deletePlan",[
    'as'    => "/deletePlan",
    "uses"  => 'paymentController@deletePlan'
]);
Route::get("/subscribe/",[
    'as'    => "/subscribe",
    "uses"  => 'paypalUserController@subscribe'
]);
Route::post("/register-package",[
    'as'    => "/register-package",
    "uses"  => 'frontendController@registerpackage'
]);
Route::get("/user-login",[
    'as'    => "/user-login",
    "uses"  => 'frontendController@userlogin'
]);

Route::post("/form-user-login",[
    'as'    => "/form-user-login",
    "uses"  => 'frontendController@formuserlogin'
]);
Route::get("/user-profile",[
    'as'    => "/user-profile",
    "uses"  => 'frontendController@userprofile'
]);

Route::get("/user-logout",[
    'as'    => "/user-logout",
    "uses"  => 'frontendController@userlogout'
]);
Route::post("/user-profile-update",[
    'as'    => "/user-profile-update",
    "uses"  => 'frontendController@userprofileupdate'
]);
Route::get("/account-status",[
    'as'    => "/account-status",
    "uses"  => 'frontendController@accountstatus'
]);
Route::get("/manage-user",[
    'as'    => "/manage-user",
    "uses"  => 'HomeController@manageuser'
]);
Route::get("/cancel-sub/{id}",[
    'as'    => "/cancel-sub",
    "uses"  => 'paypalUserController@paypalcancelsub'
]);
Route::get("/active-sub/",[
    'as'    => "/active-sub",
    "uses"  => 'paypalUserController@subscribe'
]);

Route::get("/view/user-profile/{id}",[
    'as'    => "/view/user-profile",
    "uses"  => 'HomeController@viewuserprofile'
]);
Route::get("/manage-user-active",[
    'as'    => "/manage-user-active",
    "uses"  => 'HomeController@manageuseractive'
]);
Route::get("/manage-user-inactive",[
    'as'    => "/manage-user-inactive",
    "uses"  => 'HomeController@manageuserinactive'
]);
Route::get("/begateway",[
    'as'    => "/begateway",
    "uses"  => 'begatewayController@begateway'
]);
Route::get("/success-bepaid",[
    'as'    => "/success-bepaid",
    "uses"  => 'begatewayController@successbepaid'
]);
Route::get("/download-invoice",[
    'as'    => "/download-invoice",
    "uses"  => 'frontendController@generatePDF'
]);
Route::get("/active-begateway",[
    'as'    => "/active-begateway",
    "uses"  => 'frontendController@activebegateway'
]);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

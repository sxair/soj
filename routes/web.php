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

Route::view('/', 'index')->name('home');

/*
 * user model
 * Auth::routes()
 */
Route::get('login/{to?}', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::get('userinfo/{username}', 'UserController@userInfo');
Route::view('registerSuccess', 'auth.registerSuccess');
Route::get('confirmEmail/{token}/{email}', 'UserController@confirmEmail');

Route::get('change', 'UserController@changeUserInfoPage')->middleware('auth');
Route::post('change', 'UserController@changeUserInfo')->middleware('auth');

/*
 * problems model
 */
Route::view('problems', 'problems');
Route::view('status', 'problems');
Route::view('rank', 'problems');
Route::view('problem/{id}','problems');
Route::get('submit/{id?}', 'ProblemController@submitPage');
Route::post('submit', 'ProblemController@submit');
Route::view('showcode/{id}', 'problems');
Route::get('code/{id}', 'ProblemController@getCode');
Route::view('ceinfo/{id}', 'problems');
/*
 * contest model
 */
Route::view('contests', 'contest.contests');
Route::get('contest/{id}', 'ContestController@contest');

/*
 * tools model
 */
Route::get('help/{title}', 'IndexController@help');
Route::view('tools', 'tools.index');
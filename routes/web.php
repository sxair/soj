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

//Route::get('testmail', function () {
//    return new App\Mail\AdminPasswordFailed((object)[
//        'user_name' => 'sair',
//        'ip' => '1.1.1.1',
//        'time' => date("Y-m-h H:i:s"),
//    ]);
//});

Route::get('test', function() {
});

Route::get('/', 'IndexController@index')->name('home');
Route::get('/home', 'IndexController@index');
//user
$this->get('login/{to?}', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login');
$this->post('logout', 'Auth\LoginController@logout')->name('logout');
// Registration Routes...
$this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
$this->post('register', 'Auth\RegisterController@register');
// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset');
Route::get('/userinfo/{username}', 'UserController@userinfo');

// problem
Route::get('/problems', 'ProblemController@problems');
Route::get('/problem/{id}', 'ProblemController@problem');
Route::get('/proinfo/{id}', 'ProblemController@proinfo');
Route::get('/submit/{id}/{time}/{memory}', 'ProblemController@submitPage');
Route::post('/submit', 'ProblemController@submit');
Route::get('/status/{id?}/{user?}', 'ProblemController@status');
Route::get('/showcode/{id}', 'ProblemController@showcode');
Route::get('/rank', 'ProblemController@rank');

//content
Route::get('/contests','ContestController@contests');

// admin
Route::get('/control', 'Admin\IndexController@index');
Route::view('/control/login', 'admin.login');
Route::post('/control/login', 'Admin\AuthController@login');
Route::post('/control/logout', 'Admin\AuthController@logout');
Route::get('/addproblem', 'Admin\ProblemController@addProblemPage');
Route::post('/addproblem', 'Admin\ProblemController@addProblem');
Route::get('/changedata/{id}', 'Admin\ProblemController@changeDataPage');
Route::post('/changedata', 'Admin\ProblemController@changeData');
Route::post('/addproblemtooj', 'Admin\ProblemController@addProblemToOj');
Route::get('/updateproblem', 'Admin\ProblemController@showProblem');
Route::get('/updateproblem/{id}', 'Admin\ProblemController@updateProblemPage');
Route::post('/updateproblem', 'Admin\ProblemController@updateProblem');
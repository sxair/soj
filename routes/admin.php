<?php

Route::middleware('control')->group(function () {
    Route::view('/', 'admin.index');

    Route::get('admins', 'AdminController@admins');

    Route::get('problems', 'ProblemController@problems');

    Route::get('ojProblems', 'ProblemController@ojProblems');

    Route::post('addProblem', 'ProblemController@addProblem');

    Route::post('changeProblem', 'ProblemController@changeProblem');

    Route::post('cgLabel', 'ProblemController@cgLabel');

    Route::post('setProblemData', 'ProblemController@setProblemData');

    Route::get('help/{title}', 'AdminController@help');

    Route::post('addAdmin', 'AdminController@addAdmin');

    Route::post('delAdmin', 'AdminController@delAdmin');

    Route::post('changePassword', 'AdminController@changePassword');

    Route::get('download/test/{id}', 'ProblemController@downTest');

    Route::get('addToOj/{id}', 'ProblemController@addToOj');

    Route::get('delFromOj/{id}', 'ProblemController@delFromOj');

    Route::get('getProblem/{id}', 'ProblemController@getProblem');

    Route::post('addLabel', 'ProblemController@addLabel');

    Route::post('changeLabel', 'ProblemController@changeLabel');

    Route::get('getProblemLabel/{id}', 'ProblemController@getProblemLabel');

    Route::post('addProblemLabel', 'ProblemController@addProblemLabel');

    Route::post('delProblemLabel', 'ProblemController@delProblemLabel');

    Route::post('submit', 'ProblemController@submit');

    Route::get('getStatus/{id}', 'ProblemController@getStatus');

    Route::post('closeSpj', 'ProblemController@closeSpj');

    Route::post('compile', 'ProblemController@compile');

    Route::get('getCodeModel/{id}', 'ProblemController@getCodeModel');
});


Route::view('login', 'admin.login')->middleware('haveControl');

Route::post('login', 'AuthController@login')->middleware('haveControl');
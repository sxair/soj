<?php

Route::middleware('control')->group(function () {
    Route::view('/', 'admin.index');

    Route::get('problems', 'ProblemController@problems');

    Route::post('addProblem', 'ProblemController@addProblem');

    Route::post('changeProblem', 'ProblemController@changeProblem');

    Route::post('cgLabel', 'ProblemController@cgLabel');

    Route::post('setProblemData', 'ProblemController@setProblemData');

    Route::get('help/{title}', 'AdminController@help');
    
    Route::get('download/test/{id}', 'ProblemController@downTest');

    Route::get('addToOj/{id}', 'ProblemController@addToOj');

    //Route::get('delFromOj/{id}', 'ProblemController@delFromOj');

    Route::get('getProblem/{id}', 'ProblemController@getProblem');
});


Route::view('login', 'admin.login')->middleware('haveControl');

Route::post('login', 'AuthController@login')->middleware('haveControl');
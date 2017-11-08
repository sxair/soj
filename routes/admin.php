<?php

Route::middleware('control')->group(function () {
    Route::view('/', 'admin.index');

    Route::get('problems', 'ProblemsController@problems');

    Route::post('addProblem', 'ProblemsController@addProblem');

    Route::post('cgLabel', 'ProblemsController@cgLabel');
});


Route::view('login', 'admin.login')->middleware('haveControl');

Route::post('login', 'AuthController@login')->middleware('haveControl');
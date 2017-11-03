<?php

Route::view('/', 'admin.index');

Route::get('problems', 'Admin\ProblemsController@problems');

Route::post('addProblem', 'Admin\ProblemsController@addProblem');
<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/*
 * problem api
 */
Route::get('problems', 'ProblemController@problems');
Route::get('problem/{id}', 'ProblemController@problem');
Route::get('status', 'ProblemController@status');
Route::get('label', 'ProblemController@label');
Route::get('rank', 'ProblemController@rank');
// !! api can't use session !!
//Route::post('submit', 'ProblemController@submit');

/*
 * contest api
 */
Route::get('contests', 'ContestController@contests');
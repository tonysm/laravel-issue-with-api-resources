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

Route::get('users', function () {
    $users = \App\User::paginate();

    $includes = explode(',', request()->get('include', ''));

    return \App\Http\Resources\UserCollection::make($users)
        ->includeArticlesCount(in_array('articles_count', $includes));
});

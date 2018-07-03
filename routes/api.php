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

Route::get('api/users/{user}', function (App\User $user) {
    return $user->email;
});



Route::get('test',function(){
    return response([1,2,3,4],200);   
});

Route::get('/categories', 'ApiController@getCategories');

Route::get('/category-videos/{age_id}/{id}', 'ApiController@getCategoryVideos');

Route::get('search/{age_id}/{query}', 'ApiController@getSearchResults');

Route::post('/login', 'ApiController@login');


Route::post('/register', 'ApiController@register');

Route::post('/search', 'ApiController@getSearchPostResults');

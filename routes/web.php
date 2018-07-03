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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/login', 'Auth\LoginController@showLoginForm');

Route::post('/login', 'Auth\LoginController@login')->name('login');

Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/reset', 'Auth\ResetPasswordController@showChangeForm');

Route::post('/reset', 'Auth\ResetPasswordController@changePassword')->name('reset');

Route::get('/home', 'HomeController@manageCategory')->name('home');

Route::post('/add-category',['as'=>'add.category','uses'=>'CategoryController@addCategory']);

Route::get('/remove-category/{id}',['as'=>'remove.category','uses'=>'CategoryController@removeCategory']);

Route::get('/get-videos/{age_id}/{category_id}', ['as'=>'get.videos','uses'=>'VideosController@getVideos']);

Route::get('/remove-video/{id}', ['as'=>'remove.video','uses'=>'VideosController@removeVideo']);

Route::post('/to-category', ['as'=>'to.category','uses'=>'VideosController@addVideos']);

Route::get('download-url/{id}', 'YoutubeController@result');

Route::post('upload-video', 'YoutubeController@uploadVideo');

Route::post('update-video', 'VideosController@updateVideo');

Route::get('edit-video/{id}', 'VideosController@editVideo');

Route::post('upload-myvideo', 'YoutubeController@uploadMyVideo');

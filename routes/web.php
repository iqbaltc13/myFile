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
Route::get('/dashboard', function () {
    return view('layouts.dashboard');
});
Route::group(['prefix'=>'errors'],function(){
    Route::get('error500','Helpers\WebHelperController@error500')->name('error.500');
    Route::get('error404','Helpers\WebHelperController@error404')->name('error.404');
});

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['auth'] ], function() {
    Route::group(['prefix' => 'upload'], function () {
        Route::post('file', "Api\V1\UploadFileController@uploadFile")->name('upload_file');
    });
    Route::group(['prefix' => 'dashboard', 'namespace' => 'Dashboard'], function() {
        
        
        
        Route::group(['prefix' => 'config', 'as' =>'dashboard.config.'], function () {
            Route::get('log', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->name('log');
        });
    });
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



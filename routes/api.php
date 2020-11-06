<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['prefix' => 'v1', 'namespace' => 'Api\V1'], function() {
    Route::group(['prefix' => 'autentikasi', 'namespace' => 'Autentikasi'], function() {
        Route::post('signin', 'AutentikasiController@signin');
        Route::post('signin-bypass', 'AutentikasiController@signinBypass');
        Route::post('signout', 'AutentikasiController@signout')->middleware('auth:api');
        Route::post('signup', 'AutentikasiController@signup');
        Route::post('signup-confirmation', 'AutentikasiController@signupConfirmation');
        Route::post('reset-password', 'AutentikasiController@resetPassword');
        Route::post('reset-password-confirmation', 'AutentikasiController@resetPasswordConfirmation');
        Route::get('all-user', 'AutentikasiController@allUser');
    });
    Route::group(['prefix' => 'confirmation', 'namespace' => 'Autentikasi'], function() {
        Route::post('send', 'ConfirmationController@send');
        Route::post('verify', 'ConfirmationController@verify');
    });
    Route::group(['prefix' => 'cryptography'], function() {
        Route::post('encrypt', 'CryptographyController@encrypt');
        Route::post('decrypt', 'CryptographyController@decrypt');
        Route::post('test', 'CryptographyController@test')->middleware('api.decrypt');
    });
    Route::group(['prefix' => 'profile', 'middleware' => 'auth:api', 'namespace' => 'Profile'], function() {
        Route::get('get', 'ProfileController@get');
        Route::post('update', 'ProfileController@update');
        Route::post('change-password', 'ProfileController@changePassword');
    });
    Route::group(['prefix' => 'file', 'middleware' => 'auth:api', 'namespace' => 'File'], function() {
        Route::post('upload', 'FileController@upload');
        Route::get('myfiles', 'FileController@myFiles');
    });
    Route::group(['prefix' => 'record', 'middleware' => 'auth:api', 'namespace' => 'UserRecord'], function() {
        Route::post('gets', 'UserRecordController@gets');
    });

    Route::post('upload-image', "UploadFileController@uploadFile")->middleware('auth:api');
});

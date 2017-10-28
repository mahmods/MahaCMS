<?php
Route::group([
    'namespace' => 'MahaCMS\Profile\Controllers',
    'middleware' => 'MahaCMS.auth'
], function () {
    Route::get('api/profile', 'ProfileController@getProfile');
    Route::post('api/profile', 'ProfileController@updateProfile');
});
<?php
Route::group([
    'namespace' => 'MahaCMS\Users\Controllers',
    'middleware' => 'MahaCMS.auth'
], function () {
    Route::get('api/user/permissions', 'AuthController@getPermissions');
});

Route::group([
    'namespace' => 'MahaCMS\Users\Controllers',
], function () {
    Route::post('api/login', 'AuthController@login');
    Route::post('api/register', 'AuthController@register');
    Route::post('api/logout', 'AuthController@logout');
});
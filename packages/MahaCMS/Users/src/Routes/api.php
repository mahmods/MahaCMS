<?php
Route::group([
    'namespace' => 'MahaCMS\Users\Controllers',
    'middleware' => 'MahaCMS.auth'
], function () {
    Route::get('api/user/permissions', 'AuthController@getPermissions');
    Route::get('api/users/{id}/roles', 'UserController@manageRoles');
    Route::post('api/users/{id}/roles', 'UserController@updateRoles');
    Route::resource('api/users', 'UserController');
});

Route::group([
    'namespace' => 'MahaCMS\Users\Controllers',
], function () {
    Route::post('api/login', 'AuthController@login');
    Route::post('api/register', 'AuthController@register');
    Route::get('api/logout', 'AuthController@logout');
});
<?php

Route::group([
    'namespace' => 'MahaCMS\Permissions\Controllers',
    'middleware' => 'MahaCMS.auth'
], function () {
    Route::get('api/permissions', 'PermissionController@index');
});
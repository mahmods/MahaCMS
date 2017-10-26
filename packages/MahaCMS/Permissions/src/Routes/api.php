<?php

Route::group([
    'namespace' => 'MahaCMS\Permissions\Controllers',
    'middleware' => 'MahaCMS.auth'
], function () {
    Route::resource('api/permissions', 'PermissionController');
});
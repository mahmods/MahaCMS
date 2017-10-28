<?php
Route::group([
    'namespace' => 'MahaCMS\Roles\Controllers',
    'middleware' => 'MahaCMS.auth'
], function () {
    Route::get('api/roles/{role}/permissions', 'RoleController@managePermissions');
    Route::post('api/roles/{role}/permissions', 'RoleController@updatePermissions');
    Route::get('api/roles/{role}/delete', 'RoleController@confirmDelete');
    Route::resource('api/roles', 'RoleController');
});
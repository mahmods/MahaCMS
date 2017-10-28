<?php
Route::group([
    'namespace' => 'MahaCMS\Settings\Controllers',
    'middleware' => 'MahaCMS.auth'
], function () {
    Route::get('api/settings', 'SettingController@getSettings');
    Route::post('api/settings', 'SettingController@updateSettings');
});
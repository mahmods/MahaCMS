<?php
 Route::group([
     'namespace' => 'MahaCMS\MahaCMS\Controllers',
     'middleware' => 'MahaCMS.auth'
 ], function () {
     Route::get('api/menu', 'PackagesController@all');
     Route::resource('api/pages', 'PagesController');
 });
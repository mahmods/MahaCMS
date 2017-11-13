<?php
use Illuminate\Http\Request;
 Route::group([
     'namespace' => 'MahaCMS\MahaCMS\Controllers',
     'middleware' => 'MahaCMS.auth'
 ], function () {
     Route::get('api/menu', 'PackagesController@all');
     Route::get('api/nav', 'NavigationController@get');
     Route::post('api/nav', 'NavigationController@update');
     Route::resource('api/pages', 'PagesController');
 });
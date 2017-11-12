<?php
use Illuminate\Http\Request;
 Route::group([
     'namespace' => 'MahaCMS\MahaCMS\Controllers',
     'middleware' => 'MahaCMS.auth'
 ], function () {
     Route::get('api/menu', 'PackagesController@all');
     Route::resource('api/pages', 'PagesController');
     Route::get('api/nav', function () {
         return DB::table('nav')->select(['name', 'url'])->get();
     });
     Route::post('api/nav', function(Request $request) {
         $newNav = $request->all();
         DB::table('nav')->truncate();
         DB::table('nav')->insert($request->all());
     });
 });
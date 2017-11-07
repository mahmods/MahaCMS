<?php
Route::group([
    'namespace' => 'MahaCMS\CRUD\Controllers',
    'middleware' => 'MahaCMS.auth'
], function () {
    Route::get('api/CRUD', 'CRUDController@tables');
    Route::get('api/CRUD/{table}', 'CRUDController@rows');
    Route::get('api/CRUD/{table}/create', 'CRUDController@create');
    Route::post('api/CRUD/{table}', 'CRUDController@store');
    Route::get('api/CRUD/{table}/{key}', 'CRUDController@show');
    Route::get('api/CRUD/{table}/{key}/edit', 'CRUDController@edit');
    Route::put('api/CRUD/{table}/{key}', 'CRUDController@update');
    Route::get('api/CRUD/{table}/{key}/delete', 'CRUDController@confirmDelete');
    Route::delete('api/CRUD/{table}/{key}', 'CRUDController@destroy');
});
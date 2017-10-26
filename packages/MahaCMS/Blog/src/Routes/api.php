<?php
Route::group([
    'namespace' => 'MahaCMS\Blog\Controllers'
], function () {
    Route::get('api/posts', 'PostController@index');
    Route::get('api/posts/create', 'PostController@create');
    Route::post('api/posts/', 'PostController@store');
    Route::get('api/posts/{id}/edit', 'PostController@edit');
    Route::put('api/posts/{id}', 'PostController@update');
    Route::delete('api/posts/{id}', 'PostController@destroy');
});
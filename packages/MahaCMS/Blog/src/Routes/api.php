<?php
Route::group([
    'namespace' => 'MahaCMS\Blog\Controllers',
], function () {
    Route::get('api/posts/query', 'PostController@query');
    Route::get('api/posts/{id}', 'PostController@show');
});

Route::group([
    'namespace' => 'MahaCMS\Blog\Controllers',
    'middleware' => 'MahaCMS.auth'
], function () {
    Route::resource('api/posts', 'PostController');
    Route::resource('api/categories', 'CategoryController');
});
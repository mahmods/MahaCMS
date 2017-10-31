<?php
Route::group([
    'namespace' => 'MahaCMS\Blog\Controllers',
    'middleware' => 'MahaCMS.auth'
], function () {
    Route::get('api/posts/query', 'PostController@query');
    Route::resource('api/posts', 'PostController');
    Route::resource('api/categories', 'CategoryController');
});
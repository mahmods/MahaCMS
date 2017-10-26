<?php

Route::group([
        'namespace'  => 'MahaCMS\Dashboard\Controllers',
    ], function () {
        Route::get('/dashboard', 'DashboardController@index');
    });
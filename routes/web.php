<?php

Route::get('{all}', function () {
    return view('VueApp');
})->where('all', '^((?!api).)*');

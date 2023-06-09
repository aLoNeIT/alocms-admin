<?php

use think\facade\Route;

Route::get(':version/index', ':version.Index/index');

Route::group(':version/file', function () {
    Route::get('local$', ':version.File/local_read');
    Route::get(':id', ':version.File/read');
})->pattern(['id' => '\d+']);

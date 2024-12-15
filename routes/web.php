<?php

use Illuminate\Support\Facades\Route;

Route::prefix('/api')->group(function () {
    Route::group([], base_path('src/Company/UI/Http/api.php'));
});

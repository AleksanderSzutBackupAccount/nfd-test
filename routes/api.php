<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::prefix('/')->group(function () {
    Route::group([], base_path('src/Company/UI/Http/api.php'));
    Route::group([], base_path('src/CompanyEmployee/UI/Http/api.php'));
});

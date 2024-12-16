<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Src\Company\UI\Http\Controllers\CompanyController;

Route::prefix('companies')->group(function () {
    Route::post('/', [CompanyController::class, 'create']);
    Route::get('/', [CompanyController::class, 'index']);
    Route::get('/{id}', [CompanyController::class, 'get']);
    Route::put('/{id}', [CompanyController::class, 'update']);
    Route::delete('/{id}', [CompanyController::class, 'delete']);
});

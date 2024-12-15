<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Src\Company\UI\Http\Controllers\CompanyController;
use Src\Company\UI\Http\Controllers\EmployeeController;

Route::prefix('companies')->group(function () {
    Route::post('/', [CompanyController::class, 'create']);
    Route::get('/', [CompanyController::class, 'index']);
    Route::get('/{id}', [CompanyController::class, 'get']);
    Route::put('/{id}', [CompanyController::class, 'update']);
    Route::delete('/{id}', [CompanyController::class, 'delete']);

    Route::prefix('{companyId}/employees')->group(function () {
        Route::post('/', [EmployeeController::class, 'create']);
        Route::get('/', [EmployeeController::class, 'index']);
        Route::get('/{id}', [EmployeeController::class, 'get']);
        Route::put('/{id}', [EmployeeController::class, 'update']);
        Route::delete('/{id}', [EmployeeController::class, 'delete']);
    });
});

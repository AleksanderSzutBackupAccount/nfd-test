<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Src\CompanyEmployee\UI\Http\Controllers\EmployeeController;

Route::prefix('companies/{companyId}/employees')->group(function () {
    Route::post('/', [EmployeeController::class, 'create']);
    Route::get('/', [EmployeeController::class, 'index']);
    Route::get('/{id}', [EmployeeController::class, 'get']);
    Route::put('/{id}', [EmployeeController::class, 'update']);
    Route::delete('/{id}', [EmployeeController::class, 'delete']);
});

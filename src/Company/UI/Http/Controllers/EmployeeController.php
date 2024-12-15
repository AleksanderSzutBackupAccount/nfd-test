<?php

declare(strict_types=1);

namespace Src\Company\UI\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Company\Infrastructure\Eloquent\EmployeeEloquentModel;

final class EmployeeController extends Controller
{
    public function index(int $companyId)
    {
        return EmployeeEloquentModel::query()->where('company_id', $companyId)->get();
    }

    public function create(Request $request, int $companyId)
    {
        $validated = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:employees',
            'phone' => 'nullable|string',
        ]);

        $validated['company_id'] = $companyId;

        return EmployeeEloquentModel::query()->create($validated);
    }

    public function get(int $companyId, int $id)
    {
        return EmployeeEloquentModel::query()->findOrFail($id);
    }

    public function update(Request $request, int $companyId, int $id)
    {
        $employee = EmployeeEloquentModel::query()->findOrFail($id);
        $validated = $request->validate([
            'first_name' => 'string',
            'last_name' => 'string',
            'email' => 'email|unique:employees,email,'.$employee->id,
            'phone' => 'nullable|string',
        ]);
        $employee->update($validated);

        return $employee;
    }

    public function delete(int $companyId, int $id)
    {
        $employee = EmployeeEloquentModel::query()->findOrFail($id);
        $employee->deleteOrFail();
    }
}

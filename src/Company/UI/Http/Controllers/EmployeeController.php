<?php

declare(strict_types=1);

namespace Src\Company\UI\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Company\Infrastructure\Eloquent\Models\EmployeeEloquentModel;

final class EmployeeController extends Controller
{
    public function index(string $companyId)
    {
        return EmployeeEloquentModel::query()->where('company_id', $companyId)->get();
    }

    public function create(Request $request, string $companyId)
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

    public function get(string $companyId, string $id)
    {
        return EmployeeEloquentModel::query()->findOrFail($id);
    }

    public function update(Request $request, string $companyId, string $id)
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

    public function delete(string $companyId, string $id)
    {
        $employee = EmployeeEloquentModel::query()->findOrFail($id);
        $employee->deleteOrFail();
    }
}

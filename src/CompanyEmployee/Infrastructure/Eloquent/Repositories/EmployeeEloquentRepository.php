<?php

declare(strict_types=1);

namespace Src\CompanyEmployee\Infrastructure\Eloquent\Repositories;

use Src\Company\Domain\ValueObjects\CompanyId;
use Src\CompanyEmployee\Domain\Employee;
use Src\CompanyEmployee\Domain\EmployeeRepositoryInterface;
use Src\CompanyEmployee\Domain\Employees;
use Src\CompanyEmployee\Domain\Exceptions\EmployeeNotFound;
use Src\CompanyEmployee\Domain\ValueObjects\EmployeeId;
use Src\CompanyEmployee\Infrastructure\Eloquent\Models\EmployeeEloquentModel;

final readonly class EmployeeEloquentRepository implements EmployeeRepositoryInterface
{
    public function findAll(CompanyId $companyId): Employees
    {
        $models = EmployeeEloquentModel::query()->where('company_id', $companyId)->get();

        $employees = new Employees([]);

        foreach ($models as $employee) {
            $employees->push($employee->toEntity());
        }

        return $employees;
    }

    public function findById(EmployeeId $id): ?Employee
    {
        $employee = EmployeeEloquentModel::query()->find($id);
        if ($employee === null) {
            return null;
        }

        return $employee->toEntity();
    }

    public function save(Employee $employee): void
    {
        EmployeeEloquentModel::query()->create([
            'id' => $employee->id->value,
            'first_name' => $employee->firstName->value,
            'last_name' => $employee->lastName->value,
            'email' => $employee->email->value,
            'phone' => $employee->phone?->value,
            'company_id' => $employee->companyId->value,
        ]);
    }

    /**
     * @throws \Throwable
     */
    public function delete(EmployeeId $id): void
    {
        $employee = EmployeeEloquentModel::query()->find($id);

        if (! $employee) {
            throw new EmployeeNotFound($id);
        }

        $employee->deleteOrFail();
    }
}

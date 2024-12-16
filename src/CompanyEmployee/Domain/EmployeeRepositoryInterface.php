<?php

namespace Src\CompanyEmployee\Domain;

use Src\Company\Domain\ValueObjects\CompanyId;
use Src\CompanyEmployee\Domain\ValueObjects\EmployeeId;

interface EmployeeRepositoryInterface
{
    public function findAll(CompanyId $companyId): Employees;

    public function findById(EmployeeId $id): ?Employee;

    public function save(Employee $employee): void;

    public function delete(EmployeeId $id): void;
}

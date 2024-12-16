<?php

declare(strict_types=1);

namespace Src\CompanyEmployee\Application\Queries;

use Src\Company\Domain\ValueObjects\CompanyId;
use Src\CompanyEmployee\Domain\EmployeeRepositoryInterface;
use Src\CompanyEmployee\Domain\Employees;

final readonly class GetEmployeesQuery
{
    public function __construct(private EmployeeRepositoryInterface $repository) {}

    public function get(CompanyId $companyId): Employees
    {
        return $this->repository->findAll($companyId);
    }
}

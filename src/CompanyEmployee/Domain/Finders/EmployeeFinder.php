<?php

declare(strict_types=1);

namespace Src\CompanyEmployee\Domain\Finders;

use Src\CompanyEmployee\Domain\Employee;
use Src\CompanyEmployee\Domain\EmployeeRepositoryInterface;
use Src\CompanyEmployee\Domain\Exceptions\EmployeeNotFound;
use Src\CompanyEmployee\Domain\ValueObjects\EmployeeId;

final readonly class EmployeeFinder
{
    public function __construct(private EmployeeRepositoryInterface $repository) {}

    /**
     * @throws EmployeeNotFound
     */
    public function find(EmployeeId $id): Employee
    {
        $employee = $this->repository->findById($id);

        if ($employee === null) {
            throw new EmployeeNotFound($id);
        }

        return $employee;
    }
}

<?php

declare(strict_types=1);

namespace Src\CompanyEmployee\Application\Queries;

use Src\CompanyEmployee\Domain\Employee;
use Src\CompanyEmployee\Domain\Finders\EmployeeFinder;
use Src\CompanyEmployee\Domain\ValueObjects\EmployeeId;

final readonly class FindEmployeeQuery
{
    public function __construct(private EmployeeFinder $finder) {}

    public function get(string $id): Employee
    {
        return $this->finder->find(new EmployeeId($id));
    }
}

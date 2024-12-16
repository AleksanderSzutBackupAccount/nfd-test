<?php

declare(strict_types=1);

namespace Src\CompanyEmployee\UI\Http\Resources;

use Illuminate\Http\Request;
use Src\CompanyEmployee\Domain\Employee;
use Src\CompanyEmployee\Domain\Employees;
use Src\Shared\UI\Http\Resources\AbstractJsonResource;

final readonly class EmployeeResourceCollection extends AbstractJsonResource
{
    public function __construct(private Employees $employees) {}

    public function toArray(Request $request): array
    {
        return $this->employees->map(
            fn (Employee $company) => (new EmployeeResource($company))
        );

    }
}

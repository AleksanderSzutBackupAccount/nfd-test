<?php

declare(strict_types=1);

namespace Src\CompanyEmployee\UI\Http\Resources;

use Illuminate\Http\Request;
use Src\CompanyEmployee\Domain\Employee;
use Src\Shared\UI\Http\Resources\AbstractJsonResource;

final readonly class EmployeeResource extends AbstractJsonResource
{
    public function __construct(private Employee $employee) {}

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->employee->id,
            'first_name' => $this->employee->firstName,
            'last_name' => $this->employee->lastName,
            'email' => $this->employee->email,
            'phone' => $this->employee->phone,
        ];
    }
}

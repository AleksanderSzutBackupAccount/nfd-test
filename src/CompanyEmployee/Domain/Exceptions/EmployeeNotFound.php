<?php

declare(strict_types=1);

namespace Src\CompanyEmployee\Domain\Exceptions;

use Src\CompanyEmployee\Domain\ValueObjects\EmployeeId;
use Src\Shared\Domain\Exceptions\DomainError;

final class EmployeeNotFound extends DomainError
{
    public function __construct(private readonly EmployeeId $id)
    {
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'employee_not_found';
    }

    protected function errorMessage(): string
    {
        return sprintf('The employee <%s> has not been found', $this->id->value());
    }
}

<?php

declare(strict_types=1);

namespace Src\CompanyEmployee\Domain;

use Src\Shared\Domain\Collection\Collection;

/**
 * @extends Collection<Employee>
 */
final class Employees extends Collection
{
    protected function type(): string
    {
        return Employee::class;
    }
}

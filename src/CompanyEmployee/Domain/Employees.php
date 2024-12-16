<?php

declare(strict_types=1);

namespace Src\CompanyEmployee\Domain;

use Src\Company\Domain\Company;
use Src\Shared\Domain\Collection\Collection;

/**
 * @extends Collection<Company>
 */
final class Employees extends Collection
{
    protected function type(): string
    {
        return Company::class;
    }
}

<?php

declare(strict_types=1);

namespace Src\Company\Domain\Collections;

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

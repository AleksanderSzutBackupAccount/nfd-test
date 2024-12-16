<?php

declare(strict_types=1);

namespace Src\CompanyEmployee\Domain\Events;

use Src\CompanyEmployee\Domain\ValueObjects\EmployeeId;
use Src\Shared\Domain\Bus\DomainEvent;

final readonly class EmployeeUpdatedEvent implements DomainEvent
{
    public function __construct(public EmployeeId $id) {}
}

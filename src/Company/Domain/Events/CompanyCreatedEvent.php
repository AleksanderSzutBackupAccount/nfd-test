<?php

declare(strict_types=1);

namespace Src\Company\Domain\Events;

use Src\Company\Domain\ValueObjects\CompanyId;
use Src\Shared\Domain\Bus\DomainEvent;

final readonly class CompanyCreatedEvent implements DomainEvent
{
    public function __construct(public CompanyId $id) {}
}

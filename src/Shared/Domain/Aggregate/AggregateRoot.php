<?php

declare(strict_types=1);

namespace Src\Shared\Domain\Aggregate;

use Src\Shared\Domain\Bus\DomainEvent;

abstract class AggregateRoot
{
    /**
     * @var DomainEvent[]
     */
    private array $domainEvents = [];

    /**
     * @return DomainEvent[]
     */
    final public function pullDomainEvents(): array
    {
        $domainEvents = $this->domainEvents;
        $this->domainEvents = [];

        return $domainEvents;
    }

    final protected function record(DomainEvent $domainEvent): void
    {
        $this->domainEvents[] = $domainEvent;
    }
}

<?php

declare(strict_types=1);

namespace Src\Shared\Domain\ValueObjects;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid;
use Src\Shared\Domain\ComparableInterface;
use Stringable;

abstract readonly class UuidValueObject implements ComparableInterface, Stringable, ValueObjectInterface
{
    final public function __construct(public string $uuid)
    {
        $this->validate();
    }

    public function __toString(): string
    {
        return $this->uuid;
    }

    public function value(): string
    {
        return $this->uuid;
    }

    public static function fromString(string $uuid): static
    {
        return new static($uuid);
    }

    public function validate(): void
    {
        if (! preg_match('/^[a-f\d]{8}(-[a-f\d]{4}){4}[a-f\d]{8}$/i', $this->uuid)) {
            throw new InvalidArgumentException('Invalid UUID');
        }
    }

    public static function generate(): static
    {
        return new static(Uuid::uuid4()->toString());
    }

    /**
     * @param  self  $compare
     */
    public function equals(ComparableInterface $compare): bool
    {
        return $this->uuid === $compare->uuid;
    }
}

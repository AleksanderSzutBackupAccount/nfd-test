<?php

declare(strict_types=1);

namespace Src\Shared\Domain\Exceptions;

use Exception;
use Throwable;

abstract class DomainException extends Exception
{
    public function __construct(?Throwable $previous = null, int $code = 0)
    {
        parent::__construct($this->message(), $code, $previous);
    }

    abstract protected function message(): string;
}

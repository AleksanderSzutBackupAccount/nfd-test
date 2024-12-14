<?php

declare(strict_types=1);

namespace Src\Shared\Domain;

interface ComparableInterface
{
    /**
     * @param ComparableInterface $compare
     * @return bool
     */
    public function equals(self $compare): bool;
}

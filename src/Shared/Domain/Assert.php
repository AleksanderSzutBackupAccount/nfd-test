<?php

declare(strict_types=1);

namespace Src\Shared\Domain;

use InvalidArgumentException;

final class Assert
{
    /**
     * @param string $class
     * @param array<object> $items
     * @return void
     */
    public static function arrayOf(string $class, array $items): void
    {
        foreach ($items as $item) {
            self::instanceOf($class, $item);
        }
    }

    /**
     * @param string $class
     * @param object $item
     * @return void
     */
    public static function instanceOf(string $class, object $item): void
    {
        if (!$item instanceof $class) {
            throw new InvalidArgumentException(sprintf('The object <%s> is not an instance of <%s>', $class, get_class($item)));
        }
    }
}

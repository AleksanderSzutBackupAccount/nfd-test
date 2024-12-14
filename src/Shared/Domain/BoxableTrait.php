<?php

declare(strict_types=1);

namespace Src\Shared\Domain;

use BackedEnum;
use InvalidArgumentException;

/**
 * @template T as object
 */
trait BoxableTrait
{
    /**
     * @param mixed $params
     * @return T
     */
    public function box(mixed $params): object
    {
        if (is_array($params)) {
            return $this->boxComplex($params);
        }

        return $this->boxSimple($params);
    }

    /**
     * @param mixed $params
     * @return T
     */
    public function boxSimple(mixed $params): object
    {
        $class = $this->type();

        return new $class($params);
    }

    /**
     * @param array<int, mixed> $params
     * @return T
     */
    public function boxComplex(array $params): object
    {
        $class = $this->type();

        return new $class(...$params);
    }

    /**
     * @param T $item
     * @return mixed
     */
    public function unbox(object $item): mixed
    {
        if (method_exists($item, 'unbox')) {
            return $item->unbox();
        }
        $unboxed = (array)$item;
        if (count($unboxed) === 1) {
            return array_values($unboxed)[0];
        }

        return array_values($unboxed);
    }

    /**
     * @param T $item
     * @return mixed
     */
    public function unboxSimple(object $item): mixed
    {
        if (method_exists($item, 'unbox')) {
            return $item->unbox();
        }
        $unboxed = (array)$item;

        return array_values($unboxed)[0];
    }

    /**
     * @param T $item
     * @return mixed[]
     */
    public function unboxComplex(object $item): mixed
    {
        if (method_exists($item, 'unbox')) {
            return $item->unbox();
        }

        return array_values((array)$item);
    }

    /**
     * @return class-string<T>
     */
    abstract protected function type(): string;

    /**
     * @param int|string $params
     * @return T
     */
    final protected function boxEnumValue(mixed $params): object
    {
        $class = $this->type();
        if (!is_subclass_of($class, BackedEnum::class)) {
            throw new InvalidArgumentException('Parameter $class must be instance of \BackedEnum');
        }

        return $class::from($params);
    }
}

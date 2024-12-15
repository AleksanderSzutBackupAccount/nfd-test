<?php

declare(strict_types=1);

namespace Src\Shared\Domain\Collection;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Src\Shared\Domain\Assert;
use Src\Shared\Domain\BoxableTrait;
use Src\Shared\Domain\ComparableCollectionInterface;
use Src\Shared\Domain\ComparableInterface;

/**
 * @template T as object
 * @implements IteratorAggregate<int, T>
 */
abstract class Collection implements Countable, IteratorAggregate
{
    /** @use BoxableTrait<T> */
    use BoxableTrait;

    /**
     * @var T[] $items
     */
    private array $items;

    /**
     * @param T[] $items
     */
    final public function __construct(array $items)
    {
        $this->items = $items;
        Assert::arrayOf($this->type(), $items);
    }

    /**
     * @return ArrayIterator<int, T>
     */
    final public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->items());
    }

    /**
     * @param int $index
     * @return T
     */
    final public function get(int $index): object
    {
        return $this->items[$index];
    }

    /**
     * @return T|null
     */
    final public function first(): ?object
    {
        return $this->items[0] ?? null;
    }

    /**
     * @return T|null
     */
    final public function last(): ?object
    {
        return $this->items[$this->count() - 1] ?? null;
    }

    /**
     * @param int $index
     * @return void
     */
    final public function remove(int $index): void
    {
        unset($this->items[$index]);
    }

    /**
     * use for one or multiple (array of) arguments in constructor
     * @param array<int, mixed> $items
     * @return static
     */
    final public static function boxFromArray(array $items): static
    {
        $collection = new static([]);

        foreach ($items as $item) {
            $object = $collection->box($item);
            $collection->push($object);
        }

        return $collection;
    }

    /**
     * use for one or multiple Enum values
     * @param array<string|int> $items
     * @return static
     */
    final public static function boxFromEnumValues(array $items): static
    {
        $collection = new static([]);

        foreach ($items as $item) {
            $object = $collection->boxEnumValue($item);
            $collection->push($object);
        }

        return $collection;
    }

    /**
     * use for one argument in constructor
     * @param array<int, mixed> $items
     * @return static
     */
    final public static function boxSimpleFromArray(array $items): static
    {
        $collection = new static([]);

        foreach ($items as $item) {
            $object = $collection->boxSimple($item);
            $collection->push($object);
        }

        return $collection;
    }

    /**
     * use for multiple (array of) arguments in constructor
     * @param array<int, array<int, mixed>> $items
     * @return static
     */
    final public static function boxComplexFromArray(array $items): static
    {
        $collection = new static([]);

        foreach ($items as $item) {
            $object = $collection->boxComplex($item);
            $collection->push($object);
        }

        return $collection;
    }

    /**
     * @return array<int, mixed>
     */
    final public function unboxToArray(): array
    {
        return $this->map(fn ($item) => $this->unbox($item));
    }

    /**
     * @return array<int, mixed>
     */
    final public function unboxSimpleToArray(): array
    {
        return $this->map(fn ($item) => $this->unboxSimple($item));
    }

    /**
     * @return array<int, mixed>
     */
    final public function unboxComplexToArray(): array
    {
        return $this->map(fn ($item) => $this->unboxComplex($item));
    }

    /**
     * @param callable(T): mixed $closure
     * @return array<int, mixed>
     */
    final public function map(callable $closure): array
    {
        return array_map($closure, $this->items);
    }

    /**
     * @param callable(T): T $closure
     * @return static
     */
    final public function mapSelf(callable $closure): static
    {
        /** @var T[] $items */
        $items = $this->map($closure);

        return new static($items);
    }

    /**
     * @param callable(T):bool $closure
     * @return static
     */
    final public function filter(callable $closure): static
    {
        return new static(array_values(array_filter($this->items, $closure)));
    }

    /**
     * @param null|callable(T, T):bool $comparator
     * @return static
     */
    public function unique(?callable $comparator = null): static
    {
        $items = new static([]);

        foreach ($this as $item) {
            $find = $items->contains($item, $comparator);
            if (!$find) {
                $items->push($item);
            }
        }

        return $items;
    }

    /**
     * @param T $item
     * @param null|callable(T, T):bool $comparator
     * @return bool
     */
    final public function contains(object $item, ?callable $comparator = null): bool
    {
        return $this->some(fn ($searchable) => $this->comparator($searchable, $item, $comparator));
    }

    /**
     * @param callable(T, int):bool $closure
     * @return ?T
     */
    final public function find(callable $closure): ?object
    {
        foreach ($this->items as $index => $item) {
            if ($closure($item, $index)) {
                return $item;
            }
        }

        return null;
    }

    final public function count(): int
    {
        return count($this->items());
    }

    /**
     * @param callable(T, int): bool $callable
     */
    final public function some(callable $callable): bool
    {
        foreach ($this->items as $index => $item) {
            if ($callable($item, $index)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param callable(T, int): bool $callable
     */
    final public function every(callable $callable): bool
    {
        foreach ($this->items as $index => $item) {
            if (!$callable($item, $index)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param ?T $item
     */
    final public function push(mixed $item): void
    {
        if ($item === null) {
            return;
        }
        Assert::instanceOf($this->type(), $item);
        $this->items[] = $item;
    }

    /**
     * @param static $collection
     * @return static
     */
    final public function merge(self $collection): static
    {
        return new static(array_merge($this->items, $collection->items));
    }

    /** @return  array<int, T>  */
    public function items(): array
    {
        return $this->items;
    }

    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }

    final public function isEqual(self $collection): bool
    {
        if ($this->count() !== $collection->count()) {
            return false;
        }

        return $this->every(
            fn (object $item) => $collection->find(
                fn (object $currentItem) => $item == $currentItem
            ) !== null
        );
    }

    final public function isEqualWithOrder(self $collection): bool
    {
        if ($this->count() !== $collection->count()) {
            return false;
        }

        return $this->every(fn (object $item, int $index) => $item == $collection->items[$index]);
    }

    /**
     * @return class-string<T>
     */
    abstract protected function type(): string;

    /**
     * @param T $item
     * @param T $item2
     * @param null|callable(T, T):bool $closure
     * @return bool
     */
    private function comparator(object $item, object $item2, ?callable $closure = null): bool
    {
        if ($closure) {
            return $closure($item, $item2);
        }

        if ($this instanceof ComparableCollectionInterface) {
            return $this->compare($item, $item2);
        }

        if (is_subclass_of($this->type(), ComparableInterface::class)) {
            /**
             * @var ComparableInterface&T $item
             * @var ComparableInterface&T $item2
             */
            return $item->equals($item2);
        }

        return $item2 == $item;
    }
}

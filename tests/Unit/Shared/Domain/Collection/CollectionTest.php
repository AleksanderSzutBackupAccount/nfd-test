<?php

declare(strict_types=1);

namespace Tests\Unit\Shared\Domain\Collection;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Shared\Domain\Collection\Dummies\DummyArrayCollection;
use Tests\Unit\Shared\Domain\Collection\Dummies\DummyCollection;
use Tests\Unit\Shared\Domain\Collection\Dummies\DummyEnum;
use Tests\Unit\Shared\Domain\Collection\Dummies\DummyEnumCollection;
use Tests\Unit\Shared\Domain\Collection\Dummies\DummyItem;
use Tests\Unit\Shared\Domain\Collection\Dummies\DummyItemArray;
use Tests\Unit\Shared\Domain\Collection\Dummies\DummySecondCollection;
use Tests\Unit\Shared\Domain\Collection\Dummies\DummySecondItem;
use stdClass;

class CollectionTest extends TestCase
{
    public function testConstructFailedOnInvalidType(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new DummyCollection([new stdClass()]);
    }

    public function testCount(): void
    {
        $expectedCount = 3;

        $collection = new DummyCollection([
            new DummyItem(0),
            new DummyItem(1),
            new DummyItem(2),
        ]);
        $this->assertEquals($expectedCount, $collection->count());
    }

    public function testSomeReturnTrue(): void
    {
        $valueToFind = 4;

        $collection = new DummyCollection([
            new DummyItem(0),
            new DummyItem(1),
            new DummyItem(2),
            new DummyItem($valueToFind),
        ]);

        $this->assertTrue($collection->some(fn (DummyItem $item) => $item->value === $valueToFind));
    }

    public function testSomeReturnFalse(): void
    {
        $notExistingValueInCollection = 10;

        $collection = new DummyCollection([
            new DummyItem(0),
            new DummyItem(1),
            new DummyItem(2),
            new DummyItem(4),
        ]);

        $this->assertFalse($collection->some(fn (DummyItem $item) => $item->value === $notExistingValueInCollection));
    }

    public function testEveryReturnTrue(): void
    {
        $collection = new DummyCollection([
            new DummyItem(1),
            new DummyItem(2),
            new DummyItem(3),
            new DummyItem(4),
        ]);

        $this->assertTrue($collection->some(fn (DummyItem $item) => $item->value !== 0));
    }

    public function testEveryReturnFalse(): void
    {
        $collection = new DummyCollection([
            new DummyItem(0),
            new DummyItem(1),
            new DummyItem(2),
            new DummyItem(3),
        ]);

        $this->assertTrue($collection->some(fn (DummyItem $item) => $item->value !== 0));
    }

    public function testIsEqualTrue(): void
    {
        $sameValue = 2;
        $firstCollection = new DummyCollection([new DummyItem($sameValue), new DummyItem($sameValue + 1)]);
        $secondCollection = new DummyCollection([new DummyItem($sameValue + 1), new DummyItem($sameValue)]);
        $this->assertTrue($firstCollection->isEqual($secondCollection));
    }

    public function testIsEqualWithOrderFalse(): void
    {
        $sameValue = 2;
        $firstCollection = new DummyCollection([new DummyItem($sameValue), new DummyItem($sameValue + 1)]);
        $secondCollection = new DummyCollection([new DummyItem($sameValue + 1), new DummyItem($sameValue)]);
        $this->assertFalse($firstCollection->isEqualWithOrder($secondCollection));
    }

    public function testIsEqualWithOrderTrue(): void
    {
        $sameValue = 2;
        $firstCollection = new DummyCollection([new DummyItem($sameValue + 1), new DummyItem($sameValue)]);
        $secondCollection = new DummyCollection([new DummyItem($sameValue + 1), new DummyItem($sameValue)]);
        $this->assertTrue($firstCollection->isEqualWithOrder($secondCollection));
    }

    public function testIsEqualFalse(): void
    {
        $firstCollection = new DummyCollection([new DummyItem(5)]);
        $secondCollection = new DummyCollection([new DummyItem(10)]);
        $this->assertFalse($firstCollection->isEqual($secondCollection));
    }

    public function testMap(): void
    {
        $itemValue = 5;
        $arrKey = 'testKey';
        $collection = new DummyCollection([new DummyItem($itemValue)]);
        $this->assertEquals([[$arrKey => $itemValue]], $collection->map(fn (DummyItem $item) => [$arrKey => $itemValue]));
    }

    public function testIsEmpty(): void
    {
        $emptyCollection = new DummyCollection([]);
        $this->assertTrue($emptyCollection->isEmpty());
    }

    public function testFilter(): void
    {
        $collection = new DummyCollection([
            new DummyItem(1),
            new DummyItem(2),
            new DummyItem(3),
            new DummyItem(4),
        ]);
        $expectedCollectionAfterFiltered = new DummyCollection([
            new DummyItem(2),
            new DummyItem(4),
        ]);

        $filteredCollection = $collection->filter(fn (DummyItem $item) => $item->value % 2 === 0);

        $this->assertTrue($filteredCollection->isEqual($expectedCollectionAfterFiltered));

    }

    public function testFindSuccess(): void
    {
        $findableValue = 25;

        $collection = new DummyCollection([
            new DummyItem(1),
            new DummyItem(2),
            new DummyItem($findableValue),
            new DummyItem(4),
        ]);

        $this->assertEquals($findableValue, $collection->find(fn (DummyItem $item) => $item->value === $findableValue)->value);
    }

    public function testFindNull(): void
    {
        $notExistingValue = 50;

        $collection = new DummyCollection([
            new DummyItem(1),
            new DummyItem(2),
            new DummyItem(3),
            new DummyItem(4),
        ]);

        $this->assertNull($collection->find(fn (DummyItem $item) => $item->value === $notExistingValue));
    }

    public function testMapSelfSuccess(): void
    {
        $collection = new DummyCollection([new DummyItem(2), new DummyItem(4)]);
        $mappedCollection = $collection->mapSelf(fn (DummyItem $dummyItem) => new DummyItem($dummyItem->value * 2));
        $this->assertEquals(4, $mappedCollection->get(0)->value);
        $this->assertEquals(8, $mappedCollection->get(1)->value);
    }

    public function testMapSelfFailedOnInvalidType(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $collection = new DummyCollection([new DummyItem(2)]);
        $collection->mapSelf(fn (DummyItem $dummyItem) => new stdClass());
    }

    public function testPush(): void
    {
        $collection = new DummyCollection([new DummyItem(0)]);
        $collection->push(new DummyItem(1));
        $this->assertCount(2, $collection);
    }

    public function testPushNotAddingNull(): void
    {
        $collection = new DummyCollection([new DummyItem(0)]);
        $collection->push(null);
        $this->assertCount(1, $collection);
    }

    public function testPushFailedOnInvalidType(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $collection = new DummyCollection([new DummyItem(0)]);
        $collection->push(new DummySecondItem(1));
    }

    public function testGet(): void
    {
        $collection = new DummyCollection([new DummyItem(0), new DummyItem(1), new DummyItem(2), new DummyItem(3)]);
        $this->assertEquals(3, $collection->get(3)->value);
    }

    public function testMerge(): void
    {
        $collection1 = new DummyCollection([new DummyItem(0), new DummyItem(1)]);
        $collection2 = new DummyCollection([new DummyItem(3), new DummyItem(4)]);
        $merged = $collection1->merge($collection2);
        $this->assertCount(4, $merged);
    }

    public function testMergeFailedOnInvalidType(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $collection1 = new DummyCollection([new DummyItem(0), new DummyItem(1)]);
        $collection2 = new DummySecondCollection([new DummySecondItem(2, 'a')]);
        $collection1->merge($collection2);
    }

    public function testRemove(): void
    {
        $expectedCount = 2;

        $collection = new DummyCollection([
            new DummyItem(0),
            new DummyItem(1),
            new DummyItem(2),
        ]);
        $collection->remove(1);

        $this->assertEquals($expectedCount, $collection->count());
    }

    public function testBoxFromArray(): void
    {
        $expectedCount = 3;

        $collection = DummyCollection::boxFromArray([
            0,
            1,
            2,
        ]);

        $this->assertEquals($expectedCount, $collection->count());
        $this->assertInstanceOf(DummyItem::class, $collection->get(0));
        $this->assertInstanceOf(DummyItem::class, $collection->get(1));
        $this->assertInstanceOf(DummyItem::class, $collection->get(2));
        $this->assertEquals(0, $collection->get(0)->value);
        $this->assertEquals(1, $collection->get(1)->value);
        $this->assertEquals(2, $collection->get(2)->value);
    }

    public function testBoxFromEnumValues(): void
    {
        $elements = [DummyEnum::SOMETHING->value, DummyEnum::SOMETHING2->value, DummyEnum::SOMETHING->value, DummyEnum::SOMETHING2->value];
        $newCollection = DummyEnumCollection::boxFromEnumValues($elements);
        $this->assertInstanceOf(DummyEnumCollection::class, $newCollection);
    }

    public function testBoxSimpleFromArray(): void
    {
        $expectedCount = 3;
        $array = [
            [0],
            [1, 2, 3],
            [2],
        ];

        $collection = DummyArrayCollection::boxSimpleFromArray($array);

        $this->assertEquals($expectedCount, $collection->count());
        $this->assertInstanceOf(DummyItemArray::class, $collection->get(0));
        $this->assertInstanceOf(DummyItemArray::class, $collection->get(1));
        $this->assertInstanceOf(DummyItemArray::class, $collection->get(2));
        $this->assertEquals([0], $collection->get(0)->value);
        $this->assertEquals([1, 2, 3], $collection->get(1)->value);
        $this->assertEquals([2], $collection->get(2)->value);
        $this->assertEquals($array, $collection->unboxSimpleToArray());
        $this->assertEquals(array_map(fn ($item) => [$item], $array), $collection->unboxComplexToArray());
        $this->assertEquals($array, $collection->unboxToArray());
    }

    public function testBoxComplexFromArray(): void
    {
        $array = [
            [0, 'a'],
            [1, 'b'],
            [2, 'c'],
        ];
        $collection = DummySecondCollection::boxComplexFromArray($array);
        $this->assertEquals($array, $collection->unboxComplexToArray());
        $this->assertEquals([0, 1, 2], $collection->unboxSimpleToArray());
        $this->assertEquals($array, $collection->unboxToArray());
    }

    public function testUnboxFromArray(): void
    {
        $array = [
            0,
            1,
            2,
        ];
        $collection = DummyCollection::boxFromArray($array);
        $this->assertEquals($array, $collection->unboxToArray());
    }

    public function testUnboxFromArrayComplex(): void
    {
        $array = [
            [0, 'a'],
            [1, 'b'],
            [2, 'c'],
        ];
        $collection = DummySecondCollection::boxFromArray($array);
        $this->assertEquals($array, $collection->unboxToArray());
    }

    public function testBoxFromArrayComplex(): void
    {
        $expectedCount = 3;

        $collection = DummySecondCollection::boxFromArray([
            [0, 'a'],
            [1, 'b'],
            [2, 'c'],
        ]);

        $this->assertEquals($expectedCount, $collection->count());
        $this->assertInstanceOf(DummySecondItem::class, $collection->get(0));
        $this->assertInstanceOf(DummySecondItem::class, $collection->get(1));
        $this->assertInstanceOf(DummySecondItem::class, $collection->get(2));
        $this->assertEquals(0, $collection->get(0)->value);
        $this->assertEquals(1, $collection->get(1)->value);
        $this->assertEquals(2, $collection->get(2)->value);
        $this->assertEquals('a', $collection->get(0)->second);
        $this->assertEquals('b', $collection->get(1)->second);
        $this->assertEquals('c', $collection->get(2)->second);
    }

    public function testFirst(): void
    {
        $first = new DummyItem(1);
        $middle = new DummyItem(2);
        $last = new DummyItem(3);
        $collection = new DummyCollection([
            $first,
            $middle,
            $last,
        ]);

        $this->assertEquals($first, $collection->first());
    }

    public function testLast(): void
    {
        $first = new DummyItem(1);
        $middle = new DummyItem(2);
        $last = new DummyItem(3);
        $collection = new DummyCollection([
            $first,
            $middle,
            $last,
        ]);

        $this->assertEquals($last, $collection->last());
    }

    public function testContainFind(): void
    {
        $collection = new DummyCollection([
            new DummyItem(0),
            new DummyItem(1),
            new DummyItem(2),
            new DummyItem(4),
        ]);

        $this->assertTrue($collection->contains(new DummyItem(0)));
    }

    public function testContainNotFind(): void
    {

        $collection = new DummyCollection([
            new DummyItem(0),
            new DummyItem(1),
            new DummyItem(2),
            new DummyItem(4),
        ]);

        $this->assertFalse($collection->contains(new DummyItem(10)));
    }
}

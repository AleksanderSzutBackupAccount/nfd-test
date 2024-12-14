<?php

declare(strict_types=1);

namespace Tests\Unit\Shared\Domain\Collection;

use Illuminate\Support\Str;
use InvalidArgumentException;
use Src\Shared\Domain\Collection;
use Src\Shared\Domain\ComparableCollectionInterface;
use Tests\Unit\Shared\Domain\Collection\Dummies\DummyComparableDto;
use Tests\Unit\Shared\Domain\Collection\Dummies\DummyDto;
use Tests\Unit\Shared\Domain\Collection\Dummies\DummyEntity;
use Tests\Unit\Shared\Domain\Collection\Dummies\DummyEnum;
use Tests\Unit\Shared\Domain\Collection\Dummies\DummyNestedDto;
use Tests\TestCase;

class UniqueCollectionTest extends TestCase
{
    public function test_unique_empty(): void
    {
        $elements = [];
        $collection = new class ($elements) extends Collection {
            protected function type(): string
            {
                return DummyDto::class;
            }
        };

        $this->assertEmpty($collection->unique());
    }

    public function test_unique_notEmpty(): void
    {
        $dummyDto = new DummyDto(Str::random());
        $anotherDummyDto = new DummyDto(Str::random());
        $elements = [$dummyDto, $dummyDto, $anotherDummyDto, $anotherDummyDto];

        $collection = new class ($elements) extends Collection {
            protected function type(): string
            {
                return DummyDto::class;
            }
        };
        $unique = $collection->unique();
        $this->assertCount(2, $unique);
        $this->assertEquals($dummyDto->value, $unique->get(0)->value);
        $this->assertEquals($anotherDummyDto->value, $unique->get(1)->value);
    }

    public function test_unique_notEmpty_enum(): void
    {
        $elements = [DummyEnum::SOMETHING, DummyEnum::SOMETHING2, DummyEnum::SOMETHING, DummyEnum::SOMETHING2];
        $collection = new class ($elements) extends Collection {
            protected function type(): string
            {
                return DummyEnum::class;
            }
        };
        $unique = $collection->unique();
        $this->assertCount(2, $unique);
        $this->assertContains(DummyEnum::SOMETHING, $unique);
        $this->assertContains(DummyEnum::SOMETHING2, $unique);
    }

    public function test_boxEnumValue_atNotEnumCollection(): void
    {
        $elements = [new DummyNestedDto(new DummyDto(Str::random()))];
        $collection = new class ($elements) extends Collection {
            protected function type(): string
            {
                return DummyNestedDto::class;
            }
        };
        $this->expectException(InvalidArgumentException::class);
        $collection::boxFromEnumValues($elements);
    }

    public function test_getUnique_withClosure(): void
    {
        $uniqueValue1 = Str::random();
        $uniqueValue2 = Str::random();
        $elements = [new DummyDto('test1', $uniqueValue1), new DummyDto('test2', $uniqueValue1), new DummyDto('test3', $uniqueValue2), new DummyDto('test4', $uniqueValue2)];
        $collection = new class ($elements) extends Collection {
            protected function type(): string
            {
                return DummyDto::class;
            }
        };
        $result = $collection->unique(fn (DummyDto $item, DummyDto $item2) => $item->optionalUnique === $item2->optionalUnique);
        $this->assertCount(2, $result);
        $this->assertEquals($uniqueValue1, $result->get(0)->optionalUnique);
        $this->assertEquals($uniqueValue2, $result->get(1)->optionalUnique);
    }

    public function test_getUnique_withComparable(): void
    {
        $elements = [new DummyEntity(1, 'test1'), new DummyEntity(2, 'test2'), new DummyEntity(1, 'test3'), new DummyEntity(2, 'test4')];
        $collection = new class ($elements) extends Collection implements ComparableCollectionInterface {
            protected function type(): string
            {
                return DummyEntity::class;
            }

            public function compare(object $object1, object $object2): bool
            {
                return $object2->id === $object1->id;
            }
        };
        $result = $collection->unique();
        $this->assertCount(2, $result);
        $this->assertEquals(1, $result->get(0)->id);
        $this->assertEquals(2, $result->get(1)->id);
    }

    public function test_unique_dummyComparableDto(): void
    {
        $elements = [new DummyComparableDto('test1', 'unique1'), new DummyComparableDto('test2', 'unique2'), new DummyComparableDto('test3', 'unique1'), new DummyComparableDto('test4', 'unique2')];
        $collection = new class ($elements) extends Collection {
            protected function type(): string
            {
                return DummyComparableDto::class;
            }
        };
        $result = $collection->unique();
        $this->assertCount(2, $result);
        $this->assertTrue($elements[0]->equals($result->get(0)));
        $this->assertTrue($elements[1]->equals($result->get(1)));
    }

    public function test_unique_dummyComparableDto_empty(): void
    {
        $elements = [];
        $collection = new class ($elements) extends Collection {
            protected function type(): string
            {
                return DummyComparableDto::class;
            }
        };
        $result = $collection->unique()->unboxToArray();
        $this->assertEmpty($result);
    }
}

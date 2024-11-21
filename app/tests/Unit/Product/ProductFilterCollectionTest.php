<?php

declare(strict_types=1);

namespace App\Tests\Unit\Product;

use PHPUnit\Framework\TestCase;
use App\Domain\Product\ProductFilter;
use App\Domain\Product\ProductFilterType;
use App\Domain\Product\ProductFilterCollection;

class ProductFilterCollectionTest extends TestCase
{
    public function testCanAddFilterToCollection() : void
    {
        $filter = new ProductFilter(ProductFilterType::SKU_EQUALS, '123');
        $collection = new ProductFilterCollection();
        $collection->add($filter);

        $this->assertCount(1, $collection);

        $filter = new ProductFilter(ProductFilterType::PRICE_LESS_THAN_OR_EQUAL_TO, '100');
        $collection->add($filter);

        $this->assertCount(2, $collection);
    }

    public function testCanGetFiltersFromCollection() : void
    {
        $filter = new ProductFilter(ProductFilterType::SKU_EQUALS, '123');
        $collection = new ProductFilterCollection($filter);

        $this->assertEquals([$filter], $collection->filters());
    }

    public function testCanIterateOverFilters() : void
    {
        $filter = new ProductFilter(ProductFilterType::SKU_EQUALS, '123');
        $collection = new ProductFilterCollection($filter, $filter, $filter);

        $filters = [];
        foreach ($collection as $filter) {
            $filters[] = $filter;
        }

        $this->assertEquals([$filter, $filter, $filter], $filters);
    }

    public function testCanCheckIfCollectionHasFilters() : void
    {
        $collection = new ProductFilterCollection();
        $this->assertFalse($collection->hasFilters());

        $filter = new ProductFilter(ProductFilterType::SKU_EQUALS, '123');
        $collection->add($filter);

        $this->assertTrue($collection->hasFilters());
    }
}
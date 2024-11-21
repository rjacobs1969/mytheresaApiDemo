<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Domain\Product\ProductFilter;
use App\Domain\Product\ProductFilterType;

class ProductFilterTest extends TestCase
{
    public function testCanCreateFilterWithValidFilterType() : void
    {
        $skuFilter = new ProductFilter(ProductFilterType::SKU_EQUALS, '123');
        $this->assertEquals(ProductFilterType::SKU_EQUALS, $skuFilter->type());

        $priceFilter = new ProductFilter(ProductFilterType::PRICE_LESS_THAN_OR_EQUAL_TO, '100');
        $this->assertEquals(ProductFilterType::PRICE_LESS_THAN_OR_EQUAL_TO, $priceFilter->type());

        $categoryFilter = new ProductFilter(ProductFilterType::CATEGORY_EQUALS, 'Category Name');
        $this->assertEquals(ProductFilterType::CATEGORY_EQUALS, $categoryFilter->type());
    }
}
<?php

declare(strict_types=1);

namespace App\Tests\Unit\Discount;

use PHPUnit\Framework\TestCase;
use App\Domain\Discount\Discount;
use App\Domain\Discount\DiscountType;


class DiscountTest extends TestCase
{
    public function testCanCreateDiscountBySku() : void
    {
        $discount = new Discount(DiscountType::SKU, '123', 10);
        $this->assertEquals(DiscountType::SKU, $discount->discountType());
        $this->assertEquals('123', $discount->typeValue());
        $this->assertEquals(10, $discount->discountPercent());
    }

    public function testCanCreateDiscountByCategory() : void
    {
        $discount = new Discount(DiscountType::CATEGORY, 'Category Name', 10);
        $this->assertEquals(DiscountType::CATEGORY, $discount->discountType());
        $this->assertEquals('Category Name', $discount->typeValue());
        $this->assertEquals(10, $discount->discountPercent());
    }
}
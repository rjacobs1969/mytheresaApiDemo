<?php

declare(strict_types=1);

namespace App\Tests\Unit\Discount;

use PHPUnit\Framework\TestCase;
use App\Domain\Discount\DiscountByCategory;
use App\Domain\Discount\DiscountBySku;
use App\Domain\Discount\DiscountType;

class DiscountTest extends TestCase
{
    public function testCanCreateDiscountBySku(): void
    {
        $discount = new DiscountBySku('123', 10);
        $this->assertEquals(DiscountType::SKU, $discount->discountType());
        $this->assertEquals('123', $discount->key());
        $this->assertEquals(10, $discount->discountPercent());
    }

    public function testCanCreateDiscountByCategory(): void
    {
        $discount = new DiscountByCategory('Category Name', 10);
        $this->assertEquals(DiscountType::CATEGORY, $discount->discountType());
        $this->assertEquals('Category Name', $discount->key());
        $this->assertEquals(10, $discount->discountPercent());
    }
}

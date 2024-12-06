<?php

declare(strict_types=1);

namespace App\Tests\Unit\Discount;

use PHPUnit\Framework\TestCase;
use App\Domain\Discount\DiscountFactory;

class DiscountFactoryTest extends TestCase
{
    public function testCanCreateDiscountBySku() : void
    {
        $discountFactory = new DiscountFactory();
        $discount = $discountFactory->createDiscount('123', '', 10);
        $this->assertEquals('123', $discount->key());
    }

    public function testCanCreateDiscountByCategory() : void
    {
        $discountFactory = new DiscountFactory();
        $discount = $discountFactory->createDiscount('', 'Category Name', 10);
        $this->assertEquals('Category Name', $discount->key());
    }

    public function testInvalidDiscountTypeThrowsException() : void
    {
        $this->expectException(\InvalidArgumentException::class);
        $discountFactory = new DiscountFactory();
        $discountFactory->createDiscount('', '', 10);
    }

    public function testInvalidDiscountTypeThrowsException2() : void
    {
        $this->expectException(\InvalidArgumentException::class);
        $discountFactory = new DiscountFactory();
        $discountFactory->createDiscount('123', 'Category Name', 10);
    }
}

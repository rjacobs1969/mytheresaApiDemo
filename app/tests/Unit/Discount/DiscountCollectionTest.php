<?php

declare(strict_types=1);

namespace App\Tests\Unit\Discount;

use PHPUnit\Framework\TestCase;
use App\Domain\Discount\Discount;
use App\Domain\Discount\DiscountType;
use App\Domain\Discount\DiscountCollection;

class DiscountCollectionTest extends TestCase
{
    public function testCanCreateDiscountCollection() : void
    {
        $discount = new Discount(DiscountType::SKU, '123', 10);
        $discountCollection = new DiscountCollection([$discount]);
        $this->assertEquals([$discount], $discountCollection->discounts());
    }

    public function testCanAddDiscountToCollection() : void
    {
        $discount = new Discount(DiscountType::SKU, '123', 10);
        $discountCollection = new DiscountCollection([$discount]);
        $discount2 = new Discount(DiscountType::SKU, '456', 20);
        $discountCollection->add($discount2);
        $this->assertEquals([$discount, $discount2], $discountCollection->discounts());
    }

    public function testCanGetDiscountBySku() : void
    {
        $discount = new Discount(DiscountType::SKU, '123', 10);
        $discountCollection = new DiscountCollection([$discount]);
        $this->assertEquals($discount->discountPercent(), $discountCollection->discountBySku('123'));
    }

    public function testCanGetDiscountByCategory() : void
    {
        $discount = new Discount(DiscountType::CATEGORY, 'Category Name', 10);
        $discountCollection = new DiscountCollection([$discount]);
        $this->assertEquals($discount->discountPercent(), $discountCollection->discountByCategory('Category Name'));
    }

    public function testDiscountIsNullIfNotInCollection() : void
    {
        $discount = new Discount(DiscountType::SKU, '123', 10);
        $discount2 = new Discount(DiscountType::CATEGORY, 'Category Name', 20);
        $discountCollection = new DiscountCollection([$discount]);
        $this->assertNull($discountCollection->discountBySku('456'));
        $this->assertNull($discountCollection->discountByCategory('DOES NOT EXIST'));
    }
}
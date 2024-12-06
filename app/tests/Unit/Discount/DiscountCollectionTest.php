<?php

declare(strict_types=1);

namespace App\Tests\Unit\Discount;

use PHPUnit\Framework\TestCase;
use App\Domain\Discount\DiscountByCategory;
use App\Domain\Discount\DiscountBySku;
use App\Domain\Discount\DiscountCollection;

class DiscountCollectionTest extends TestCase
{
    public function testCanCreateDiscountCollection() : void
    {
        $discount = new DiscountBySku('123', 10);
        $discountCollection = new DiscountCollection([$discount]);
        $this->assertEquals([$discount], $discountCollection->discounts());
    }

    public function testCanAddDiscountToCollection() : void
    {
        $discount = new DiscountBySku('123', 10);
        $discountCollection = new DiscountCollection([$discount]);
        $discount2 = new DiscountBySku('456', 20);
        $discountCollection->add($discount2);
        $this->assertEquals([$discount, $discount2], $discountCollection->discounts());
    }

    public function testCanGetDiscountBySku() : void
    {
        $discount = new DiscountBySku('123', 10);
        $discountCollection = new DiscountCollection([$discount]);
        $this->assertEquals($discount->discountPercent(), $discountCollection->discountBySku('123'));
    }

    public function testCanGetDiscountByCategory() : void
    {
        $discount = new DiscountByCategory('Category Name', 10);
        $discountCollection = new DiscountCollection([$discount]);
        $this->assertEquals($discount->discountPercent(), $discountCollection->discountByCategory('Category Name'));
    }

    public function testDiscountIsNullIfNotInCollection() : void
    {
        $discount = new DiscountBySku('123', 10);
        $discount2 = new DiscountByCategory('Category Name', 20);
        $discountCollection = new DiscountCollection([$discount]);
        $this->assertNull($discountCollection->discountBySku('456'));
        $this->assertNull($discountCollection->discountByCategory('DOES NOT EXIST'));
    }
}

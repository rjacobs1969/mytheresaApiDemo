<?php

declare(strict_types=1);

namespace App\Tests\Unit\Discount;

use PHPUnit\Framework\TestCase;
use App\Domain\Discount\DiscountBySku;
use App\Domain\Discount\DiscountFactory;
use App\Persistence\Adapter\DiscountAdapter;

class DiscountAdapterTest extends TestCase
{
    public function testRawDatabaseDataIsConvertedToDiscount(): void
    {
        $discountAdapter = new DiscountAdapter(new DiscountFactory());
        $rawData = [
            'sku' => '123',
            'category' => '',
            'discount_percent' => 10
        ];

        $discount = $discountAdapter->convertFromDatabaseValues($rawData);

        $this->assertInstanceOf(DiscountBySku::class, $discount);
        $this->assertEquals('123', $discount->key());
        $this->assertEquals(10, $discount->discountPercent());
    }

    public function testRawDatabaseDataIsConvertedToDiscountCollection(): void
    {
        $discountAdapter = new DiscountAdapter(new DiscountFactory());
        $rawData = [
            [
                'sku' => '123',
                'category' => '',
                'discount_percent' => 10
            ],
            [
                'sku' => '',
                'category' => 'shoes',
                'discount_percent' => 20
            ]
        ];

        $discounts = $discountAdapter->toCollection($rawData);

        $this->assertCount(2, $discounts);
    }
}

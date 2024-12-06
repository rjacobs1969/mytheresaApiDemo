<?php

declare(strict_types=1);

namespace App\Domain\Discount;

use InvalidArgumentException;

final class DiscountFactory
{
    public function createDiscount(string $sku, string $category, int $discountPercent): Discount
    {
        if ($sku !== '' && $category !== '') {
            throw new InvalidArgumentException('Sku and category cannot be both set');
        }

        if ($sku !== '') {
            return $this->createDiscountBySku($sku, $discountPercent);
        }

        if ($category !== '') {
            return $this->createDiscountByCategory($category, $discountPercent);
        }

        throw new InvalidArgumentException('Invalid discount type');
    }

    private function createDiscountBySku(string $sku, int $discountPercent): DiscountBySku
    {
        return new DiscountBySku($sku, $discountPercent);
    }

    private function createDiscountByCategory(string $category, int $discountPercent): DiscountByCategory
    {
        return new DiscountByCategory($category, $discountPercent);
    }
}

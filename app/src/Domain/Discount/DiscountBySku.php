<?php

declare(strict_types=1);

namespace App\Domain\Discount;

class DiscountBySku extends Discount
{
    private const DISCOUNT_TYPE = DiscountType::SKU;

    private string $sku;

    public function __construct(string $sku, int $discountPercent)
    {
        Discount::__construct(self::DISCOUNT_TYPE, $discountPercent);
        parent::notEmpty($sku);

        $this->sku = $sku;
    }

    public function key(): string
    {
        return $this->sku;
    }
}

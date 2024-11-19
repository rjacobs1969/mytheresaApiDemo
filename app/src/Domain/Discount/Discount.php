<?php

declare(strict_types=1);

namespace App\Domain\Discount;

use App\Domain\Discount\DiscountType;

class Discount
{
    private DiscountType $discountType;
    private string $typeValue;
    private int $discountPercent;

    public function __construct(DiscountType $discountType, string $typeValue, int $discountPercent)
    {
        $this->discountType = $discountType;
        $this->typeValue = $typeValue;
        $this->discountPercent = $discountPercent;
    }

    public function discountType(): DiscountType
    {
        return $this->discountType;
    }

    public function typeValue(): string
    {
        return $this->typeValue;
    }

    public function discountPercent(): int
    {
        return $this->discountPercent;
    }
}
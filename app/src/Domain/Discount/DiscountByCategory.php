<?php

declare(strict_types=1);

namespace App\Domain\Discount;

class DiscountByCategory extends Discount
{
    private const DISCOUNT_TYPE = DiscountType::CATEGORY;

    private string $category;

    public function __construct(string $category, int $discountPercent)
    {
        Discount::__construct(self::DISCOUNT_TYPE, $discountPercent);
        parent::notEmpty($category);

        $this->category = $category;
    }

    public function key(): string
    {
        return $this->category;
    }
}

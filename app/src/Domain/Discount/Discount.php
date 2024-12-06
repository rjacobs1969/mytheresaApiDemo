<?php

declare(strict_types=1);

namespace App\Domain\Discount;

use InvalidArgumentException;

abstract class Discount
{
    protected DiscountType $discountType;
    protected int $discountPercent;

    abstract public function key(): string;

    protected function __construct(DiscountType $discountType, int $discountPercent)
    {
        $this->checkDiscountPercent($discountPercent);

        $this->discountType = $discountType;
        $this->discountPercent = $discountPercent;
    }

    public function discountType(): DiscountType
    {
        return $this->discountType;
    }

    public function discountPercent(): int
    {
        return $this->discountPercent;
    }

    protected function checkDiscountPercent(int $discountPercent): void
    {
        if ($discountPercent < 0 || $discountPercent > 100) {
            throw new InvalidArgumentException('Discount percent must be between 0 and 100');
        }
    }

    protected function notEmpty(string $value): void
    {
        if (empty($value)) {
            throw new InvalidArgumentException('Value cannot be empty');
        }
    }
}

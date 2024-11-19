<?php

declare(strict_types=1);

namespace App\Domain\Discount;

enum DiscountType
{
    case SKU;
    case CATEGORY;
}
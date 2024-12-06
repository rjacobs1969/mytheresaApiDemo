<?php

declare(strict_types=1);

namespace App\Domain\Product;

enum ProductFilterType
{
    case SKU_EQUALS;
    case CATEGORY_EQUALS;
    case PRICE_LESS_THAN_OR_EQUAL_TO;
}

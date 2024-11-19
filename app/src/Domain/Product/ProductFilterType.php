<?php

declare(strict_types=1);

namespace App\Domain\Product;

enum ProductFilterType
{
    //case SKU;  // Not in current assignment so commented out
    //case NAME; // Not in current assignment so commented out
    case CATEGORY_EQUALS;
    case PRICE_LESS_THAN_OR_EQUAL_TO;
}
<?php

declare(strict_types=1);

namespace App\Domain\Product;

/**
 * Statement parameter type.
 */
enum ProductFilterType
{
    //case SKU;  // Not in current assignment
    //case NAME; // Not in current assignment
    case CATEGORY_EQUALS;
    case PRICE_LESS_THAN_OR_EQUAL_TO;
}
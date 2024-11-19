<?php

declare(strict_types=1);

namespace App\Persistence;

abstract class TablesMySQL
{
    public const MAX_RESULTS = 5;
    public const PRODUCTS = 'catalog.products';
    public const DISCOUNTS = 'catalog.discounts';
}
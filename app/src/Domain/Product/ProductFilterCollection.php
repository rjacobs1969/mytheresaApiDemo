<?php

declare(strict_types=1);

namespace App\Domain\Product;

use App\Domain\Product\ProductCategory;
use App\Domain\Money\Money;
use App\Domain\Product\ProductFilter;
use Countable;
use ArrayIterator;
use IteratorAggregate;

class ProductFilterCollection implements IteratorAggregate, Countable
{
    private array $filters = [];

    public function __construct(ProductFilter ...$filters)
    {
        $this->filters = $filters;
    }

    public function filters() : array
    {
        return $this->filters;
    }

    public function add(ProductFilter $filter) : void
    {
        $this->filters[] = $filter;
    }

    public function hasFilters() : bool
    {
        return $this->count() > 0;
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->filters());
    }

    public function count(): int
    {
        return count($this->filters());
    }
}
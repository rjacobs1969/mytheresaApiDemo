<?php

declare(strict_types=1);

namespace App\Domain\Product;

use Countable;
use ArrayIterator;
use IteratorAggregate;

final class ProductCollection implements IteratorAggregate, Countable
{
    private array $products = [];

    public function __construct(array $products = [])
    {
        foreach ($products as $product) {
            if (!$product instanceof Product) {
                throw new \InvalidArgumentException('Invalid product');
            }
            $this->add($product);
        }
    }

    public function add(Product $product): void
    {
        if (isset($this->products[$product->sku()])) {
            throw new \InvalidArgumentException('Product already exists');
        }

        $this->products[$product->sku()] = $product;
    }

    public function products(): array
    {
        return array_values($this->products);
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->products());
    }

    public function count(): int
    {
        return count($this->products);
    }
}
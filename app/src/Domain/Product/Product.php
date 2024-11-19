<?php

declare(strict_types=1);

namespace App\Domain\Product;

use App\Domain\Product\ProductCategory;
use App\Domain\Money\Money;

class Product
{
    private string $sku;
    private string $name;
    private ProductCategory $category;
    private Money $price;

    public function __construct(string $sku, string $name, ProductCategory $category, Money $price)
    {
        $this->sku = $sku;
        $this->name = $name;
        $this->category = $category;
        $this->price = $price;
    }

    public function sku(): string
    {
        return $this->sku;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function category(): ProductCategory
    {
        return $this->category;
    }

    public function price(): Money
    {
        return $this->price;
    }
}
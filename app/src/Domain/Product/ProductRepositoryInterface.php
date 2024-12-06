<?php

declare(strict_types=1);

namespace App\Domain\Product;

interface ProductRepositoryInterface
{
    public function find(?ProductFilterCollection $filterCollection): ProductCollection;
    public function save(Product $product): void;
    public function update(Product $product): void;
    public function delete(Product $product): void;
}

<?php

declare(strict_types=1);

namespace App\Domain\Discount;

use App\Domain\Product\ProductFilterCollection;

interface DiscountRepositoryInterface
{
    public function find(): DiscountCollection;
    //Not in current assignment scope, but would (probably) be implemented in a real-world scenario:
    //public function save(Discount $discount): void;
    //public function update(Discount $discount): void;
    //public function delete(Discount $discount): void;
}

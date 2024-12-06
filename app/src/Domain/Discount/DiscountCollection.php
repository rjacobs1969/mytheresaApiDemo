<?php

declare(strict_types=1);

namespace App\Domain\Discount;

use Countable;
use ArrayIterator;
use IteratorAggregate;

final class DiscountCollection implements IteratorAggregate, Countable
{
    private array $discounts = [];

    public function __construct(array $discounts = [])
    {
        foreach ($discounts as $discount) {
            if (!$discount instanceof Discount) {
                throw new \InvalidArgumentException('Element is not a discount');
            }
            $this->add($discount);
        }
    }

    public function add(Discount $discount): void
    {
        $this->discounts[$this->generateKey($discount)] = $discount;
    }

    public function discounts(): array
    {
        return array_values($this->discounts);
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->discounts());
    }

    public function count(): int
    {
        return count($this->discounts);
    }

    public function discountBySku(string $sku): ?int
    {
        $searchKey = $this->searchKey(DiscountType::SKU, $sku);

        return $this->getDiscountPercentByKeyOrNull($searchKey);
    }

    public function discountByCategory(string $category): ?int
    {
        $searchKey = $this->searchKey(DiscountType::CATEGORY, $category);

        return $this->getDiscountPercentByKeyOrNull($searchKey);
    }

    private function getDiscountPercentByKeyOrNull(string $key): ?int
    {
        return isset($this->discounts[$key]) ?
            $this->discounts[$key]->discountPercent() :
            null;
    }

    private function generateKey(Discount $discount): string
    {
        return $this->searchKey($discount->discountType(), $discount->key());
    }

    private function searchKey(DiscountType $type, string $value): string
    {
        return $type->name . $value;
    }
}

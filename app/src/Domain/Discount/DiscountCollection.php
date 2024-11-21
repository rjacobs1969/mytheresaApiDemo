<?php

declare(strict_types=1);

namespace App\Domain\Discount;

use Countable;
use ArrayIterator;
use IteratorAggregate;

final class DiscountCollection implements IteratorAggregate, Countable
{
    private array $discountsBySku = [];
    private array $discountsByCategory = [];

    public function __construct(array $discounts = [])
    {
        foreach ($discounts as $discount) {
            if (!$discount instanceof Discount) {
                throw new \InvalidArgumentException('Invalid discount');
            }
            $this->add($discount);
        }
    }

    public function add(Discount $discount): void
    {
        switch ($discount->discountType()) {
            case DiscountType::CATEGORY:
                $this->addDiscountByCategory($discount);
                break;
            case DiscountType::SKU:
                $this->addDiscountBySku($discount);
                break;
            Default:
                throw new \InvalidArgumentException('Invalid discount type');
        }
    }

    public function discounts(): array
    {
        return array_merge(
            array_values($this->discountsBySku),
            array_values($this->discountsByCategory)
        );
    }

    public function discountBySku(string $sku): ?int
    {
        return isset($this->discountsBySku[$sku]) ?
            $this->discountsBySku[$sku]->discountPercent() :
            null;
    }

    public function discountByCategory(string $category): ?int
    {
        return isset($this->discountsByCategory[$category]) ?
            $this->discountsByCategory[$category]->discountPercent() :
            null;
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->discounts());
    }

    public function count(): int
    {
        return count($this->discountsBySku) + count($this->discountsByCategory);
    }

    private function addDiscountByCategory(Discount $discount): void
    {
        $category = $discount->typeValue();
        if (!isset($this->discountsByCategory[$category]) || $this->discountsByCategory[$category]->discountPercent() > $discount->discountPercent()) {
            $this->discountsByCategory[$category] = $discount;
        }
    }

    private function addDiscountBySku(Discount $discount): void
    {
        $sku = $discount->typeValue();
        if (!isset($this->discountsBySku[$sku]) || $this->discountsBySku[$sku]->discountPercent() < $discount->discountPercent()) {
            $this->discountsBySku[$sku] = $discount;
        }
    }
}
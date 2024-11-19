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
                throw new \InvalidArgumentException('Invalid discount');
            }
            $this->add($discount);
        }
    }

    public function add(Discount $discount): void
    {
        $this->discounts[] = $discount;
    }

    public function discounts(): array
    {
        return $this->discounts;
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->discounts());
    }

    public function count(): int
    {
        return count($this->discounts);
    }
}
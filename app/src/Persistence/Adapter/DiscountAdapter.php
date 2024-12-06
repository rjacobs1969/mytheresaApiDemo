<?php

declare(strict_types=1);

namespace App\Persistence\Adapter;

use App\Domain\Discount\Discount;
use App\Domain\Discount\DiscountCollection;
use App\Domain\Discount\DiscountFactory;

final class DiscountAdapter
{
    private DiscountFactory $discountFactory;

    public function __construct(DiscountFactory $discountFactory)
    {
        $this->discountFactory = $discountFactory;
    }

    public function convertFromDatabaseValues(array $raw): Discount
    {
        return $this->discountFactory->createDiscount(
            $raw['sku'] ?? '',
            $raw['category'] ?? '',
            (int) $raw['discount_percent'] ?? 0
        );

        throw new \InvalidArgumentException('Invalid discount type');
    }

    public function toCollection(array $raws): DiscountCollection
    {
        $collection = new DiscountCollection();
        foreach ($raws as $raw) {
            $collection->add($this->convertFromDatabaseValues($raw));
        }

        return $collection;
    }
}

<?php

declare(strict_types=1);

namespace App\Persistence\Adapter;

use App\Domain\Discount\Discount;
use App\Domain\Discount\DiscountType;
use App\Domain\Discount\DiscountCollection;

final class DiscountAdapter
{
    public function convertFromDatabaseValues(array $raw) : Discount
    {
        if ($raw['sku'] !== '') {
            return new Discount(
                DiscountType::SKU,
                $raw['sku'],
                (int) $raw['discount_percent']
            );
        }

        if ($raw['category'] !== '') {
            return new Discount(
                DiscountType::CATEGORY,
                $raw['category'],
                (int) $raw['discount_percent']
            );
        }

        throw new \InvalidArgumentException('Invalid discount type');
    }

    public function toCollection(array $raws) : DiscountCollection
    {
        $collection = new DiscountCollection();
        foreach ($raws as $raw) {
            $collection->add($this->convertFromDatabaseValues($raw));
        }

        return $collection;
    }
}
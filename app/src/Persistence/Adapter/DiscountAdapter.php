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
        switch ($raw['type']) {
            case 'sku':
                $discountType = DiscountType::SKU;
                break;
            case 'category':
                $discountType = DiscountType::CATEGORY;
                break;
            default:
                throw new \InvalidArgumentException('Invalid discount type');
        }

        return new Discount(
            $discountType,
            $raw['type_value'],
            (int) $raw['discount_percent']
        );
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
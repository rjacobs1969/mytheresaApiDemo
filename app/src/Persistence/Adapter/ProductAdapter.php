<?php

declare(strict_types=1);

namespace App\Persistence\Adapter;

use App\Domain\Money\Currency;
use App\Domain\Money\Money;
use App\Domain\Product\Product;
use App\Domain\Product\ProductCollection;
use App\Domain\Product\ProductCategory;

final class ProductAdapter
{
    private const DEFAULT_CURRENCY = 'EUR';

    public function convertFromDatabaseValues(array $raw) : Product
    {
        return new Product(
            $raw['sku'],
            $raw['name'],
            new ProductCategory($raw['category']),
            new Money((int) $raw['price'], new Currency(self::DEFAULT_CURRENCY))
        );
    }

    public function toCollection(array $raws) : ProductCollection
    {
        $collection = new ProductCollection();
        foreach ($raws as $raw) {
            $collection->add($this->convertFromDatabaseValues($raw));
        }

        return $collection;
    }

    public function toDatabaseValues(Product $product) : array
    {
        return [
            'sku'       => $product->sku(),
            'name'      => $product->name(),
            'category'  => $product->category()->category(),
            'price'     => $product->price()->amount(),
        ];
    }

    public function toDatabaseKey(Product $product) : array
    {
        return ['sku' => $product->sku()];
    }
}
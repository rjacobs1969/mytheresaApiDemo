<?php

declare(strict_types=1);

namespace App\UserInterface\Transformer;

use App\Domain\Product\Product;
use App\Domain\Product\ProductCollection;

use function PHPUnit\Framework\isNull;

class ProductCollectionTransformer
{
    public function transform(ProductCollection $products): array
    {
        $output = [];
        foreach ($products as $product) {
            $output[] = $this->transformProduct($product);
        }

        return $output;
    }
    private function transformProduct(Product $product): array
    {
        return [
            'sku'       => $product->sku(),
            'name'      => $product->name(),
            'category'  => $product->category()->category(),
            'price'     => [
                'original' => $product->price()->amount(),
                'final'     => $product->discountedPrice()->amount(),
                'discount_percentage'  => $product->discount(), //isNull($product->discount()) ? null: $product->discount()."%",
                'currency'  => $product->price()->currency()->isoCode(),

            ],
        ];
    }
}
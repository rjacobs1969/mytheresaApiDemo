<?php

declare(strict_types=1);

namespace App\Tests\Unit\Product;

use App\Domain\Product\ProductCollection;
use App\Persistence\Adapter\ProductAdapter;
use PHPUnit\Framework\TestCase;

class ProductAdapterTest extends TestCase
{
    public function testRawDatabaseDataIsConvertedToProduct() : void
    {
        $productAdapter = new ProductAdapter();
        $rawData = [
            'sku' => '123',
            'name' => 'Product 1',
            'category' => 'Category 1',
            'price' => 10.00
        ];

        $product = $productAdapter->convertFromDatabaseValues($rawData);

        $this->assertEquals('123', $product->sku());
        $this->assertEquals('Product 1', $product->name());
        $this->assertEquals('Category 1', $product->category()->category());
        $this->assertEquals(10.00, $product->price()->amount());
    }

    public function testRawDatabaseDataIsConvertedToProductCollection() : void
    {
        $productAdapter = new ProductAdapter();
        $rawData = [
            [
                'sku' => '123',
                'name' => 'Product 1',
                'category' => 'Category 1',
                'price' => 10.00
            ],
            [
                'sku' => '456',
                'name' => 'Product 2',
                'category' => 'Category 2',
                'price' => 20.00
            ]
        ];

        $products = $productAdapter->toCollection($rawData);

        $this->assertInstanceOf(ProductCollection::class, $products);
        $this->assertCount(2, $products);
    }

    public function testProductIsConvertedToDatabaseValues() : void
    {
        $productAdapter = new ProductAdapter();
        $productData = [
            'sku' => '123',
            'name' => 'Product 1',
            'category' => 'Category 1',
            'price' => 10.00
        ];

        $product = $productAdapter->convertFromDatabaseValues($productData);
        $databaseValues = $productAdapter->toDatabaseValues($product);

        $this->assertEquals($productData, $databaseValues);
    }

    public function testProductIsConvertedToDatabaseKey() : void
    {
        $productAdapter = new ProductAdapter();
        $productData = [
            'sku' => '123',
            'name' => 'Product 1',
            'category' => 'Category 1',
            'price' => 10.00
        ];

        $product = $productAdapter->convertFromDatabaseValues($productData);
        $databaseKey = $productAdapter->toDatabaseKey($product);

        $this->assertEquals(['sku' => '123'], $databaseKey);
    }
}
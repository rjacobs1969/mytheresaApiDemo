<?php

declare(strict_types=1);

namespace App\Tests\Unit\Product;

use PHPUnit\Framework\TestCase;
use App\Domain\Product\Product;
use App\Domain\Product\ProductCollection;
use App\Domain\Product\ProductCategory;
use App\Domain\Money\Money;
use App\Domain\Money\Currency;

class ProductCollectionTest extends TestCase
{
    public function testCanAddProductToCollection(): void
    {
        $product = $this->createProduct();
        $collection = new ProductCollection();
        $collection->add($product);

        $this->assertCount(1, $collection);
    }

    public function testCannotAddSameProductTwice(): void
    {
        $product = $this->createProduct();
        $collection = new ProductCollection();
        $collection->add($product);

        $this->expectException(\InvalidArgumentException::class);
        $collection->add($product);
    }

    public function testCanGetProductsFromCollection(): void
    {
        $product = $this->createProduct();
        $collection = new ProductCollection([$product]);

        $this->assertEquals([$product], $collection->products());
    }

    public function testCanIterateOverProducts(): void
    {
        $product = $this->createProduct();
        $collection = new ProductCollection([$product]);

        $products = [];
        foreach ($collection as $product) {
            $products[] = $product;
        }

        $this->assertEquals([$product], $products);
    }

    private function createProduct(): Product
    {
        return new Product(
            '123',
            'Product Name',
            new ProductCategory('Category Name'),
            new Money(100, new Currency('EUR'))
        );
    }
}

<?php

declare(strict_types=1);

namespace App\Tests\Unit\Product;

use PHPUnit\Framework\TestCase;
use App\Domain\Product\Product;
use App\Domain\Product\ProductCategory;
use App\Domain\Money\Money;
use App\Domain\Money\Currency;

class ProductTest extends TestCase
{
    public function testCanCreateProduct() : void
    {
        $product = $this->createProduct();

        $this->assertEquals('123', $product->sku());
        $this->assertEquals('Product Name', $product->name());
        $this->assertEquals('Category Name', $product->category()->category());
        $this->assertEquals(100, $product->price()->amount());
        $this->assertEquals('EUR', $product->price()->currency()->isoCode());
    }

    public function testCanSetDiscount() : void
    {
        $product = $this->createProduct();
        $product->setDiscount(10);

        $this->assertEquals(10, $product->discount());
    }

    public function testCanCalculateDiscountedPrice() : void
    {
        $product = $this->createProduct();
        $product->setDiscount(10);
        $discountedPrice = $product->discountedPrice();

        $this->assertEquals(90, $discountedPrice->amount());
        $this->assertEquals('EUR', $discountedPrice->currency()->isoCode());
    }

    private function createProduct() : Product
    {
        return new Product(
            '123',
            'Product Name',
            new ProductCategory('Category Name'),
            new Money(100, new Currency('EUR'))
        );
    }
}
<?php

declare(strict_types=1);

namespace App\Tests\Unit\Product;

use PHPUnit\Framework\TestCase;
use App\Domain\Product\ProductCategory;

class ProductCategoryTest extends TestCase
{
    public function testCanCreateProductCategory() : void
    {
        $category = new ProductCategory('Category Name');
        $this->assertEquals('Category Name', $category->category());
    }

    public function testCannortCreateCategoryWithoutName() : void
    {
        $this->expectException(\InvalidArgumentException::class);
        new ProductCategory('');
    }
}

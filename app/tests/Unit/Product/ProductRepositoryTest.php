<?php

declare(strict_types=1);

namespace App\Tests\Unit\Product;

use App\Domain\Product\Product;
use App\Domain\Product\ProductCollection;
use App\Domain\Product\ProductFilter;
use App\Domain\Product\ProductFilterCollection;
use App\Domain\Product\ProductFilterType;
use App\Persistence\Adapter\ProductAdapter;
use App\Persistence\Repository\ProductRepository;
use Doctrine\DBAL\Connection;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;

class ProductRepositoryTest extends TestCase
{
    public function testFind() : void
    {
        $productRepository = $this->createProductRepository();
        $products = $productRepository->find();

        $this->assertInstanceOf(ProductCollection::class, $products);
    }

    public function testFindWithFilters() : void
    {
        $productRepository = $this->createProductRepository();
        $filters = $this->createMock(ProductFilterCollection::class);
        $products = $productRepository->find($filters);

        $this->assertInstanceOf(ProductCollection::class, $products);
    }

    public function testFindWithInvalidFilter() : void
    {
        $productRepository = $this->createProductRepository();
        $filters = new ProductFilterCollection();
        $filter = new ProductFilter(ProductFilterType::SKU_EQUALS, '125');
        $filters->add($filter);

        $this->expectException(InvalidArgumentException::class);
        $productRepository->find($filters);
    }

    public function testSave() : void
    {
        $productRepository = $this->createProductRepository();
        $product = $this->createMock(Product::class);

        $productRepository->save($product);

        $this->assertTrue(true);
    }

    private function createProductRepository() : ProductRepository
    {
        $connection = $this->createMock(Connection::class);
        $productAdapter = new ProductAdapter();

        return new ProductRepository($connection, $productAdapter);
    }

}
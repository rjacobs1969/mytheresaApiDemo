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
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\DBAL\Result;
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

    public function testIfQueryBuilderAndDoctrineIsCalled() : void
    {
        $connection = $this->createMock(Connection::class);
        $queryBuilder = $this->createMock(QueryBuilder::class);
        $filters = $this->createMock(ProductFilterCollection::class);
        $stmt = $this->createMock(Result::class);

        $connection->expects($this->once())
            ->method('createQueryBuilder')
            ->willReturn($queryBuilder);
        $queryBuilder->expects($this->once())
            ->method('select')
            ->willReturnSelf();
        $queryBuilder->expects($this->once())
            ->method('from')
            ->willReturnSelf();
        $queryBuilder->expects($this->once())
            ->method('setMaxResults')
            ->willReturnSelf();
        $queryBuilder->expects($this->once())
            ->method('executeQuery')
            ->willReturn($stmt);
        $stmt->expects($this->once())
            ->method('fetchAllAssociative')
            ->willReturn($this->mockData());

        $productAdapter = new ProductAdapter();
        $productRepository = new ProductRepository($connection, $productAdapter);
        $products = $productRepository->find($filters);
        $this->assertInstanceOf(ProductCollection::class, $products);
        $this->assertCount(2, $products);
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

    private function mockData() : array
    {
        return [
            [
                'sku' => '123',
                'name' => 'Product 1',
                'category' => 'Category 1',
                'price' => 1000
            ],
            [
                'sku' => '456',
                'name' => 'Product 2',
                'category' => 'Category 2',
                'price' => 2000
            ]
        ];
    }

}

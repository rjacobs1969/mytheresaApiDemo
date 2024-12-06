<?php

declare(strict_types=1);

namespace App\Tests\Unit\Discount;

use PHPUnit\Framework\TestCase;
use App\Domain\Discount\DiscountFactory;
use App\Domain\Discount\DiscountCollection;
use App\Persistence\Adapter\DiscountAdapter;
use App\Persistence\Repository\DiscountRepository;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\DBAL\Result;

class DiscountRepositoryTest extends TestCase
{
    public function testFind(): void
    {
        $productRepository = $this->createDiscountRepositoryMock();
        $products = $productRepository->find();

        $this->assertInstanceOf(DiscountCollection::class, $products);
    }

    public function testIfQueryBuilderAndDoctrineIsCalled(): void
    {
        $connection = $this->createMock(Connection::class);
        $queryBuilder = $this->createMock(QueryBuilder::class);
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
            ->method('executeQuery')
            ->willReturn($stmt);
        $stmt->expects($this->once())
            ->method('fetchAllAssociative')
            ->willReturn($this->mockData());
        $adapter = new DiscountAdapter(new DiscountFactory());
        $repository = new DiscountRepository($connection, $adapter);
        $discounts = $repository->find();
        $this->assertInstanceOf(DiscountCollection::class, $discounts);
        $this->assertCount(2, $discounts);
    }

    private function createDiscountRepositoryMock(): DiscountRepository
    {
        $connection = $this->createMock(Connection::class);
        $productAdapter = new DiscountAdapter(new DiscountFactory());

        return new DiscountRepository($connection, $productAdapter);
    }

    private function mockData(): array
    {
        return [
            [
                'sku' => '123',
                'category' => '',
                'discount_percent' => '10'
            ],
            [
                'sku' => '',
                'category' => 'SomeCategory',
                'discount_percent' => '20'
            ]
        ];
    }

}

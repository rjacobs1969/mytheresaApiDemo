<?php

declare(strict_types=1);

namespace App\Persistence\Repository;

use App\Domain\Discount\DiscountCollection;
use App\Domain\Discount\DiscountRepositoryInterface;
use App\Domain\Product\ProductFilter;
use App\Domain\Product\ProductFilterCollection;
use App\Domain\Product\ProductFilterType;
use App\Persistence\Adapter\DiscountAdapter;
use App\Persistence\TablesMySQL;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\Query\QueryBuilder;
use InvalidArgumentException;

class DiscountRepository implements DiscountRepositoryInterface
{
    private const DATABASE_TABLE = TablesMySQL::DISCOUNTS;

    private Connection $connection;
    private DiscountAdapter $adapter;

    public function __construct(Connection $connection, DiscountAdapter $discountAdapter)
    {
        $this->connection = $connection;
        $this->adapter = $discountAdapter;
    }

    public function find(): DiscountCollection
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->select(
                'p.sku',
                'p.category',
                'p.discount_percent'
            )
            ->from(self::DATABASE_TABLE, 'p');

        $stmt = $queryBuilder->executeQuery();
        $discounts = $stmt->fetchAllAssociative();

        return $this->adapter->toCollection($discounts);
    }
}

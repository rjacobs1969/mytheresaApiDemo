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

final class DiscountRepository implements DiscountRepositoryInterface
{
    private const DATABASE_TABLE = TablesMySQL::DISCOUNTS;

    private Connection $connection;
    private DiscountAdapter $adapter;

    public function __construct(Connection $connection, DiscountAdapter $discountAdapter)
    {
        $this->connection = $connection;
        $this->adapter = $discountAdapter;
    }

    public function find(ProductFilterCollection $filters): DiscountCollection
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->select(
                'p.sku',
                'p.name',
                'p.category',
                'p.price'
            )
            ->from(self::DATABASE_TABLE, 'p');

        if ($filters->hasFilters()) {
            $queryBuilder->where('1 = 2');
            foreach ($filters->filters() as $filter) {
                $this->addFilter($queryBuilder, $filter);
            }
        }
        $stmt = $queryBuilder->executeQuery();
        $discounts = $stmt->fetchAllAssociative();

        return $this->adapter->toCollection($discounts);
    }

    private function addFilter(QueryBuilder $queryBuilder, ProductFilter $filter): void
    {
        switch ($filter->type()) {
            case ProductFilterType::CATEGORY_EQUALS:
                $this->addCategoryFilter($queryBuilder, $filter->value());
                break;
            case ProductFilterType::SKU_EQUALS:
                $this->addSkuFilter($queryBuilder, $filter->value());
                break;
            default:
                throw new InvalidArgumentException('Invalid filter type');
        }
    }

    private function addCategoryFilter(QueryBuilder $queryBuilder, string $category): void
    {
        $queryBuilder->orWhere('p.category = :category')
            ->setParameter('category', $category, ParameterType::STRING);
    }

    private function addSkuFilter(QueryBuilder $queryBuilder, string $sku): void
    {
        $queryBuilder->orWhere('p.sku :sku')
            ->setParameter('sku', $sku, ParameterType::STRING);
    }
}

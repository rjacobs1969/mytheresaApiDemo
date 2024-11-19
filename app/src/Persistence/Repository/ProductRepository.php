<?php

declare(strict_types=1);

namespace App\Persistence\Repository;

use App\Domain\Money\Money;
use App\Domain\Product\Product;
use App\Domain\Product\ProductCategory;
use App\Domain\Product\ProductFilter;
use App\Domain\Product\ProductFilterType;
use App\Domain\Product\ProductFilterCollection;
use App\Domain\Product\ProductCollection;
use App\Domain\Product\ProductRepositoryInterface;
use App\Persistence\Adapter\ProductAdapter;
use App\Persistence\TablesMySQL;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\Query\QueryBuilder;
use InvalidArgumentException;

final class ProductRepository implements ProductRepositoryInterface
{
    private const DATABASE_TABLE = TablesMySQL::PRODUCTS;

    private Connection $connection;
    private ProductAdapter $adapter;

    public function __construct(Connection $connection, ProductAdapter $productAdapter)
    {
        $this->connection = $connection;
        $this->adapter = $productAdapter;
    }

    public function find(ProductFilterCollection $filters): ProductCollection
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->select(
                'p.sku',
                'p.name',
                'p.category',
                'p.price'
            )
            ->from(self::DATABASE_TABLE, 'p')
            ->setMaxResults(TablesMySQL::MAX_RESULTS);

        if ($filters->hasFilters()) {
            $queryBuilder->where('1 = 1');
            foreach ($filters->filters() as $filter) {
                $this->addFilter($queryBuilder, $filter);
            }
        }

        $stmt = $queryBuilder->executeQuery();
        $products = $stmt->fetchAllAssociative();

        return $this->adapter->toCollection($products);
    }

    public function save(Product $product): void
    {
        $this->connection->insert(
            self::DATABASE_TABLE,
            $this->adapter->toDatabaseValues($product)
        );
    }

    public function update(Product $product): void
    {
        $this->connection->update(
            self::DATABASE_TABLE,
            $this->adapter->toDatabaseValues($product),
            $this->adapter->toDatabaseKey($product)
        );
    }

    public function delete(Product $product): void
    {
        $this->connection->delete(
            self::DATABASE_TABLE,
            $this->adapter->toDatabaseKey($product)
        );
    }

    private function addFilter(QueryBuilder $queryBuilder, ProductFilter $filter): void
    {
        switch ($filter->type()) {
            case ProductFilterType::CATEGORY_EQUALS:
                $this->addCategoryFilter($queryBuilder, $filter->value());
                break;
            case ProductFilterType::PRICE_LESS_THAN_OR_EQUAL_TO:
                $this->addPriceLessThanOrEqualFilter($queryBuilder, (int) $filter->value());
                break;
            default:
                throw new InvalidArgumentException('Invalid filter type');
        }
    }

    private function addCategoryFilter(QueryBuilder $queryBuilder, string $category): void
    {
        $queryBuilder->andWhere('p.category = :category')
            ->setParameter('category', $category, ParameterType::STRING);
    }

    private function addPriceLessThanOrEqualFilter(QueryBuilder $queryBuilder, int $price): void
    {
        $queryBuilder->andWhere('p.price <= :price')
            ->setParameter('price', $price, ParameterType::INTEGER);
    }
}

<?php

declare(strict_types=1);

namespace App\Application\Catalog;

use App\Domain\Product\ProductCollection;
use App\Domain\Product\ProductFilterCollection;
use App\Domain\Product\ProductFilter;
use App\Domain\Product\ProductFilterType;
use App\Persistence\Repository\ProductRepository;

class ProductCatalog
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository) //
    {
        $this->productRepository = $productRepository;
    }

    public function listProductCatalog(array $filters) : ProductCollection
    {
        return $this->productRepository->find(
            $this->createProductFilterCollection($filters)
        );
    }

    private function createProductFilterCollection(array $filters): ProductFilterCollection
    {
        $productFilterCollection = new ProductFilterCollection();

        foreach ($filters as $filter => $value) {
            switch ($filter) {
                case 'category':
                    $productFilterCollection->add(
                        new ProductFilter(ProductFilterType::CATEGORY_EQUALS, $value)
                    );
                    break;
                case 'priceLessThan':
                    $productFilterCollection->add(
                        new ProductFilter(ProductFilterType::PRICE_LESS_THAN_OR_EQUAL_TO, $value)
                    );
                    break;
            }
        }

        return $productFilterCollection;
    }
}
<?php

declare(strict_types=1);

namespace App\Application\Catalog;

use App\Domain\Product\Product;
use App\Domain\Product\ProductCollection;
use App\Domain\Product\ProductFilterCollection;
use App\Persistence\Repository\ProductRepository;

class ProductCatalog
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository) //
    {
        $this->productRepository = $productRepository;
    }

    //public function findProduct(string $sku) : ?Product
    //{
    //    return $this->productRepository->find($sku);
    //
    //}

    public function findAllProducts() : ProductCollection
    {
        return $this->productRepository->find(new ProductFilterCollection());
    }
}
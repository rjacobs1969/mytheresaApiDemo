<?php

declare(strict_types=1);

namespace App\Application\Catalog;

use App\Domain\Product\ProductCollection;
use App\Domain\Product\ProductFilterCollection;
use App\Domain\Product\ProductFilter;
use App\Domain\Product\ProductFilterType;
use App\Domain\Discount\DiscountCollection;
use App\Persistence\Repository\DiscountRepository;
use App\Persistence\Repository\ProductRepository;
use App\UserInterface\Transformer\ProductCollectionTransformer;
class ProductCatalog
{
    private ProductRepository $productRepository;
    private DiscountRepository $discountRepository;
    private ProductCollectionTransformer $productCollectionTransformer;

    public function __construct(
        ProductRepository $productRepository,
        DiscountRepository $discountRepository,
        ProductCollectionTransformer $productCollectionTransformer)
    {
        $this->productRepository = $productRepository;
        $this->discountRepository = $discountRepository;
        $this->productCollectionTransformer = $productCollectionTransformer;
    }

    public function getProductCatalogWithBestPromotionsApplied(ProductFilterCollection $filters) : array
    {
        //$this->createProductFilterCollection($filters)
        $productCollection = $this->productRepository->find($filters);
        $promotionCollection = $this->discountRepository->find();

        $this->applyPromotions($productCollection, $promotionCollection);

        return $this->productCollectionTransformer->transform($productCollection);
    }

    private function applyPromotions(ProductCollection $products, DiscountCollection $promotions): void
    {
        foreach ($products as $product) {
            $product->setDiscount(max(
                $promotions->discountBySku($product->sku()),
                $promotions->discountByCategory($product->category()->category())
            ));
        }
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
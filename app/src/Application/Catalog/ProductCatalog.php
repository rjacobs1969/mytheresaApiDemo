<?php

declare(strict_types=1);

namespace App\Application\Catalog;

use App\Domain\Product\ProductCollection;
use App\Domain\Product\ProductFilterCollection;
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

    public function getProductCatalogWithBestPromotionsApplied(?ProductFilterCollection $filters = null) : array
    {
        $productCollection = $this->productRepository->find($filters);
        $promotionCollection = $this->discountRepository->find();

        $this->applyPromotions($productCollection, $promotionCollection);

        return $this->productCollectionTransformer->transform($productCollection);
    }

    private function applyPromotions(ProductCollection $products, DiscountCollection $promotions): void
    {
        foreach ($products as $product) {
            $product->setDiscount(
                max(
                    $promotions->discountBySku($product->sku()),
                    $promotions->discountByCategory($product->category()->category())
                )
            );
        }
    }
}
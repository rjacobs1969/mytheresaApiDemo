<?php

declare(strict_types=1);

namespace App\UserInterface\Adapter;

use Symfony\Component\HttpFoundation\Request;
use App\Domain\Product\ProductFilter;
use App\Domain\Product\ProductFilterType;
use App\Domain\Product\ProductFilterCollection;

class ProductListRequestAdapter
{
    public function createProductListFilterFromRequest(Request $request): ProductFilterCollection
    {
        $filters = new ProductFilterCollection();
        if ($request->query->has('category')) {
            $category = $request->query->get('category');
            $filters->add(
                new ProductFilter(ProductFilterType::CATEGORY_EQUALS, $category)
            );
        }

        if ($request->query->has('priceLessThan')) {
            $priceLessThan = $request->query->get('priceLessThan');
            $filters->add(
                new ProductFilter(ProductFilterType::PRICE_LESS_THAN_OR_EQUAL_TO, $priceLessThan)
            );
        }

        return $filters;
    }
}
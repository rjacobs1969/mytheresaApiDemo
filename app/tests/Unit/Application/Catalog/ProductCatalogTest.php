<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\Catalog;

use PHPUnit\Framework\TestCase;
use App\Application\Catalog\ProductCatalog;
use App\Persistence\Repository\ProductRepository;
use App\Persistence\Repository\DiscountRepository;
use App\UserInterface\Transformer\ProductCollectionTransformer;
use App\Domain\Product\ProductCollection;
use App\Domain\Product\Product;
use App\Domain\Product\ProductCategory;
use App\Domain\Money\Money;
use App\Domain\Money\Currency;
use App\Domain\Discount\DiscountByCategory;
use App\Domain\Discount\DiscountBySku;
use App\Domain\Discount\DiscountCollection;
use App\Domain\Product\ProductFilterCollection;
use App\Domain\Product\ProductFilter;
use App\Domain\Product\ProductFilterType;

class ProductCatalogTest extends TestCase
{
    private ProductCatalog $productCatalog;

    protected function setUp(): void
    {
        $this->productCatalog = new ProductCatalog(
            $this->createProductRepositoryMock(),
            $this->createDiscountRepositoryMock(),
            new ProductCollectionTransformer()
        );
    }

    public function testCanGetProductCatalogWithBestPromotionsApplied() : void
    {
        $productCatalog = $this->productCatalog->getProductCatalogWithBestPromotionsApplied();

        $this->assertIsArray($productCatalog);
    }

    public function testCanGetProductCatalogWithBestPromotionsAppliedWithFilters() : void
    {
        $productCatalog = $this->productCatalog->getProductCatalogWithBestPromotionsApplied(
            new ProductFilterCollection(
                new ProductFilter(ProductFilterType::CATEGORY_EQUALS, 'shoes')
            )
        );

        $this->assertIsArray($productCatalog);
    }

    public function testBestDiscountIsAppliedToProduct() : void
    {
        $productCatalog = $this->productCatalog->getProductCatalogWithBestPromotionsApplied();

        $this->assertIsArray($productCatalog);
        $this->assertEquals(4, count($productCatalog));
        $this->assertEquals(80, $productCatalog[0]['price']['final']);
        $this->assertEquals(160, $productCatalog[1]['price']['final']);
        $this->assertEquals(300, $productCatalog[2]['price']['final']);
        $this->assertEquals(333, $productCatalog[3]['price']['final']);
    }

    public function discountIsNullWhenNoPromotionApplied() : void
    {
        $productCatalog = $this->productCatalog->getProductCatalogWithBestPromotionsApplied();

        $this->assertIsArray($productCatalog);
        $this->assertNull($productCatalog[3]['price']['discount_percentage']);
    }

    public function testDiscountPercentageHasPercentageSymbol() : void
    {
        $productCatalog = $this->productCatalog->getProductCatalogWithBestPromotionsApplied();

        $this->assertIsArray($productCatalog);
        $this->assertEquals('20%', $productCatalog[0]['price']['discount_percentage']);
        $this->assertEquals('20%', $productCatalog[1]['price']['discount_percentage']);
        $this->assertEquals('25%', $productCatalog[2]['price']['discount_percentage']);
    }

    private function createProductRepositoryMock() : ProductRepository
    {
        $hotelInfoRepository = $this->createMock(ProductRepository::class, 'ProductRepository');
        $hotelInfoRepository->method('find')
            ->willReturn($this->createProductCollectionMockData());

        return $hotelInfoRepository;
    }

    private function createDiscountRepositoryMock() : DiscountRepository
    {
        $discountRepository = $this->createMock(DiscountRepository::class, 'DiscountRepository');
        $discountRepository->method('find')
            ->willReturn($this->createDiscountCollectionMockData());

        return $discountRepository;
    }

    private function createProductCollectionMockData() : ProductCollection
    {
        $collection = new ProductCollection();
        $collection->add(new Product('128', 'Item 1', new ProductCategory('shoes'), new Money(100, new Currency('USD'))));
        $collection->add(new Product('129', 'Item 2', new ProductCategory('shoes'), new Money(200, new Currency('USD'))));
        $collection->add(new Product('130', 'Item 4', new ProductCategory('shoes'), new Money(400, new Currency('USD'))));
        $collection->add(new Product('131', 'Item 5', new ProductCategory('boots'), new Money(333, new Currency('USD'))));

        return $collection;
    }

    private function createDiscountCollectionMockData() : DiscountCollection
    {
        $collection = new DiscountCollection();
        $collection->add(new DiscountBySku('129', 10));           // will not be applied as it is less than 20% (discount of category "shoes")
        $collection->add(new DiscountByCategory('shoes', 20));    // will be applied to all shoes
        $collection->add(new DiscountBySku('130', 25));           // will be applied to item 4

        return $collection;
    }
}
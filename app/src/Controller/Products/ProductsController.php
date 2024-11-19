<?php

declare(strict_types=1);

namespace App\Controller\Products;

use App\Application\Catalog\ProductCatalog;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ProductsController extends AbstractController
{
    /**
     * @param Request $request
     * @return JsonResponse
     *
     * @OA\Response(response=200, description="OK")
     * @OA\Response(response=500, description="Something wend wrong")
     * @OA\Tag(name="Products")
     * @OA\Parameter(
     *   name="category",
     *   in="query",
     *   style="simple",
     *   explode=false,
     *   description="Filter by category of the product (optional)",
     * )
     * @OA\Parameter(
     *   name="priceLessThan",
     *   in="query",
     *   style="simple",
     *   explode=false,
     *   description="Filter by price (optional)",
     * )
     */
    public function getProducts(Request $request, ProductCatalog $productCatalog): JsonResponse
    {
        try {
            $catalog = $productCatalog->findAllProducts();
            print_r($catalog);
            //return new JsonResponse($checkHealthStatus->execute());
            return new JsonResponse(
                'We are up and running!',
                Response::HTTP_OK
            );
        } catch (Throwable $e) {
            return new JsonResponse(
                'Sorry, we had some problems '.$e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}

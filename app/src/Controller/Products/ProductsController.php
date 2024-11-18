<?php

declare(strict_types=1);

namespace App\Controller\Products;

// use Atrapalo\Accommodation\Hcd\Application\Health\CheckHealthStatus;
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
     */
    public function getStatus(Request $request): JsonResponse
    {
        try {
            //return new JsonResponse($checkHealthStatus->execute());
            return new JsonResponse(
                'We are up and running!',
                Response::HTTP_OK
            );
        } catch (Throwable $e) {
            return new JsonResponse(
                'Sorry, we had some problems',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}

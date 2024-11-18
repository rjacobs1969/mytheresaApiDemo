<?php

declare(strict_types=1);

namespace App\Controller\HealthCheck;

// use Atrapalo\Accommodation\Hcd\Application\Health\CheckHealthStatus;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

class HealthController extends AbstractController
{
    /**
     * @param Request $request
     * @return JsonResponse
     *
     * @OA\Response(response=200, description="Returns the health status")
     * @OA\Response(response=500, description="Something wend wrong")
     * @OA\Tag(name="Health check")
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

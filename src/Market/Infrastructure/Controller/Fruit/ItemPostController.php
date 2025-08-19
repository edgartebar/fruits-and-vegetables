<?php

declare(strict_types=1);

namespace App\Market\Infrastructure\Controller\Fruit;

use App\Market\Application\Create\CreateItemDto;
use App\Market\Application\Create\CreateItemUseCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ItemPostController
{
    public function __construct(private CreateItemUseCase $useCase)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $this->useCase->__invoke(
            new CreateItemDto(
                $request->request->get('name'),
                (int) $request->request->get('weight'),
                $request->request->get('type'),
            )
        );

        return new JsonResponse([], Response::HTTP_OK);
    }
} 
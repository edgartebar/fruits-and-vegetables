<?php

declare(strict_types=1);

namespace App\Market\Infrastructure\Controller\Fruit;

use App\Market\Application\List\ListItemDto;
use App\Market\Application\List\ListItemUseCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ItemGetListController
{
    public function __construct(private ListItemUseCase $useCase)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $fruitResponse = $this->useCase->__invoke(
            new ListItemDto(
                $request->get('type'),
                (int) $request->get('gt'),
                (int) $request->get('lt'),
                $request->get('units', 'g')
            )
        );

        return new JsonResponse($fruitResponse, Response::HTTP_OK);
    }
} 
<?php

declare(strict_types=1);

namespace App\Market\Infrastructure\Controller\Fruit;

use App\Market\Application\Search\SearchItemDto;
use App\Market\Application\Search\SearchItemUseCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ItemGetSearchController
{
    public function __construct(private SearchItemUseCase $useCase)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $fruitResponse = $this->useCase->__invoke(
            new SearchItemDto(
                $request->query->get('type'),
                $request->query->get('name'),
                $request->query->get('order_by'),
                $request->query->get('order'),
                (int) $request->query->get('limit'),
                (int) $request->query->get('offset'),
                $request->query->get('units', 'g')
            )
        );

        return new JsonResponse($fruitResponse, Response::HTTP_OK);
    }
} 
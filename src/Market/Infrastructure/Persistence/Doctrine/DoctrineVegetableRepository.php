<?php

declare(strict_types=1);

namespace App\Market\Infrastructure\Persistence\Doctrine;

use App\Market\Domain\Vegetable;
use App\Market\Domain\VegetableId;
use App\Market\Domain\VegetableRepository;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

class DoctrineVegetableRepository extends DoctrineRepository implements VegetableRepository
{
    public function find(VegetableId $id): ?Vegetable
    {
        return $this->repository(Vegetable::class)->find($id);
    }

    public function list(?int $gt = null, ?int $lt = null): array
    {
        $qb = $this->repository(Vegetable::class)
            ->createQueryBuilder('v');

        if ($gt) {
            $qb->andWhere('v.weight.value >= :gt')
                ->setParameter(':gt', $gt);
        }

        if ($lt) {
            $qb->andWhere('v.weight.value <= :lt')
                ->setParameter(':lt', $lt);
        }

        return $qb->getQuery()->getResult();
    }

    public function save(Vegetable $vegetable): void
    {
        $this->persist($vegetable);
    }

    public function delete(Vegetable $vegetable): void
    {
        $this->remove($vegetable);
    }

    public function search(
        ?string $name = null,
        ?string $orderBy = null,
        ?string $order = null,
        ?int    $limit = null,
        ?int $offset = null
    ) :array
    {
        $qb = $this->repository(Vegetable::class)
            ->createQueryBuilder('v');

        if ($name) {
            $qb->andWhere('v.name.value LIKE :name')
                ->setParameter(':name', '%' . $name . '%');
        }

        if ($orderBy) {
            $qb->orderBy('v.' . $orderBy.'.value', $order ?? 'ASC');
        }

        if ($limit) {
            $qb->setMaxResults($limit);
        }

        if ($offset) {
            $qb->setFirstResult($offset);
        }

        return $qb->getQuery()->getResult();
    }
}
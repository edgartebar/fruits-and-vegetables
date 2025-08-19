<?php

declare(strict_types=1);

namespace App\Market\Infrastructure\Persistence\Doctrine;

use App\Market\Domain\Fruit;
use App\Market\Domain\FruitId;
use App\Market\Domain\FruitRepository;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

class DoctrineFruitRepository extends DoctrineRepository implements FruitRepository
{
    public function find(FruitId $id): ?Fruit
    {
        return $this->repository(Fruit::class)->find($id);
    }

    public function list(?int $gt = null, ?int $lt = null): array
    {
        $qb = $this->repository(Fruit::class)
            ->createQueryBuilder('f');

        if ($gt) {
            $qb->andWhere('f.weight.value >= :gt')
                ->setParameter(':gt', $gt);
        }

        if ($lt) {
            $qb->andWhere('f.weight.value <= :lt')
                ->setParameter(':lt', $lt);
        }

        return $qb->getQuery()->getResult();
    }

    public function save(Fruit $fruit): void
    {
        $this->persist($fruit);
    }

    public function delete(Fruit $fruit): void
    {
        $this->remove($fruit);
    }

    public function search(
        ?string $name = null,
        ?string $orderBy = null,
        ?string $order = null,
        ?int    $limit = null,
        ?int $offset = null
    ) :array
    {
        $qb = $this->repository(Fruit::class)
            ->createQueryBuilder('f');

        if ($name) {
            $qb->andWhere('f.name.value LIKE :name')
                ->setParameter(':name', '%' . $name . '%');
        }

        if ($orderBy) {
            $qb->orderBy('f.' . $orderBy.'.value', $order ?? 'ASC');
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

<?php

namespace App\Tests\Functional\Market\Aplication\Create;

use App\Market\Domain\Fruit;
use App\Market\Domain\Vegetable;
use App\Tests\Functional\DataFixtures\FruitsDataFixture;
use App\Tests\Functional\DataFixtures\VegetablesDataFixture;
use App\Tests\Functional\FunctionalTestCase;
use Doctrine\Common\DataFixtures\ReferenceRepository;

class CreateItemTest extends FunctionalTestCase
{
    private ReferenceRepository $referenceRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->referenceRepository = $this->databaseTool->loadFixtures([
            FruitsDataFixture::class,
            VegetablesDataFixture::class,
        ])->getReferenceRepository();
    }

    public function testFruitItemCreation(): void
    {
        $this->client->request(
            'POST',
            '/items',
            [
                'name' => 'Test Item',
                'weight' => 100,
                'type' => 'fruit',
                'unit' => 'kg',
            ],
            [],
            ['CONTENT_TYPE' => 'application/json'],
        );

        $this->assertResponseIsSuccessful();

        $fruitRepository = $this->referenceRepository->getManager()->getRepository(Fruit::class);

        $fruits = $fruitRepository->findAll();

        $this->assertCount(4, $fruits);
    }

    public function testVegetableItemCreation(): void
    {
        $this->client->request(
            'POST',
            '/items',
            [
                'name' => 'Test Vegetable',
                'weight' => 200,
                'type' => 'vegetable',
                'unit' => 'g',
            ],
            [],
            ['CONTENT_TYPE' => 'application/json'],
        );

        $this->assertResponseIsSuccessful();

        $vegetableRepository = $this->referenceRepository->getManager()->getRepository(Vegetable::class);

        $vegetables = $vegetableRepository->findAll();

        $this->assertCount(4, $vegetables);
    }
}
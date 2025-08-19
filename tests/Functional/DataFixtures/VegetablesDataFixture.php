<?php

namespace App\Tests\Functional\DataFixtures;

use App\Market\Domain\Vegetable;
use App\Market\Domain\VegetableId;
use App\Market\Domain\VegetableName;
use App\Market\Domain\VegetableWeight;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;

class VegetablesDataFixture extends AbstractFixture implements FixtureInterface
{
    const VEGETABLE_CARROT = 'vegetable_carrot';
    const VEGETABLE_POTATO = 'vegetable_potato';
    const VEGETABLE_TOMATO = 'vegetable_tomato';


    public function load(ObjectManager $manager): void
    {
        $carrot = Vegetable::create(
            VegetableId::random(),
            new VegetableName('Carrot'),
            new VegetableWeight(150)
        );

        $manager->persist($carrot);

        $potato = Vegetable::create(
            VegetableId::random(),
            new VegetableName('Potato'),
            new VegetableWeight(200)
        );
        $manager->persist($potato);

        $tomato = Vegetable::create(
            VegetableId::random(),
            new VegetableName('Tomato'),
            new VegetableWeight(100)
        );
        $manager->persist($tomato);

        $manager->flush();

        $this->setReference(self::VEGETABLE_CARROT, $carrot);
        $this->setReference(self::VEGETABLE_POTATO, $potato);
        $this->setReference(self::VEGETABLE_TOMATO, $tomato);
    }
}
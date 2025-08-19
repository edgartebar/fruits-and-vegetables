<?php

namespace App\Tests\Functional\DataFixtures;

use App\Market\Domain\Fruit;
use App\Market\Domain\FruitId;
use App\Market\Domain\FruitName;
use App\Market\Domain\FruitWeight;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;

class FruitsDataFixture extends AbstractFixture implements FixtureInterface
{
    const FRUIT_APPLE = 'fruit_apple';
    const FRUIT_BANANA = 'fruit_banana';
    const FRUIT_CHERRY = 'fruit_cherry';


    public function load(ObjectManager $manager): void
    {
        $fruitApple = Fruit::create(
            FruitId::random(),
            new FruitName('Apple'),
            new FruitWeight(150)
        );

        $manager->persist($fruitApple);

        $fruitBanana = Fruit::create(
            FruitId::random(),
            new FruitName('Banana'),
            new FruitWeight(120)
        );

        $manager->persist($fruitBanana);

        $fruitCherry = Fruit::create(
            FruitId::random(),
            new FruitName('Cherry'),
            new FruitWeight(10)
        );

        $manager->persist($fruitCherry);

        $manager->flush();

        $this->setReference(self::FRUIT_APPLE, $fruitApple);
        $this->setReference(self::FRUIT_BANANA, $fruitBanana);
        $this->setReference(self::FRUIT_CHERRY, $fruitCherry);
    }
}
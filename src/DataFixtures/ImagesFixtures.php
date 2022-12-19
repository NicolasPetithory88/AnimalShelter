<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Images;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ImagesFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        for($i = 1 ; $i <= 10; $i++){
            $img = new Images();
            $img->setName($faker->image(null, 640, 480));
            $animal = $this->getReference('animal-'.rand(1,10));
            $img->setAnimals($animal);
            $manager->persist($img);

        }

        $manager->flush();
    }
    public function getDependencies(): array{
        return [
            AnimalsFixtures::class
        ];
    }
}


<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Animals;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class AnimalsFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private SluggerInterface $slugger){}

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        for($i = 1; $i <= 10; $i++) {

            $animal = new Animals();
            $animal->setName($faker->firstName());
            $animal->setDescription($faker->text());
            $animal->setSlug($this->slugger->slug($animal->getName())->lower());
            // On va chercher une référence de sex
            $sex = $this->getReference('sex-'.rand(1,2));
            $animal->setSex($sex);

            while( in_array( ($n = mt_rand(1,16)), array(1, 9)));
            $race = $this->getReference('race-'.$n);
            $animal->setRaces($race);

            $status = $this->getReference('status-'.rand(1,3));
            $animal->setStatus($status);
            
            $this->SetReference('animal-'.$i , $animal);
            $manager->persist($animal);

        }
        $manager->flush();
    }
    public function getDependencies(): array{
        return [
            SexFixtures::class,
            RacesFixtures::class
        ];
    }
}

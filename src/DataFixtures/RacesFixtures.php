<?php

namespace App\DataFixtures;

use App\Entity\Races;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;

class RacesFixtures extends Fixture
{
    public $counter = 1;
    public function __construct(private SluggerInterface $slugger){}

    public function load(ObjectManager $manager): void
    {
        
        $parent = $this->createRace('Chien', null, $manager);

        $this->createRace('Doberman', $parent, $manager);        
        $this->createRace('Labrador', $parent, $manager);        
        $this->createRace('Bulldog', $parent, $manager);
        $this->createRace('Levrier', $parent, $manager);
        $this->createRace('Epagneul Breton', $parent, $manager);
        $this->createRace('Setter Irlandais', $parent, $manager);
        $this->createRace('Caniche', $parent, $manager);

        $parent = $this->createRace('Chat', null, $manager);

        $this->createRace('Siamois', $parent, $manager);        
        $this->createRace('Chat de gouttière', $parent, $manager);        
        $this->createRace('Chartreux', $parent, $manager);
        $this->createRace('Sphynx', $parent, $manager);
        $this->createRace('Chat de Bengual', $parent, $manager);
        $this->createRace('Persan', $parent, $manager);
        $this->createRace('Maine Coon', $parent, $manager);

        $manager->flush();
    }

    public function createRace(string $name, Races $parent = null, ObjectManager $manager){
        $race = new Races();
        $race->setName($name);
        $race->setSlug($this->slugger->slug($race->getName())->lower());    
        $race->setParent($parent);    
        $manager->persist($race);

        $this->addReference('race-'.$this->counter, $race);
        $this->counter++;

        return $race;
    }
}

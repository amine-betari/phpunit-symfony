<?php


namespace App\DataFixtures;

use App\Entity\Enclosure;
use App\Entity\Dinosaur;
use App\Factory\DinosaurFactory;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Bundle\FixturesBundle\Fixture;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

// class LoadBasicParkData extends AbstractFixture implements OrderedFixtureInterface
class LoadBasicParkData extends Fixture
{
    /* private $dinosaurFactory;

    public function __construct(DinosaurFactory $dinosaurFactory)
    {
        $this->dinosaurFactory = $dinosaurFactory;
    } */

   /* public function load(ObjectManager $manager)
    {
        $carnivorousEnclosure = new Enclosure();
        $manager->persist($carnivorousEnclosure);
        $this->addReference('carnivorous-enclosure', $carnivorousEnclosure);

        $herbivorousEnclosure = new Enclosure();
        $manager->persist($herbivorousEnclosure);
        $this->addReference('herbivorous-enclosure', $herbivorousEnclosure);

        $manager->persist(new Enclosure(true));
        $carnivorousEnclosure->addDinosaur($this->dinosaurFactory->createDinosaur('Velociraptor', true, 3));
        $carnivorousEnclosure->addDinosaur($this->dinosaurFactory->createDinosaur('Velociraptor', true, 1));
        $carnivorousEnclosure->addDinosaur($this->dinosaurFactory->createDinosaur('Velociraptor', true, 5));
        $carnivorousEnclosure->addDinosaur($this->dinosaurFactory->createDinosaur('Triceratops', true, 7));
          $manager->flush();
    }*/

    public function load(ObjectManager $manager)
    {
        $carnivorousEnclosure = new Enclosure();
        $manager->persist($carnivorousEnclosure);
        $this->addReference('carnivorous-enclosure', $carnivorousEnclosure);

        $herbivorousEnclosure = new Enclosure();
        $manager->persist($herbivorousEnclosure);
        $this->addReference('herbivorous-enclosure', $herbivorousEnclosure);

        $manager->persist(new Enclosure(true));

        $this->addDinosaur($manager, $carnivorousEnclosure, 'Velociraptor', true, 3);
        $this->addDinosaur($manager, $carnivorousEnclosure, 'Velociraptor', true, 1);
        $this->addDinosaur($manager, $carnivorousEnclosure, 'Velociraptor', true, 5);

        $this->addDinosaur($manager, $herbivorousEnclosure, 'Triceratops', false, 7);

        $manager->flush();
    }

    private function addDinosaur(
        ObjectManager $manager,
        Enclosure $enclosure,
        string $genus,
        bool $isCarnivorous,
        int $length
    )
    {
        $dinosaur = new Dinosaur($genus, $isCarnivorous);
        $dinosaur->setEnclosure($enclosure);
        $dinosaur->setLength($length);

        $manager->persist($dinosaur);
    }
}
<?php


namespace App\DataFixtures;

use App\Entity\Security;
use App\Entity\Enclosure;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Bundle\FixturesBundle\Fixture;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

// class LoadSecurityData extends AbstractFixture implements OrderedFixtureInterface
class LoadSecurityData extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $herbivorousEnclosure = $this->getReference('herbivorous-enclosure');
        $sec1 = new Security('Fence', true, $herbivorousEnclosure);
        $herbivorousEnclosure->addSecurity($sec1);

        $carnivorousEnclosure = $this->getReference('carnivorous-enclosure');
        $sec2 = new Security('Electric fence', false, $carnivorousEnclosure);
        $carnivorousEnclosure->addSecurity($sec2);

        $sec3 = new Security('Guard tower', false, $carnivorousEnclosure);
        $carnivorousEnclosure->addSecurity($sec3);

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
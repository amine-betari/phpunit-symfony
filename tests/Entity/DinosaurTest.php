<?php

// namespace Tests\AppBundle\Entity;
namespace App\Tests\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Dinosaur;


class DinosaurTest extends TestCase
{
    public function testThatYourComputerWorks()
    {
        $this->assertTrue(true);
    }

    public function testSettingLength()
    {
        $dinosaur = new Dinosaur();

        $this->assertSame(0, $dinosaur->getLength());
       // $this->assertTrue(0 === $dinosaur->getLength());

        $dinosaur->setLength(9);
        $this->assertSame(9, $dinosaur->getLength());
    }


    /*public function testDinosaurHasNotShrunk()
    {
        $dinosaur = new Dinosaur();
        $this->assertGreaterThan(12, $dinosaur->getLength(), 'Did you put it in the washing machine?');
    }*/


    public function testReturnsFullSpecificationOfDinosaur()
    {
        $dinosaur = new Dinosaur();
        $this->assertSame(
            'The Unknown non-carnivorous dinosaur is 0 meters long',
            $dinosaur->getSpecification()
        );
    }


    public function testReturnsFullSpecificationForTyrannosaurus()
    {
        $dinosaur = new Dinosaur('Tyrannosaurus', true);
        $dinosaur->setLength(12);
        $this->assertSame(
            'The Tyrannosaurus carnivorous dinosaur is 12 meters long',
            $dinosaur->getSpecification()
        );
    }
}

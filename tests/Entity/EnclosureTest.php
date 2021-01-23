<?php
/**
 * Created by PhpStorm.
 * User: aminebetari
 * Date: 03/12/20
 * Time: 11:53
 */

namespace App\Tests\Entity;


use App\Exception\NotABuffetException;
use PHPUnit\Framework\TestCase;
use App\Entity\Dinosaur;
use App\Entity\Enclosure;
use App\Exception\DinosaursAreRunningRampantException;


class EnclosureTest extends TestCase
{
    public function testItHasNoDinosaursByDefault()
    {
        $enclosure = new Enclosure();
        $this->assertEmpty($enclosure->getDinosaurs());
    }

    public function testItAddsDinosaurs()
    {
        $enclosure = new Enclosure(true);

        $enclosure->addDinosaur(new Dinosaur());
        $enclosure->addDinosaur(new Dinosaur(true));

        $this->assertCount(2,  $enclosure->getDinosaurs());
    }

    public function testItDoesNotAllowCarnivorousDinosToMixWithHerbivores()
    {
        $enclosure = new Enclosure(true);

        $enclosure->addDinosaur(new Dinosaur());

        $this->expectException(NotABuffetException::class);

        $enclosure->addDinosaur(new Dinosaur('Velociraptor', true));
    }


    /**
     * @expectedException \App\Exception\NotABuffetException
     */
    /*public function testItDoesNotAllowToAddNonCarnivorousDinosaursToCarnivorousEnclosure()
    {
        $enclosure = new Enclosure(true);

        $enclosure->addDinosaur(new Dinosaur('Velociraptor', false));
        $enclosure->addDinosaur(new Dinosaur());
    }*/


   /* public function testItDoesNotAllowToAddDinosToUnsecureEnclosures()
    {
        $enclosure = new Enclosure();
        $this->expectException(DinosaursAreRunningRampantException::class);
        $this->expectExceptionMessage('Are you craaazy?!?');
        $enclosure->addDinosaur(new Dinosaur());
    }*/

}
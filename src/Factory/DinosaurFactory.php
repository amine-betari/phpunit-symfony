<?php
/**
 * Created by PhpStorm.
 * User: aminebetari
 * Date: 30/11/20
 * Time: 17:40
 */

namespace App\Factory;

use App\Entity\Dinosaur;
use App\Service\DinosaurLengthDeterminator;

class DinosaurFactory
{
    private $lengthDeterminator;

    public function __construct(DinosaurLengthDeterminator $lengthDeterminator)
    {
        $this->lengthDeterminator = $lengthDeterminator;
    }

    public function createDinosaur(string $genus, bool $isCarnivorous, int $length)
    {
        $dinosaur = new Dinosaur($genus, $isCarnivorous);

        $dinosaur->setLength($length);

        return $dinosaur;
    }



    public function growVelociraptor(int $length): Dinosaur
    {
        return $this->createDinosaur('Velociraptor', true, $length);
    }


    public function growFromSpecification(string $specification): Dinosaur
    {
        // defaults
        $codeName = 'InG-' . random_int(1, 99999);
        $length = $this->lengthDeterminator->getLengthFromSpecification($specification);
        $isCarnivorous = false;


        return $this->createDinosaur($codeName, $isCarnivorous, $length);
    }

}
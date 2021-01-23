<?php


namespace App\Tests\Service;

use App\Entity\Dinosaur;
use App\Entity\Enclosure;
use App\Service\EnclosureBuilderService;
use PHPUnit\Framework\TestCase;
use App\Factory\DinosaurFactory;
use Doctrine\ORM\EntityManagerInterface;

class EnclosureBuilderServiceTest extends TestCase
{

    public function testItBuildsAndPersistsEnclosure()
    {
        $em          = $this->createMock(EntityManagerInterface::class);
        $dinoFactory = $this->createMock(DinosaurFactory::class);

        $em->expects($this->once())
            ->method('persist')
            ->with($this->isInstanceOf(Enclosure::class));

        $em->expects($this->atLeastOnce())
            ->method('flush');

        $dinoFactory->expects($this->exactly(5))
            ->method('growFromSpecification')
            ->willReturn(new Dinosaur())
            ->with($this->isType('string'));

        $builder = new EnclosureBuilderService($em, $dinoFactory);
        $enclosure = $builder->buildEnclosure(1, 5);

        $this->assertCount(1, $enclosure->getSecurities());
        $this->assertCount(5, $enclosure->getDinosaurs());
    }
}
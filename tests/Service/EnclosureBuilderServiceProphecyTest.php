<?php


namespace App\Tests\Service;


use App\Entity\Dinosaur;
use App\Factory\DinosaurFactory;
use App\Service\EnclosureBuilderService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use App\Entity\Enclosure;
use Prophecy\Argument;

class EnclosureBuilderServiceProphecyTest extends TestCase
{
    public function testItBuildsAndPersistsEnclosure()
    {
        $em = $this->prophesize(EntityManagerInterface::class);

        $em->persist(Argument::type(Enclosure::class))
            ->shouldBeCalledTimes(1);

        $em->flush()->shouldBeCalled();

        $dinoFactory = $this->prophesize(DinosaurFactory::class);

        $dinoFactory
            ->growFromSpecification(Argument::type('string'))
            ->shouldBeCalledTimes(5)
            ->willReturn(new Dinosaur());

        $builder = new EnclosureBuilderService(
            $em->reveal(),
            $dinoFactory->reveal()
        );
        $enclosure = $builder->buildEnclosure(1, 5);

        $this->assertCount(1, $enclosure->getSecurities());
        $this->assertCount(5, $enclosure->getDinosaurs());

    }
}
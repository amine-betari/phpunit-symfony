<?php
/**
 * Created by PhpStorm.
 * User: aminebetari
 * Date: 30/11/20
 * Time: 17:44
 */

namespace App\Tests\Factory;


use PHPUnit\Framework\TestCase;
use App\Factory\DinosaurFactory;
use App\Service\DinosaurLengthDeterminator;
use App\Entity\Dinosaur;


class DinosaurFactoryTest extends TestCase
{

    /**
     * @var DinosaurFactory
     */
    private $factory;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $lengthDeterminator;

    // it will be called before each test
    public function setUp(): void
    {
        // when you create a mock, it creates a new class in memory that extends the original,
        // but overrides every method and simply returns null.
        // Also, by default, all methods are mocked. But you can use the setMethods() function to only mock some methods.
        $this->lengthDeterminator = $this->createMock(DinosaurLengthDeterminator::class);
        $this->factory = new DinosaurFactory($this->lengthDeterminator);
    }

    // it will be called after each test
    public function tearDown(): void
    {
    }



    public function testItGrowsALargeVelociraptor()
    {
        $dinosaur = $this->factory->growVelociraptor(5);


        $this->assertInstanceOf(Dinosaur::class, $dinosaur);
//        $this->assertInternalType('string', $dinosaur->getGenus());
        $this->assertSame('Velociraptor', $dinosaur->getGenus());
        $this->assertSame(5, $dinosaur->getLength());

    }


    public function testItGrowsABabyVelociraptor()
    {
        if (!class_exists('Nanny')) {
            $this->markTestSkipped('There is nobody to watch the baby!');
        }
        $dinosaur = $this->factory->growVelociraptor(1);
        $this->assertSame(1, $dinosaur->getLength());
    }


    /**
     * @dataProvider getSpecificationTests
     */
    public function testItGrowsADinosaurFromSpecification(string $spec, bool $expectedIsCarnivorous)
    {
        $this->lengthDeterminator->method('getLengthFromSpecification')
            ->willReturn(20);

        $dinosaur = $this->factory->growFromSpecification($spec);

        $this->assertSame($expectedIsCarnivorous, $dinosaur->isCarnivorous(), 'Diets do not match');
        $this->assertSame(20, $dinosaur->getLength());

    }

    public function getSpecificationTests()
    {
        return [
            // specification, is carnivorous
            ['large carnivorous dinosaur', false],
            ['give me all the cookies!!!', false],
            ['large herbivore', false],
        ];
    }

//
//    /**
//     * @dataProvider getHugeDinosaurSpecTests
//     */
//    public function testItGrowsAHugeDinosaur(string $specification)
//    {
//        $dinosaur = $this->factory->growFromSpecification($specification);
//        $this->assertGreaterThanOrEqual(Dinosaur::HUGE, $dinosaur->getLength());
//    }
//
//    public function getHugeDinosaurSpecTests()
//    {
//        return [
//            ['huge dinosaur'],
//            ['huge dino'],
//            ['huge'],
//            ['OMG'],
//            ['😱'],
//        ];
//    }
}
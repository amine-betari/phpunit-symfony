<?php


namespace App\Tests\Service;

use App\Entity\Dinosaur;
use App\Entity\Security;
use App\Entity\Enclosure;
use App\Factory\DinosaurFactory;
use App\Service\EnclosureBuilderService;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EnclosureBuilderServiceIntegrationTest extends KernelTestCase
{

    protected function setUp(): void
    {
        self::bootKernel();

        $this->truncateEntities([
            Enclosure::class,
            Security::class,
            Dinosaur::class,
        ]);
    }

    public function testItBuildsEnclosureWithDefaultSpecifications()
    {

        /** @var EnclosureBuilderService $enclosureBuilderService */

       // $enclosureBuilderService = self::$kernel->getContainer()
       //      ->get('test.'. EnclosureBuilderService::class);

        // Partial Mocking

        $dinoFactory = $this->createMock(DinosaurFactory::class);
        $dinoFactory->expects($this->any())
            ->method('growFromSpecification')
            ->willReturnCallback(function($spec) {
                return new Dinosaur();
            });
        // ===> The fix is to change this to willReturnCallback() and pass it a function. This will be called each time growFromSpecification() is called. And since it is passed a $specification argument, the callback also receives this. It's the best way to return different values based on the arguments.

        $enclosureBuilderService = new EnclosureBuilderService(
          $this->getEntityManager(),
          $dinoFactory
        );

        $enclosureBuilderService->buildEnclosure();

        /** @var EntityManagerInterface $em */
        $em = self::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $count = (int) $em->getRepository(Security::class)
            ->createQueryBuilder('s')
            ->select('COUNT(s.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $this->assertSame(1, $count, 'Amount of security systems is not the same');

        $count = (int) $em->getRepository(Dinosaur::class)
            ->createQueryBuilder('d')
            ->select('COUNT(d.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $this->assertSame(3, $count, 'Amount of dinosaurs systems is not the same');
    }


    private function truncateEntities(array $entities)
    {
        $purger = new ORMPurger($this->getEntityManager());
        $purger->purge();

       /* $connection = $this->getEntityManager()->getConnection();
        $databasePlatform = $connection->getDatabasePlatform();
        if ($databasePlatform->supportsForeignKeyConstraints()) {
            $connection->query('SET FOREIGN_KEY_CHECKS=0');
        }
        foreach ($entities as $entity) {
            $query = $databasePlatform->getTruncateTableSQL(
                $this->getEntityManager()->getClassMetadata($entity)->getTableName()
            );
            $connection->executeUpdate($query);
        }
        if ($databasePlatform->supportsForeignKeyConstraints()) {
            $connection->query('SET FOREIGN_KEY_CHECKS=1');
        }*/
    }

    /**
     * @return EntityManagerInterface
     */
    private function getEntityManager()
    {
        return self::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }
}
<?php


namespace App\Tests\Fixtures;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Bridge\Doctrine\DataFixtures\ContainerAwareLoader;

class FixtureAwareTestCase extends KernelTestCase
{
    private $fixtureExecutor;

    private $fixtureLoader;

    public function setUp(): void
    {
        self::bootKernel();
    }

    public function addFixtures(FixtureInterface $fixture)
    {
        $this->getFixtureLoader()->addFixture($fixture);
    }

    public function executeFixtures()
    {
        $this->getFixtureExecutor()->execute($this->getFixtureLoader()->getFixtures());
    }

    public function getFixtureExecutor()
    {
        if (!$this->fixtureExecutor) {
            $entityManager = self::$kernel->getContainer()->get('doctrine')->getManager();
            $this->fixtureExecutor = new ORMExecutor($entityManager, new ORMPurger($entityManager));
        }

        return $this->fixtureExecutor;
    }

    public function getFixtureLoader()
    {
        if (!$this->fixtureLoader) {
            $this->fixtureLoader = new ContainerAwareLoader(self::$kernel->getContainer());
        }

        return $this->fixtureLoader;
    }
}
<?php


namespace App\Tests\Controller;

use App\Factory\DinosaurFactory;
use App\Service\DinosaurLengthDeterminator;
use App\Tests\Fixtures\FixtureAwareTestCase;
use Liip\FunctionalTestBundle\Test\WebTestCase;
use App\DataFixtures\LoadBasicParkData;
use App\DataFixtures\LoadSecurityData;

class DefaultControllerTest extends WebTestCase
{
    private $fixtures;

    public function setUp(): void
    {
        self::bootKernel();

        $this->fixtures = new FixtureAwareTestCase();
        // à re factoriser
       // $this->fixtures->addFixtures(new LoadBasicParkData(new DinosaurFactory(new DinosaurLengthDeterminator())));
        $this->fixtures->addFixtures(new LoadBasicParkData());
        $this->fixtures->addFixtures(new LoadSecurityData());

        $this->fixtures->executeFixtures();
    }

    public function testEnclosuresAreShownOnHomepage()
    {
        self::ensureKernelShutdown();

        $client = $this->makeClient();

        $crawler = $client->request('GET', '/');
        $this->assertStatusCode(200, $client);

        $table = $crawler->filter('.table-enclosures');
        $this->assertCount(3, $table->filter('tbody tr'));
    }


    public function testThatThereIsAnAlarmButtonWithoutSecurity()
    {
        $fixtures =  $this->fixtures;
        self::ensureKernelShutdown();

        $client = $this->makeClient();
        $crawler = $client->request('GET', '/');

        $enclosure = $fixtures->getFixtureExecutor()->getReferenceRepository()->getReference('carnivorous-enclosure');
        $selector = sprintf('#enclosure-%s .button-alarm', $enclosure->getId());
        $this->assertGreaterThan(0, $crawler->filter($selector)->count());
    }

    public function testItGrowsADinosaurFromSpecification()
    {
        $fixtures =  $this->fixtures;
        self::ensureKernelShutdown();

        $client = $this->makeClient();
        $client->followRedirects();

        $crawler = $client->request('GET', '/');

        $this->assertStatusCode(200, $client);

        $form = $crawler->selectButton('Grow dinosaur')->form();
      //  $form['enclosure']->select();
        $form['specification']->setValue('large herbivore');

        $client->submit($form);

      /* $this->assertContains(
            'Grew a large herbivore in enclosure #3',
            $client->getResponse()->getContent()
        ); */

    }

}
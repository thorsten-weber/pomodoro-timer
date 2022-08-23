<?php

namespace App\Test\Controller;

use App\Entity\Pomodoros;
use App\Repository\PomodorosRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PomodorosControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private PomodorosRepository $repository;
    private string $path = '/pomodoros/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Pomodoros::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Pomodoro index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'pomodoro[duration]' => 'Testing',
            'pomodoro[short_break]' => 'Testing',
            'pomodoro[long_break]' => 'Testing',
            'pomodoro[cycles]' => 'Testing',
            'pomodoro[creation_date]' => 'Testing',
            'pomodoro[cycles_to_long_break]' => 'Testing',
        ]);

        self::assertResponseRedirects('/pomodoros/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Pomodoros();
        $fixture->setDuration('My Title');
        $fixture->setShort_break('My Title');
        $fixture->setLong_break('My Title');
        $fixture->setCycles('My Title');
        $fixture->setCreation_date('My Title');
        $fixture->setCycles_to_long_break('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Pomodoro');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Pomodoros();
        $fixture->setDuration('My Title');
        $fixture->setShort_break('My Title');
        $fixture->setLong_break('My Title');
        $fixture->setCycles('My Title');
        $fixture->setCreation_date('My Title');
        $fixture->setCycles_to_long_break('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'pomodoro[duration]' => 'Something New',
            'pomodoro[short_break]' => 'Something New',
            'pomodoro[long_break]' => 'Something New',
            'pomodoro[cycles]' => 'Something New',
            'pomodoro[creation_date]' => 'Something New',
            'pomodoro[cycles_to_long_break]' => 'Something New',
        ]);

        self::assertResponseRedirects('/pomodoros/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getDuration());
        self::assertSame('Something New', $fixture[0]->getShort_break());
        self::assertSame('Something New', $fixture[0]->getLong_break());
        self::assertSame('Something New', $fixture[0]->getCycles());
        self::assertSame('Something New', $fixture[0]->getCreation_date());
        self::assertSame('Something New', $fixture[0]->getCycles_to_long_break());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Pomodoros();
        $fixture->setDuration('My Title');
        $fixture->setShort_break('My Title');
        $fixture->setLong_break('My Title');
        $fixture->setCycles('My Title');
        $fixture->setCreation_date('My Title');
        $fixture->setCycles_to_long_break('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/pomodoros/');
    }
}

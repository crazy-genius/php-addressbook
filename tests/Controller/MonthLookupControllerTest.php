<?php

namespace AddressBook\Test\Controller;

use AddressBook\Entity\MonthLookup;
use AddressBook\Repository\MonthLookupRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MonthLookupControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private MonthLookupRepository $repository;
    private string $path = '/month/lookup/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(MonthLookup::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('MonthLookup index');

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
            'month_lookup[bmonth]' => 'Testing',
            'month_lookup[bmonthShort]' => 'Testing',
        ]);

        self::assertResponseRedirects('/month/lookup/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new MonthLookup();
        $fixture->setBmonth('My Title');
        $fixture->setBmonthShort('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('MonthLookup');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new MonthLookup();
        $fixture->setBmonth('My Title');
        $fixture->setBmonthShort('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'month_lookup[bmonth]' => 'Something New',
            'month_lookup[bmonthShort]' => 'Something New',
        ]);

        self::assertResponseRedirects('/month/lookup/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getBmonth());
        self::assertSame('Something New', $fixture[0]->getBmonthShort());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new MonthLookup();
        $fixture->setBmonth('My Title');
        $fixture->setBmonthShort('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/month/lookup/');
    }
}

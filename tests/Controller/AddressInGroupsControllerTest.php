<?php

namespace AddressBook\Test\Controller;

use AddressBook\Entity\AddressInGroups;
use AddressBook\Repository\AddressInGroupsRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AddressInGroupsControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private AddressInGroupsRepository $repository;
    private string $path = '/address/in/groups/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(AddressInGroups::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('AddressInGroup index');

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
            'address_in_group[id]' => 'Testing',
            'address_in_group[groupId]' => 'Testing',
            'address_in_group[domainId]' => 'Testing',
            'address_in_group[created]' => 'Testing',
            'address_in_group[modified]' => 'Testing',
            'address_in_group[deprecated]' => 'Testing',
        ]);

        self::assertResponseRedirects('/address/in/groups/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new AddressInGroups();
        $fixture->setId('My Title');
        $fixture->setGroupId('My Title');
        $fixture->setDomainId('My Title');
        $fixture->setCreated('My Title');
        $fixture->setModified('My Title');
        $fixture->setDeprecated('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('AddressInGroup');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new AddressInGroups();
        $fixture->setId('My Title');
        $fixture->setGroupId('My Title');
        $fixture->setDomainId('My Title');
        $fixture->setCreated('My Title');
        $fixture->setModified('My Title');
        $fixture->setDeprecated('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'address_in_group[id]' => 'Something New',
            'address_in_group[groupId]' => 'Something New',
            'address_in_group[domainId]' => 'Something New',
            'address_in_group[created]' => 'Something New',
            'address_in_group[modified]' => 'Something New',
            'address_in_group[deprecated]' => 'Something New',
        ]);

        self::assertResponseRedirects('/address/in/groups/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getId());
        self::assertSame('Something New', $fixture[0]->getGroupId());
        self::assertSame('Something New', $fixture[0]->getDomainId());
        self::assertSame('Something New', $fixture[0]->getCreated());
        self::assertSame('Something New', $fixture[0]->getModified());
        self::assertSame('Something New', $fixture[0]->getDeprecated());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new AddressInGroups();
        $fixture->setId('My Title');
        $fixture->setGroupId('My Title');
        $fixture->setDomainId('My Title');
        $fixture->setCreated('My Title');
        $fixture->setModified('My Title');
        $fixture->setDeprecated('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/address/in/groups/');
    }
}

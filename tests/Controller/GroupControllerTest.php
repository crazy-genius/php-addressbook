<?php

namespace AddressBook\Test\Controller;

use AddressBook\Entity\Group;
use AddressBook\Repository\GroupRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GroupControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private GroupRepository $repository;
    private string $path = '/group/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Group::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Group index');

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
            'group[domainId]' => 'Testing',
            'group[groupId]' => 'Testing',
            'group[groupParentId]' => 'Testing',
            'group[created]' => 'Testing',
            'group[modified]' => 'Testing',
            'group[deprecated]' => 'Testing',
            'group[groupName]' => 'Testing',
            'group[groupHeader]' => 'Testing',
            'group[groupFooter]' => 'Testing',
        ]);

        self::assertResponseRedirects('/group/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Group();
        $fixture->setDomainId('My Title');
        $fixture->setGroupId('My Title');
        $fixture->setGroupParentId('My Title');
        $fixture->setCreated('My Title');
        $fixture->setModified('My Title');
        $fixture->setDeprecated('My Title');
        $fixture->setGroupName('My Title');
        $fixture->setGroupHeader('My Title');
        $fixture->setGroupFooter('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Group');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Group();
        $fixture->setDomainId('My Title');
        $fixture->setGroupId('My Title');
        $fixture->setGroupParentId('My Title');
        $fixture->setCreated('My Title');
        $fixture->setModified('My Title');
        $fixture->setDeprecated('My Title');
        $fixture->setGroupName('My Title');
        $fixture->setGroupHeader('My Title');
        $fixture->setGroupFooter('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'group[domainId]' => 'Something New',
            'group[groupId]' => 'Something New',
            'group[groupParentId]' => 'Something New',
            'group[created]' => 'Something New',
            'group[modified]' => 'Something New',
            'group[deprecated]' => 'Something New',
            'group[groupName]' => 'Something New',
            'group[groupHeader]' => 'Something New',
            'group[groupFooter]' => 'Something New',
        ]);

        self::assertResponseRedirects('/group/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getDomainId());
        self::assertSame('Something New', $fixture[0]->getGroupId());
        self::assertSame('Something New', $fixture[0]->getGroupParentId());
        self::assertSame('Something New', $fixture[0]->getCreated());
        self::assertSame('Something New', $fixture[0]->getModified());
        self::assertSame('Something New', $fixture[0]->getDeprecated());
        self::assertSame('Something New', $fixture[0]->getGroupName());
        self::assertSame('Something New', $fixture[0]->getGroupHeader());
        self::assertSame('Something New', $fixture[0]->getGroupFooter());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Group();
        $fixture->setDomainId('My Title');
        $fixture->setGroupId('My Title');
        $fixture->setGroupParentId('My Title');
        $fixture->setCreated('My Title');
        $fixture->setModified('My Title');
        $fixture->setDeprecated('My Title');
        $fixture->setGroupName('My Title');
        $fixture->setGroupHeader('My Title');
        $fixture->setGroupFooter('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/group/');
    }
}

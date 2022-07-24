<?php

namespace AddressBook\Test\Controller;

use AddressBook\Entity\AddressBook;
use AddressBook\Repository\AddressBookRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AddressbookControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private AddressBookRepository $repository;
    private string $path = '/addressbook/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(AddressBook::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Addressbook index');

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
            'addressbook[domainId]' => 'Testing',
            'addressbook[firstname]' => 'Testing',
            'addressbook[middlename]' => 'Testing',
            'addressbook[lastname]' => 'Testing',
            'addressbook[nickname]' => 'Testing',
            'addressbook[company]' => 'Testing',
            'addressbook[title]' => 'Testing',
            'addressbook[address]' => 'Testing',
            'addressbook[addrLong]' => 'Testing',
            'addressbook[addrLat]' => 'Testing',
            'addressbook[addrStatus]' => 'Testing',
            'addressbook[home]' => 'Testing',
            'addressbook[mobile]' => 'Testing',
            'addressbook[work]' => 'Testing',
            'addressbook[fax]' => 'Testing',
            'addressbook[email]' => 'Testing',
            'addressbook[email2]' => 'Testing',
            'addressbook[email3]' => 'Testing',
            'addressbook[im]' => 'Testing',
            'addressbook[im2]' => 'Testing',
            'addressbook[im3]' => 'Testing',
            'addressbook[homepage]' => 'Testing',
            'addressbook[bday]' => 'Testing',
            'addressbook[bmonth]' => 'Testing',
            'addressbook[byear]' => 'Testing',
            'addressbook[aday]' => 'Testing',
            'addressbook[amonth]' => 'Testing',
            'addressbook[ayear]' => 'Testing',
            'addressbook[address2]' => 'Testing',
            'addressbook[phone2]' => 'Testing',
            'addressbook[notes]' => 'Testing',
            'addressbook[photo]' => 'Testing',
            'addressbook[xVcard]' => 'Testing',
            'addressbook[xActivesync]' => 'Testing',
            'addressbook[created]' => 'Testing',
            'addressbook[modified]' => 'Testing',
            'addressbook[deprecated]' => 'Testing',
            'addressbook[password]' => 'Testing',
            'addressbook[login]' => 'Testing',
            'addressbook[role]' => 'Testing',
        ]);

        self::assertResponseRedirects('/addressbook/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new AddressBook();
        $fixture->setDomainId('My Title');
        $fixture->setFirstname('My Title');
        $fixture->setMiddlename('My Title');
        $fixture->setLastname('My Title');
        $fixture->setNickname('My Title');
        $fixture->setCompany('My Title');
        $fixture->setTitle('My Title');
        $fixture->setAddress('My Title');
        $fixture->setAddrLong('My Title');
        $fixture->setAddrLat('My Title');
        $fixture->setAddrStatus('My Title');
        $fixture->setHome('My Title');
        $fixture->setMobile('My Title');
        $fixture->setWork('My Title');
        $fixture->setFax('My Title');
        $fixture->setEmail('My Title');
        $fixture->setEmail2('My Title');
        $fixture->setEmail3('My Title');
        $fixture->setIm('My Title');
        $fixture->setIm2('My Title');
        $fixture->setIm3('My Title');
        $fixture->setHomepage('My Title');
        $fixture->setBday('My Title');
        $fixture->setBmonth('My Title');
        $fixture->setByear('My Title');
        $fixture->setAday('My Title');
        $fixture->setAmonth('My Title');
        $fixture->setAyear('My Title');
        $fixture->setAddress2('My Title');
        $fixture->setPhone2('My Title');
        $fixture->setNotes('My Title');
        $fixture->setPhoto('My Title');
        $fixture->setXVcard('My Title');
        $fixture->setXActivesync('My Title');
        $fixture->setCreated('My Title');
        $fixture->setModified('My Title');
        $fixture->setDeprecated('My Title');
        $fixture->setPassword('My Title');
        $fixture->setLogin('My Title');
        $fixture->setRole('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Addressbook');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new AddressBook();
        $fixture->setDomainId('My Title');
        $fixture->setFirstname('My Title');
        $fixture->setMiddlename('My Title');
        $fixture->setLastname('My Title');
        $fixture->setNickname('My Title');
        $fixture->setCompany('My Title');
        $fixture->setTitle('My Title');
        $fixture->setAddress('My Title');
        $fixture->setAddrLong('My Title');
        $fixture->setAddrLat('My Title');
        $fixture->setAddrStatus('My Title');
        $fixture->setHome('My Title');
        $fixture->setMobile('My Title');
        $fixture->setWork('My Title');
        $fixture->setFax('My Title');
        $fixture->setEmail('My Title');
        $fixture->setEmail2('My Title');
        $fixture->setEmail3('My Title');
        $fixture->setIm('My Title');
        $fixture->setIm2('My Title');
        $fixture->setIm3('My Title');
        $fixture->setHomepage('My Title');
        $fixture->setBday('My Title');
        $fixture->setBmonth('My Title');
        $fixture->setByear('My Title');
        $fixture->setAday('My Title');
        $fixture->setAmonth('My Title');
        $fixture->setAyear('My Title');
        $fixture->setAddress2('My Title');
        $fixture->setPhone2('My Title');
        $fixture->setNotes('My Title');
        $fixture->setPhoto('My Title');
        $fixture->setXVcard('My Title');
        $fixture->setXActivesync('My Title');
        $fixture->setCreated('My Title');
        $fixture->setModified('My Title');
        $fixture->setDeprecated('My Title');
        $fixture->setPassword('My Title');
        $fixture->setLogin('My Title');
        $fixture->setRole('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'addressbook[domainId]' => 'Something New',
            'addressbook[firstname]' => 'Something New',
            'addressbook[middlename]' => 'Something New',
            'addressbook[lastname]' => 'Something New',
            'addressbook[nickname]' => 'Something New',
            'addressbook[company]' => 'Something New',
            'addressbook[title]' => 'Something New',
            'addressbook[address]' => 'Something New',
            'addressbook[addrLong]' => 'Something New',
            'addressbook[addrLat]' => 'Something New',
            'addressbook[addrStatus]' => 'Something New',
            'addressbook[home]' => 'Something New',
            'addressbook[mobile]' => 'Something New',
            'addressbook[work]' => 'Something New',
            'addressbook[fax]' => 'Something New',
            'addressbook[email]' => 'Something New',
            'addressbook[email2]' => 'Something New',
            'addressbook[email3]' => 'Something New',
            'addressbook[im]' => 'Something New',
            'addressbook[im2]' => 'Something New',
            'addressbook[im3]' => 'Something New',
            'addressbook[homepage]' => 'Something New',
            'addressbook[bday]' => 'Something New',
            'addressbook[bmonth]' => 'Something New',
            'addressbook[byear]' => 'Something New',
            'addressbook[aday]' => 'Something New',
            'addressbook[amonth]' => 'Something New',
            'addressbook[ayear]' => 'Something New',
            'addressbook[address2]' => 'Something New',
            'addressbook[phone2]' => 'Something New',
            'addressbook[notes]' => 'Something New',
            'addressbook[photo]' => 'Something New',
            'addressbook[xVcard]' => 'Something New',
            'addressbook[xActivesync]' => 'Something New',
            'addressbook[created]' => 'Something New',
            'addressbook[modified]' => 'Something New',
            'addressbook[deprecated]' => 'Something New',
            'addressbook[password]' => 'Something New',
            'addressbook[login]' => 'Something New',
            'addressbook[role]' => 'Something New',
        ]);

        self::assertResponseRedirects('/addressbook/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getDomainId());
        self::assertSame('Something New', $fixture[0]->getFirstname());
        self::assertSame('Something New', $fixture[0]->getMiddlename());
        self::assertSame('Something New', $fixture[0]->getLastname());
        self::assertSame('Something New', $fixture[0]->getNickname());
        self::assertSame('Something New', $fixture[0]->getCompany());
        self::assertSame('Something New', $fixture[0]->getTitle());
        self::assertSame('Something New', $fixture[0]->getAddress());
        self::assertSame('Something New', $fixture[0]->getAddrLong());
        self::assertSame('Something New', $fixture[0]->getAddrLat());
        self::assertSame('Something New', $fixture[0]->getAddrStatus());
        self::assertSame('Something New', $fixture[0]->getHome());
        self::assertSame('Something New', $fixture[0]->getMobile());
        self::assertSame('Something New', $fixture[0]->getWork());
        self::assertSame('Something New', $fixture[0]->getFax());
        self::assertSame('Something New', $fixture[0]->getEmail());
        self::assertSame('Something New', $fixture[0]->getEmail2());
        self::assertSame('Something New', $fixture[0]->getEmail3());
        self::assertSame('Something New', $fixture[0]->getIm());
        self::assertSame('Something New', $fixture[0]->getIm2());
        self::assertSame('Something New', $fixture[0]->getIm3());
        self::assertSame('Something New', $fixture[0]->getHomepage());
        self::assertSame('Something New', $fixture[0]->getBday());
        self::assertSame('Something New', $fixture[0]->getBmonth());
        self::assertSame('Something New', $fixture[0]->getByear());
        self::assertSame('Something New', $fixture[0]->getAday());
        self::assertSame('Something New', $fixture[0]->getAmonth());
        self::assertSame('Something New', $fixture[0]->getAyear());
        self::assertSame('Something New', $fixture[0]->getAddress2());
        self::assertSame('Something New', $fixture[0]->getPhone2());
        self::assertSame('Something New', $fixture[0]->getNotes());
        self::assertSame('Something New', $fixture[0]->getPhoto());
        self::assertSame('Something New', $fixture[0]->getXVcard());
        self::assertSame('Something New', $fixture[0]->getXActivesync());
        self::assertSame('Something New', $fixture[0]->getCreated());
        self::assertSame('Something New', $fixture[0]->getModified());
        self::assertSame('Something New', $fixture[0]->getDeprecated());
        self::assertSame('Something New', $fixture[0]->getPassword());
        self::assertSame('Something New', $fixture[0]->getLogin());
        self::assertSame('Something New', $fixture[0]->getRole());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new AddressBook();
        $fixture->setDomainId('My Title');
        $fixture->setFirstname('My Title');
        $fixture->setMiddlename('My Title');
        $fixture->setLastname('My Title');
        $fixture->setNickname('My Title');
        $fixture->setCompany('My Title');
        $fixture->setTitle('My Title');
        $fixture->setAddress('My Title');
        $fixture->setAddrLong('My Title');
        $fixture->setAddrLat('My Title');
        $fixture->setAddrStatus('My Title');
        $fixture->setHome('My Title');
        $fixture->setMobile('My Title');
        $fixture->setWork('My Title');
        $fixture->setFax('My Title');
        $fixture->setEmail('My Title');
        $fixture->setEmail2('My Title');
        $fixture->setEmail3('My Title');
        $fixture->setIm('My Title');
        $fixture->setIm2('My Title');
        $fixture->setIm3('My Title');
        $fixture->setHomepage('My Title');
        $fixture->setBday('My Title');
        $fixture->setBmonth('My Title');
        $fixture->setByear('My Title');
        $fixture->setAday('My Title');
        $fixture->setAmonth('My Title');
        $fixture->setAyear('My Title');
        $fixture->setAddress2('My Title');
        $fixture->setPhone2('My Title');
        $fixture->setNotes('My Title');
        $fixture->setPhoto('My Title');
        $fixture->setXVcard('My Title');
        $fixture->setXActivesync('My Title');
        $fixture->setCreated('My Title');
        $fixture->setModified('My Title');
        $fixture->setDeprecated('My Title');
        $fixture->setPassword('My Title');
        $fixture->setLogin('My Title');
        $fixture->setRole('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/addressbook/');
    }
}

<?php

namespace AddressBook\Test\Controller;

use AddressBook\Entity\User;
use AddressBook\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private UserRepository $repository;
    private string $path = '/user/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(User::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('User index');

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
            'user[domainId]' => 'Testing',
            'user[username]' => 'Testing',
            'user[md5Pass]' => 'Testing',
            'user[passwordHint]' => 'Testing',
            'user[ssoFacebookUid]' => 'Testing',
            'user[ssoGoogleUid]' => 'Testing',
            'user[ssoLiveUid]' => 'Testing',
            'user[ssoYahooUid]' => 'Testing',
            'user[lastname]' => 'Testing',
            'user[firstname]' => 'Testing',
            'user[email]' => 'Testing',
            'user[phone]' => 'Testing',
            'user[address1]' => 'Testing',
            'user[address2]' => 'Testing',
            'user[city]' => 'Testing',
            'user[state]' => 'Testing',
            'user[zip]' => 'Testing',
            'user[country]' => 'Testing',
            'user[masterCode]' => 'Testing',
            'user[confirmationCode]' => 'Testing',
            'user[passResetCode]' => 'Testing',
            'user[status]' => 'Testing',
            'user[trials]' => 'Testing',
            'user[created]' => 'Testing',
            'user[modified]' => 'Testing',
            'user[deprecated]' => 'Testing',
        ]);

        self::assertResponseRedirects('/user/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new User();
        $fixture->setDomainId('My Title');
        $fixture->setUsername('My Title');
        $fixture->setMd5Pass('My Title');
        $fixture->setPasswordHint('My Title');
        $fixture->setSsoFacebookUid('My Title');
        $fixture->setSsoGoogleUid('My Title');
        $fixture->setSsoLiveUid('My Title');
        $fixture->setSsoYahooUid('My Title');
        $fixture->setLastname('My Title');
        $fixture->setFirstname('My Title');
        $fixture->setEmail('My Title');
        $fixture->setPhone('My Title');
        $fixture->setAddress1('My Title');
        $fixture->setAddress2('My Title');
        $fixture->setCity('My Title');
        $fixture->setState('My Title');
        $fixture->setZip('My Title');
        $fixture->setCountry('My Title');
        $fixture->setMasterCode('My Title');
        $fixture->setConfirmationCode('My Title');
        $fixture->setPassResetCode('My Title');
        $fixture->setStatus('My Title');
        $fixture->setTrials('My Title');
        $fixture->setCreated('My Title');
        $fixture->setModified('My Title');
        $fixture->setDeprecated('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('User');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new User();
        $fixture->setDomainId('My Title');
        $fixture->setUsername('My Title');
        $fixture->setMd5Pass('My Title');
        $fixture->setPasswordHint('My Title');
        $fixture->setSsoFacebookUid('My Title');
        $fixture->setSsoGoogleUid('My Title');
        $fixture->setSsoLiveUid('My Title');
        $fixture->setSsoYahooUid('My Title');
        $fixture->setLastname('My Title');
        $fixture->setFirstname('My Title');
        $fixture->setEmail('My Title');
        $fixture->setPhone('My Title');
        $fixture->setAddress1('My Title');
        $fixture->setAddress2('My Title');
        $fixture->setCity('My Title');
        $fixture->setState('My Title');
        $fixture->setZip('My Title');
        $fixture->setCountry('My Title');
        $fixture->setMasterCode('My Title');
        $fixture->setConfirmationCode('My Title');
        $fixture->setPassResetCode('My Title');
        $fixture->setStatus('My Title');
        $fixture->setTrials('My Title');
        $fixture->setCreated('My Title');
        $fixture->setModified('My Title');
        $fixture->setDeprecated('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'user[domainId]' => 'Something New',
            'user[username]' => 'Something New',
            'user[md5Pass]' => 'Something New',
            'user[passwordHint]' => 'Something New',
            'user[ssoFacebookUid]' => 'Something New',
            'user[ssoGoogleUid]' => 'Something New',
            'user[ssoLiveUid]' => 'Something New',
            'user[ssoYahooUid]' => 'Something New',
            'user[lastname]' => 'Something New',
            'user[firstname]' => 'Something New',
            'user[email]' => 'Something New',
            'user[phone]' => 'Something New',
            'user[address1]' => 'Something New',
            'user[address2]' => 'Something New',
            'user[city]' => 'Something New',
            'user[state]' => 'Something New',
            'user[zip]' => 'Something New',
            'user[country]' => 'Something New',
            'user[masterCode]' => 'Something New',
            'user[confirmationCode]' => 'Something New',
            'user[passResetCode]' => 'Something New',
            'user[status]' => 'Something New',
            'user[trials]' => 'Something New',
            'user[created]' => 'Something New',
            'user[modified]' => 'Something New',
            'user[deprecated]' => 'Something New',
        ]);

        self::assertResponseRedirects('/user/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getDomainId());
        self::assertSame('Something New', $fixture[0]->getUsername());
        self::assertSame('Something New', $fixture[0]->getMd5Pass());
        self::assertSame('Something New', $fixture[0]->getPasswordHint());
        self::assertSame('Something New', $fixture[0]->getSsoFacebookUid());
        self::assertSame('Something New', $fixture[0]->getSsoGoogleUid());
        self::assertSame('Something New', $fixture[0]->getSsoLiveUid());
        self::assertSame('Something New', $fixture[0]->getSsoYahooUid());
        self::assertSame('Something New', $fixture[0]->getLastname());
        self::assertSame('Something New', $fixture[0]->getFirstname());
        self::assertSame('Something New', $fixture[0]->getEmail());
        self::assertSame('Something New', $fixture[0]->getPhone());
        self::assertSame('Something New', $fixture[0]->getAddress1());
        self::assertSame('Something New', $fixture[0]->getAddress2());
        self::assertSame('Something New', $fixture[0]->getCity());
        self::assertSame('Something New', $fixture[0]->getState());
        self::assertSame('Something New', $fixture[0]->getZip());
        self::assertSame('Something New', $fixture[0]->getCountry());
        self::assertSame('Something New', $fixture[0]->getMasterCode());
        self::assertSame('Something New', $fixture[0]->getConfirmationCode());
        self::assertSame('Something New', $fixture[0]->getPassResetCode());
        self::assertSame('Something New', $fixture[0]->getStatus());
        self::assertSame('Something New', $fixture[0]->getTrials());
        self::assertSame('Something New', $fixture[0]->getCreated());
        self::assertSame('Something New', $fixture[0]->getModified());
        self::assertSame('Something New', $fixture[0]->getDeprecated());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new User();
        $fixture->setDomainId('My Title');
        $fixture->setUsername('My Title');
        $fixture->setMd5Pass('My Title');
        $fixture->setPasswordHint('My Title');
        $fixture->setSsoFacebookUid('My Title');
        $fixture->setSsoGoogleUid('My Title');
        $fixture->setSsoLiveUid('My Title');
        $fixture->setSsoYahooUid('My Title');
        $fixture->setLastname('My Title');
        $fixture->setFirstname('My Title');
        $fixture->setEmail('My Title');
        $fixture->setPhone('My Title');
        $fixture->setAddress1('My Title');
        $fixture->setAddress2('My Title');
        $fixture->setCity('My Title');
        $fixture->setState('My Title');
        $fixture->setZip('My Title');
        $fixture->setCountry('My Title');
        $fixture->setMasterCode('My Title');
        $fixture->setConfirmationCode('My Title');
        $fixture->setPassResetCode('My Title');
        $fixture->setStatus('My Title');
        $fixture->setTrials('My Title');
        $fixture->setCreated('My Title');
        $fixture->setModified('My Title');
        $fixture->setDeprecated('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/user/');
    }
}

<?php

namespace App\Test\Controller;

use App\Entity\Reponsereclamation;
use App\Repository\ReponsereclamationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ReponsereclamationControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private ReponsereclamationRepository $repository;
    private string $path = '/reponsereclamation/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Reponsereclamation::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Reponsereclamation index');

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
            'reponsereclamation[idu]' => 'Testing',
            'reponsereclamation[prenom]' => 'Testing',
            'reponsereclamation[intitule]' => 'Testing',
            'reponsereclamation[textreprec]' => 'Testing',
            'reponsereclamation[idrec]' => 'Testing',
        ]);

        self::assertResponseRedirects('/reponsereclamation/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Reponsereclamation();
        $fixture->setIdu('My Title');
        $fixture->setPrenom('My Title');
        $fixture->setIntitule('My Title');
        $fixture->setTextreprec('My Title');
        $fixture->setIdrec('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Reponsereclamation');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Reponsereclamation();
        $fixture->setIdu('My Title');
        $fixture->setPrenom('My Title');
        $fixture->setIntitule('My Title');
        $fixture->setTextreprec('My Title');
        $fixture->setIdrec('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'reponsereclamation[idu]' => 'Something New',
            'reponsereclamation[prenom]' => 'Something New',
            'reponsereclamation[intitule]' => 'Something New',
            'reponsereclamation[textreprec]' => 'Something New',
            'reponsereclamation[idrec]' => 'Something New',
        ]);

        self::assertResponseRedirects('/reponsereclamation/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getIdu());
        self::assertSame('Something New', $fixture[0]->getPrenom());
        self::assertSame('Something New', $fixture[0]->getIntitule());
        self::assertSame('Something New', $fixture[0]->getTextreprec());
        self::assertSame('Something New', $fixture[0]->getIdrec());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Reponsereclamation();
        $fixture->setIdu('My Title');
        $fixture->setPrenom('My Title');
        $fixture->setIntitule('My Title');
        $fixture->setTextreprec('My Title');
        $fixture->setIdrec('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/reponsereclamation/');
    }
}

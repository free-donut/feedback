<?php

namespace App\Tests\Controller;

use App\Entity\Appeal;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminControllerTest extends WebTestCase
{
    private $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function testIndexPage()
    {
        $crawler = $this->client->request('GET', '/admin/');

        $this->assertResponseIsSuccessful();
        $this->assertCount(1, $crawler->filter('h1'));
    }

    public function testEditPage()
    {
        $kernel = self::bootKernel();

        $entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $appeal = $entityManager->getRepository(Appeal::class)->findOneLatest();
        $url = sprintf('/admin/%d/edit', $appeal->getId());
        $crawler = $this->client->request('GET', $url);

        $this->assertResponseIsSuccessful();
        $this->assertCount(1, $crawler->filter('h1'));
    }
}

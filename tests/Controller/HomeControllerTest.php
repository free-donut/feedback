<?php

namespace App\Tests\Controller;

use App\Entity\Appeal;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    private $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function testHomePage(): void
    {
        $crawler = $this->client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'The ships hung in the sky in much the same way that bricks don\'t.');
    }

    public function testValidForm()
    {
        // get csrf token
        $crawler = $this->client->request('GET', '/');
        $token = $crawler->filter('input[name="appeal[_token]"]');
        $token = $token->attr('value');

        $formData = ['appeal' => [
                'customer' => 'Arthur Dent',
                'phone' => '+7(123)000-00-00',
                'status' => 1,
                '_token' => $token
            ]
        ];

        $crawler = $this->client->request('POST', '/', $formData);
        $this->assertResponseStatusCodeSame(302);

        $kernel = self::bootKernel();
        $entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $appeal = $entityManager->getRepository(Appeal::class)->findOneLatest();
        $this->assertEquals('Arthur Dent', $appeal->getCustomer());
        $this->assertEquals('+7(123)000-00-00', $appeal->getPhone());
        $this->assertEquals(1, $appeal->getStatus());
    }

    /**
     * @dataProvider invalidDataProvider
     */
    public function testInvalidForm($customer, $phone, $status)
    {
        // get csrf token
        $crawler = $this->client->request('GET', '/');
        $token = $crawler->filter('input[name="appeal[_token]"]');
        $token = $token->attr('value');

        $formData = ['appeal' => [
                'customer' => $customer,
                'phone' => $phone,
                'status' => $status,
                '_token' => $token
            ]
        ];

        $crawler = $this->client->request('POST', '/', $formData);
        $this->assertResponseIsUnprocessable();
    }

    public function invalidDataProvider()
    {
        return [
            [str_repeat("42", 130), '+7(123)000-00-00', 0],
            ['Arthur Dent', 'oops', 1],
            ['Arthur Dent', '+7(123)000-00-00', 3],
        ];
    }
}

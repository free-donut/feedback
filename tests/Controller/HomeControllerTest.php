<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    public function testHomePage(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Would it save you a lot of time if I just gave up and went mad now?');
    }

    public function testValidForm()
    {
        $client = static::createClient();
        // get csrf token
        $crawler = $client->request('GET', '/');
        $token = $crawler->filter('input[name="appeal[_token]"]');
        $token = $token->attr('value');

        $formData = ['appeal' => [
                'customer' => 'Dent',
                'phone' => '+7(123)000-00-00',
                'status' => 1,
                '_token' => $token
            ]
        ];

        $crawler = $client->request('POST', '/', $formData);
        $this->assertResponseStatusCodeSame(302);
    }

    /**
     * @dataProvider invalidDataProvider
     */
    public function testInvalidForm($customer, $phone, $status)
    {
        $client = static::createClient();
        // get csrf token
        $crawler = $client->request('GET', '/');
        $token = $crawler->filter('input[name="appeal[_token]"]');
        $token = $token->attr('value');

        $formData = ['appeal' => [
                'customer' => $customer,
                'phone' => $phone,
                'status' => $status,
                '_token' => $token
            ]
        ];

        $crawler = $client->request('POST', '/', $formData);
        $this->assertResponseIsUnprocessable();
    }

    public function invalidDataProvider()
    {
        return [
            ['Arthur Dent', '+7(123)000-00-00', 3],
            ['Dent', 'oops', 1],
            [str_repeat("42", 130), '+0(123)000-00-00', 0]
        ];
    }
}

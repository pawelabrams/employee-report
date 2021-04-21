<?php

declare(strict_types=1);

namespace Abramowicz\Tidio\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @covers \Abramowicz\Tidio\Ui\Controller\Get
 */
class GetTest extends WebTestCase
{
    public function test(): void
    {
        $client = static::createClient();

        $response = $client->request('GET', '/');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', date('m/Y'));
        $this->assertSelectorExists('table th');
        $this->assertSelectorExists('table td');
    }
}

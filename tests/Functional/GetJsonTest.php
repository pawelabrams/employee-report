<?php

declare(strict_types=1);

namespace Abramowicz\Tidio\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @covers \Abramowicz\Tidio\Ui\Controller\GetJson
 */
class GetJsonTest extends WebTestCase
{
    public function test(): void
    {
        $client = static::createClient();

        $client->request('GET', '/json');
        $this->assertResponseIsSuccessful();
    }
}

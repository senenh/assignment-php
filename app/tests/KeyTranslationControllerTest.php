<?php

namespace App\Tests;

use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use http\Client;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class KeyTranslationControllerTest extends WebTestCase
{
    use FixturesTrait;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var Client
     */
    protected $client;

    /**
     * If true, setup has run at least once.
     * @var boolean
     */
    protected static $setUpHasRunOnce = false;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->client = static::createClient();

        if (!static::$setUpHasRunOnce) {
            static::$setUpHasRunOnce = true;
            $this->em = $this->client->getContainer()->get('doctrine')->getManager();
            $purger = new ORMPurger($this->em);
            $purger->purge();

            $this->loadFixtures(array(
                'App\DataFixtures\UserFixtures',
                'App\DataFixtures\AppFixtures',
            ));
        }
    }

    public function testKeyCreateSuccess(): void
    {
        $this->client->request(
            'POST',
            '/api/key',
            array(),
            array(),
            array(
                'CONTENT_TYPE' => 'application/json',
                'HTTP_Authorization' => 'Bearer a9ed058b68e3a63d4d557a23692ed2fe9f928fc3e407f195dfb73a1cb1764ec6aedff5c4ae45620d6213f3b363d18caf2489eb5484b3c024aef0817e'
            ),
            '{"name": "hello.world"}'
        );

        self::assertResponseIsSuccessful();
    }

    /**
     * @depends testKeyCreateSuccess
     */
    public function testUpdateTranslationAssertionsViolated(): void
    {
        $this->client->request(
            'PUT',
            '/api/key-translation',
            array(),
            array(),
            array(
                'CONTENT_TYPE' => 'application/json',
                'HTTP_Authorization' => 'Bearer a9ed058b68e3a63d4d557a23692ed2fe9f928fc3e407f195dfb73a1cb1764ec6aedff5c4ae45620d6213f3b363d18caf2489eb5484b3c024aef0817e'
            ),
            '{}'
        );

        self::assertResponseStatusCodeSame(400);

        $response = json_decode($this->client->getResponse()->getContent(), true);
        self::assertEquals(6, count($response['violations']));
    }

    /**
     * @depends testKeyCreateSuccess
     */
    public function testUpdateTranslationSuccess(): void
    {
        $this->client->request(
            'PUT',
            '/api/key-translation',
            array(),
            array(),
            array(
                'CONTENT_TYPE' => 'application/json',
                'HTTP_Authorization' => 'Bearer a9ed058b68e3a63d4d557a23692ed2fe9f928fc3e407f195dfb73a1cb1764ec6aedff5c4ae45620d6213f3b363d18caf2489eb5484b3c024aef0817e'
            ),
            '{
                "key": "hello.world",
                "iso": "eng",
                "text": "Hello world!"
            }'
        );

        self::assertResponseIsSuccessful();
    }

    /**
     * @depends testUpdateTranslationSuccess
     */
    public function testGetKeyTranslated(): void
    {
        $this->client->request(
            'GET',
            '/api/key/1',
            array(),
            array(),
            array(
                'CONTENT_TYPE' => 'application/json',
                'HTTP_Authorization' => 'Bearer a9ed058b68e3a63d4d557a23692ed2fe9f928fc3e407f195dfb73a1cb1764ec6aedff5c4ae45620d6213f3b363d18caf2489eb5484b3c024aef0817e'
            )
        );

        self::assertResponseIsSuccessful();
        self::assertEquals('{"id":1,"name":"hello.world","translations":[{"text":"Hello world!","language":{"ISO":"eng"}},{"text":"","language":{"ISO":"spa"}},{"text":"","language":{"ISO":"por"}},{"text":"","language":{"ISO":"fra"}}]}', $this->client->getResponse()->getContent());
    }
}

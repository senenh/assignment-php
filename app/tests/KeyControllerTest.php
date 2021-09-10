<?php

namespace App\Tests;

use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use http\Client;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class KeyControllerTest extends WebTestCase
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
//    protected static $client;

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

    public function testKeyListSuccess(): void
    {
        $this->client->request(
            'GET',
            '/api/keys',
            array(),
            array(),
            array(
                'HTTP_Authorization' => 'Bearer d96e7c6c7331bc282799681efd11e9fcbb0a781f0633834ae250cfb0c72c392af847bba77f6554ad408ab8f5032de43c137e7482f70dbc7a9d72310f'
            )
        );

        self::assertResponseIsSuccessful();
    }

    public function testKeyCreateNotAdmin(): void
    {
        $this->client->request(
            'POST',
            '/api/key',
            array(),
            array(),
            array(
                'CONTENT_TYPE' => 'application/json',
                'HTTP_Authorization' => 'Bearer d96e7c6c7331bc282799681efd11e9fcbb0a781f0633834ae250cfb0c72c392af847bba77f6554ad408ab8f5032de43c137e7482f70dbc7a9d72310f'
            ),
            '{"name": "body.header"}'
        );

        self::assertResponseStatusCodeSame(403);
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
            '{"name": "body.header"}'
        );

        self::assertResponseIsSuccessful();
    }

    /**
     * @depends testKeyCreateSuccess
     */
    public function testKeyGetList(): void
    {
        $this->client->request(
            'GET',
            '/api/keys',
            array(),
            array(),
            array(
                'CONTENT_TYPE' => 'application/json',
                'HTTP_Authorization' => 'Bearer a9ed058b68e3a63d4d557a23692ed2fe9f928fc3e407f195dfb73a1cb1764ec6aedff5c4ae45620d6213f3b363d18caf2489eb5484b3c024aef0817e'
            )
        );

        self::assertResponseIsSuccessful();
        self::assertEquals('[{"id":1,"name":"body.header","translations":[{"text":"","language":{"ISO":"eng"}},{"text":"","language":{"ISO":"spa"}},{"text":"","language":{"ISO":"por"}},{"text":"","language":{"ISO":"fra"}}]}]', $this->client->getResponse()->getContent());
    }

    /**
     * @depends testKeyCreateSuccess
     */
    public function testGetKey(): void
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
        self::assertEquals('{"id":1,"name":"body.header","translations":[{"text":"","language":{"ISO":"eng"}},{"text":"","language":{"ISO":"spa"}},{"text":"","language":{"ISO":"por"}},{"text":"","language":{"ISO":"fra"}}]}', $this->client->getResponse()->getContent());
    }

    /**
     * @depends testKeyCreateSuccess
     */
    public function testGetKeyFail(): void
    {
        $this->client->request(
            'GET',
            '/api/key/2',
            array(),
            array(),
            array(
                'CONTENT_TYPE' => 'application/json',
                'HTTP_Authorization' => 'Bearer a9ed058b68e3a63d4d557a23692ed2fe9f928fc3e407f195dfb73a1cb1764ec6aedff5c4ae45620d6213f3b363d18caf2489eb5484b3c024aef0817e'
            )
        );

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @depends testKeyCreateSuccess
     */
    public function testUpdateNameKey(): void
    {
        $this->client->request(
            'PATCH',
            '/api/key/1',
            array(),
            array(),
            array(
                'CONTENT_TYPE' => 'application/json',
                'HTTP_Authorization' => 'Bearer a9ed058b68e3a63d4d557a23692ed2fe9f928fc3e407f195dfb73a1cb1764ec6aedff5c4ae45620d6213f3b363d18caf2489eb5484b3c024aef0817e'
            ),
            '{"name": "main.header"}'
        );

        self::assertResponseIsSuccessful();
    }

    /**
     * @depends testKeyCreateSuccess
     */
    public function testKeyDeleteSuccess(): void
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
            '{"name": "body.header"}'
        );

        $this->client->request(
            'DELETE',
            '/api/key/2',
            array(),
            array(),
            array(
                'CONTENT_TYPE' => 'application/json',
                'HTTP_Authorization' => 'Bearer a9ed058b68e3a63d4d557a23692ed2fe9f928fc3e407f195dfb73a1cb1764ec6aedff5c4ae45620d6213f3b363d18caf2489eb5484b3c024aef0817e'
            ),
            '{"name": "body.header"}'
        );
        self::assertResponseIsSuccessful();

        $this->client->request(
            'GET',
            '/api/keys',
            array(),
            array(),
            array(
                'CONTENT_TYPE' => 'application/json',
                'HTTP_Authorization' => 'Bearer a9ed058b68e3a63d4d557a23692ed2fe9f928fc3e407f195dfb73a1cb1764ec6aedff5c4ae45620d6213f3b363d18caf2489eb5484b3c024aef0817e'
            )
        );

        self::assertEquals(1, count(json_decode($this->client->getResponse()->getContent(), true)));
    }
}

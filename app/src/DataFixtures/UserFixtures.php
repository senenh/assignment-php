<?php

namespace App\DataFixtures;

use App\Entity\ApiToken;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $writer = new User();
        $writer->setUsername('writer');
        $writer->setRoles(['ROLE_ADMIN', 'ROLE_USER']);
        $manager->persist($writer);

        $reader = new User();
        $reader->setUsername('reader');
        $manager->persist($reader);

        $apiTokenReader = new ApiToken($reader);
        $apiTokenReader->setToken('d96e7c6c7331bc282799681efd11e9fcbb0a781f0633834ae250cfb0c72c392af847bba77f6554ad408ab8f5032de43c137e7482f70dbc7a9d72310f');
        $manager->persist($apiTokenReader);

        $apiTokenWriter = new ApiToken($writer);
        $apiTokenWriter->setToken('a9ed058b68e3a63d4d557a23692ed2fe9f928fc3e407f195dfb73a1cb1764ec6aedff5c4ae45620d6213f3b363d18caf2489eb5484b3c024aef0817e');
        $manager->persist($apiTokenWriter);

        $manager->flush();
    }
}

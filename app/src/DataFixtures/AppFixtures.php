<?php

namespace App\DataFixtures;

use App\Entity\Language;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $english = new Language();
        $english->setName('English');
        $english->setISO('eng');
        $english->setLTR(true);
        $manager->persist($english);

        $spanish = new Language();
        $spanish->setName('Spanish');
        $spanish->setISO('spa');
        $spanish->setLTR(true);
        $manager->persist($spanish);

        $portuguese = new Language();
        $portuguese->setName('Portuguese');
        $portuguese->setISO('por');
        $portuguese->setLTR(true);
        $manager->persist($portuguese);

        $french = new Language();
        $french->setName('French');
        $french->setISO('fra');
        $french->setLTR(true);
        $manager->persist($french);

        $manager->flush();
    }
}

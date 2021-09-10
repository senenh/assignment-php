<?php

namespace App\Manager;

use App\Entity\KeyLanguageTranslation;
use App\Entity\Language;
use App\Entity\Translation;
use App\Service\Export\CompressZip;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;

class KeyManager
{
    private EntityManagerInterface $entityManager;

    public function __construct(CompressZip $compressZip, EntityManagerInterface $entityManager, Filesystem $filesystem)
    {
        $this->entityManager = $entityManager;
    }

    public function createKey($key)
    {
        $languages = $this->entityManager->getRepository(Language::class)->findAll();

        foreach ($languages as $language) {
            $translation = new Translation();
            $translation->setText('');
            $translation->setKeyId($key);
            $translation->setLanguage($language);
            $this->entityManager->persist($translation);
            $keyLanguageTranslation = new KeyLanguageTranslation();
            $keyLanguageTranslation->setTranslation($translation);
            $keyLanguageTranslation->setLanguage($language);
            $keyLanguageTranslation->setKeyId($key);
            $this->entityManager->persist($keyLanguageTranslation);
        }

        $this->entityManager->persist($key);
        $this->entityManager->flush();

        return $key;
    }
}

<?php

namespace App\Service\Export;

use App\Entity\Language;
use App\Entity\Translation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class ExportJson implements Export
{
    private CompressZip $compressZip;
    private EntityManagerInterface $manager;
    private Filesystem $filesystem;

    public function __construct(CompressZip $compressZip, EntityManagerInterface $manager,Filesystem $filesystem)
    {
        $this->compressZip = $compressZip;
        $this->manager = $manager;
        $this->filesystem = $filesystem;
    }

    public function export($userIdentifier): string
    {
        $userId = hash('ripemd160', $userIdentifier);

        $files = $this->generateFiles($userIdentifier);

        $zipName = 'json-export-'.time().".zip";
        return $this->compressZip->compress($files, $zipName, $userId, Export::JSON);
    }

    private function generateFiles($userIdentifier)
    {
        $userId = hash('ripemd160', $userIdentifier);

        $pathUser = '/tmp/export/json/'.$userId.'/';
        $languages = $this->manager->getRepository(Language::class)->findAll();
        $jsonFileArray = [];

        /** @var Language $language */
        foreach ($languages as $language) {
            $translations = $this->manager->getRepository(Translation::class)->findBy(['language' => $language->getId()]);
            /** @var Translation $translation */
            foreach ($translations as $translation) {
                $keyName = $translation->getKeyId()->getName();
                $text = $translation->getText();
                $jsonFileArray[$keyName] = $text;
            }
            $this->filesystem->mkdir($pathUser.'zip/', 0700);
            $this->filesystem->dumpFile($pathUser.$language->getISO().'.json', json_encode($jsonFileArray, JSON_PRETTY_PRINT));
        }

        $finder = new Finder();
        $finder->files()->in($pathUser);
        $files = [];
        if ($finder->hasResults()) {
            foreach ($finder as $file) {
                if ($file->getExtension() === 'json') {
                    $files[] = $file;
                }
            }
        }

        return $files;
    }
}
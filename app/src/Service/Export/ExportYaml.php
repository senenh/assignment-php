<?php

namespace App\Service\Export;

use App\Entity\Language;
use App\Entity\Translation;
use Doctrine\ORM\EntityManagerInterface;
use SplFileInfo;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;

class ExportYaml implements Export
{
    private CompressZip $compressZip;
    private EntityManagerInterface $manager;
    private Filesystem $filesystem;

    public function __construct(CompressZip $compressZip, EntityManagerInterface $manager, Filesystem $filesystem)
    {
        $this->compressZip = $compressZip;
        $this->manager = $manager;
        $this->filesystem = $filesystem;
    }

    public function export($userIdentifier): string
    {
        $userId = hash('ripemd160', $userIdentifier);

        $files = $this->generateFile($userIdentifier);

        $zipName = 'yaml-export-'.time().".zip";
        return $this->compressZip->compress($files, $zipName, $userId, Export::YAML);
    }

    private function generateFile($userIdentifier)
    {
        $userId = hash('ripemd160', $userIdentifier);

        $pathUser = '/tmp/export/'.Export::YAML.'/'.$userId.'/';
        $languages = $this->manager->getRepository(Language::class)->findAll();
        $yamlFileArray = [];

        /** @var Language $language */
        foreach ($languages as $language) {
            $translations = $this->manager->getRepository(Translation::class)->findBy(['language' => $language->getId()]);
            /** @var Translation $translation */
            foreach ($translations as $translation) {
                $keyName = $translation->getKeyId()->getName();
                $text = $translation->getText();
                $yamlFileArray[$language->getISO()][$keyName] = $text;
            }
        }

        $yaml = Yaml::dump($yamlFileArray);
        $this->filesystem->mkdir($pathUser.'zip/', 0700);
        $this->filesystem->dumpFile($pathUser.'translations.yaml', $yaml);
        $file = new SplFileInfo($pathUser.'translations.yaml');

        return [$file];
    }
}
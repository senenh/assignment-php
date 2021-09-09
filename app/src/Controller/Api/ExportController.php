<?php

namespace App\Controller\Api;

use App\Service\Export\ExportJson;
use App\Service\Export\ExportYaml;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class ExportController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(path="/export/json")
     */
    public function exportJson(ExportJson $exportJson)
    {
        $userId = $this->getUser()->getUserIdentifier();

        $absoluteFilePathZip = $exportJson->export($userId);

        return $this->file($absoluteFilePathZip, 'export-json.zip', ResponseHeaderBag::DISPOSITION_INLINE);
    }

    /**
     * @Rest\Get(path="/export/yaml")
     */
    public function exportYaml(ExportYaml $exportJson)
    {
        $userId = $this->getUser()->getUserIdentifier();

        $absoluteFilePathZip = $exportJson->export($userId);

        return $this->file($absoluteFilePathZip, 'export-yaml.zip', ResponseHeaderBag::DISPOSITION_INLINE);
    }
}
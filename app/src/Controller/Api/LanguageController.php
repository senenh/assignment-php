<?php

namespace App\Controller\Api;


use App\Repository\LanguageRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Serializer\SerializerInterface;


class LanguageController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(path="/languages")
     * @Rest\View(serializerGroups={"language"}, serializerEnableMaxDepthChecks=true)
     */
    public function index(LanguageRepository $languageRepository)
    {
        return $languageRepository->findAll();
    }
}
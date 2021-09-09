<?php

namespace App\Controller\Api;

use App\Entity\Key;
use App\Manager\KeyManager;
use App\Repository\KeyRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class KeyController extends AbstractFOSRestController
{
    /**
     * @Rest\Post(path="/key")
     * @Rest\View(serializerGroups={"key", "key-translation"}, serializerEnableMaxDepthChecks=true)
     * @ParamConverter("key", class="App\Entity\Key", converter="fos_rest.request_body")
     * @IsGranted("ROLE_ADMIN")
     */
    public function create(Key $key, ConstraintViolationListInterface $validationErrors, KeyManager $keyManager)
    {
        if (\count($validationErrors) > 0) {
            return View::create($validationErrors, Response::HTTP_BAD_REQUEST);
        }

        return $keyManager->createKey($key);
    }

    /**
     * @Rest\Get(path="/keys")
     * @Rest\View(serializerGroups={"key", "key-translation"}, serializerEnableMaxDepthChecks=true)
     */
    public function list(KeyRepository $keyRepository)
    {
        return $keyRepository->findAll();
    }

    /**
     * @Rest\Get(path="/key/{id}")
     * @Rest\View(serializerGroups={"key", "key-translation"}, serializerEnableMaxDepthChecks=true)
     * @ParamConverter("key", class="App\Entity\Key")
     */
    public function retrieve(Key $key)
    {
        return $key;
    }

    /**
     * @Rest\Patch(path="/key/{id}")
     * @Rest\View(serializerGroups={"key", "key-translation"}, serializerEnableMaxDepthChecks=true)
     * @ParamConverter("key", class="App\Entity\Key")
     * @ParamConverter("keyNew", class="App\Entity\Key", converter="fos_rest.request_body")
     * @IsGranted("ROLE_ADMIN")
     */
    public function rename(Key $key, Key $keyNew, ConstraintViolationListInterface $validationErrors, EntityManagerInterface $entityManager)
    {
        if (\count($validationErrors) > 0) {
            return View::create($validationErrors, Response::HTTP_BAD_REQUEST);
        }

        $key->setName($keyNew->getName());
        $entityManager->persist($key);
        $entityManager->flush();

        return $key;
    }

    /**
     * @Rest\Delete(path="/key/{id}")
     * @ParamConverter("key", class="App\Entity\Key")
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Key $key, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($key);
        $entityManager->flush();

        return View::create([], Response::HTTP_NO_CONTENT);
    }
}
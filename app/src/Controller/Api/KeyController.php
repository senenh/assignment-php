<?php

namespace App\Controller\Api;

use App\Entity\Key;
use App\Entity\KeyLanguageTranslation;
use App\Entity\Language;
use App\Entity\Translation;
use App\Helper\ValidateHelper;
use App\Repository\KeyRepository;
use CreateKeyRequestPayload;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class KeyController extends AbstractFOSRestController
{
    use ValidateHelper;

    /**
     * @Rest\Post(path="/key")
     * @Rest\View(serializerGroups={"key", "key-translation"}, serializerEnableMaxDepthChecks=true)
     */
    public function create(Request $request, SerializerInterface $serializer, ValidatorInterface $validator, EntityManagerInterface $entityManager)
    {
        [$violations] = $this->validate($request->getContent(),CreateKeyRequestPayload::class, $serializer, $validator);

        if (count($violations) > 0) {
            return $this->returnErrors($violations);
        }

        [$violations, $key] = $this->validate($request->getContent(),Key::class, $serializer, $validator);

        if (count($violations) > 0) {
            return $this->returnErrors($violations);
        }

        $languages = $this->getDoctrine()->getRepository(Language::class)->findAll();

        foreach ($languages as $language) {
            $translation = new Translation();
            $translation->setText('');
            $translation->setKeyId($key);
            $translation->setLanguage($language);
            $entityManager->persist($translation);
            $keyLanguageTranslation = new KeyLanguageTranslation();
            $keyLanguageTranslation->setTranslation($translation);
            $keyLanguageTranslation->setLanguage($language);
            $keyLanguageTranslation->setKeyId($key);
            $entityManager->persist($keyLanguageTranslation);
        }

        $entityManager->persist($key);
        $entityManager->flush();

        return $key;
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
     * @ParamConverter("key", class="App\Entity\Key")
     * @Rest\View(serializerGroups={"key", "key-translation"}, serializerEnableMaxDepthChecks=true)
     */
    public function retrieve(Key $key)
    {
        return $key;
    }

    /**
     * @Rest\Patch(path="/key/{id}")
     * @ParamConverter("key", class="App\Entity\Key")
     * @Rest\View(serializerGroups={"key", "key-translation"}, serializerEnableMaxDepthChecks=true)
     */
    public function rename(Key $key, Request $request, SerializerInterface $serializer, ValidatorInterface $validator, EntityManagerInterface $entityManager)
    {
        [$violations] = $this->validate($request->getContent(),CreateKeyRequestPayload::class, $serializer, $validator);

        if (count($violations) > 0) {
            return $this->returnErrors($violations);
        }

        [$violations, $keyJson] = $this->validate($request->getContent(),Key::class, $serializer, $validator);

        if (count($violations) > 0) {
            return $this->returnErrors($violations);
        }

        $key->setName($keyJson->getName());
        $entityManager->persist($key);
        $entityManager->flush();

        return $key;
    }

    /**
     * @Rest\Delete(path="/key/{id}")
     * @ParamConverter("key", class="App\Entity\Key")
     */
    public function delete(Key $key, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($key);
        $entityManager->flush();

        return new JsonResponse(['status' => 'ok'], 200);
    }


}
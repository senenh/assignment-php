<?php

namespace App\Controller\Api;

use App\Entity\Key;
use App\Entity\Language;
use App\Entity\Translation;
use App\Helper\ValidateHelper;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class KeyTranslationController extends AbstractFOSRestController
{
    use ValidateHelper;

    /**
     * @Rest\Put(path="/key-translation")
     * @Rest\View(serializerGroups={"translation"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function update(Request $request, SerializerInterface $serializer, ValidatorInterface $validator, EntityManagerInterface $entityManager)
    {
        $keyTranslation = json_decode($request->getContent(), true);

        /** @var Key $key */
        $key = $this->getDoctrine()->getRepository(Key::class)->findOneBy(['name'=>$keyTranslation['key']]);
        $language = $this->getDoctrine()->getRepository(Language::class)->findOneBy(['ISO'=>$keyTranslation['iso']]);

        if ($key==null) {
            return new JsonResponse(["message" => "key not found"], 400);
        }

        if ($language==null) {
            return new JsonResponse(["message" => "language not found"], 400);
        }

        /** @var Translation $translation */
        $translation = $this->getDoctrine()->getRepository(Translation::class)->findOneBy(['keyId'=>$key->getId(), 'language'=>$language->getId()]);
        $translation->setText($keyTranslation['text']);
        $entityManager->persist($translation);
        $entityManager->flush();

        return $translation;

    }
}
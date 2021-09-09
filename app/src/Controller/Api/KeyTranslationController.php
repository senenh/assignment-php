<?php

namespace App\Controller\Api;

use App\DTO\KeyLanguageTranslationDTO;
use App\Entity\Key;
use App\Entity\Language;
use App\Entity\Translation;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class KeyTranslationController extends AbstractFOSRestController
{
    /**
     * @Rest\Put(path="/key-translation")
     * @Rest\View(serializerGroups={"translation"})
     * @ParamConverter("keyLanguageTranslation", class="App\DTO\KeyLanguageTranslationDTO", converter="fos_rest.request_body")
     * @IsGranted("ROLE_ADMIN")
     */
    public function update(Request $request, KeyLanguageTranslationDTO $keyLanguageTranslation, ConstraintViolationListInterface $validationErrors, SerializerInterface $serializer, ValidatorInterface $validator, EntityManagerInterface $entityManager)
    {
        if (\count($validationErrors) > 0) {
            return View::create($validationErrors, Response::HTTP_BAD_REQUEST);
        }

        /** @var Key $key */
        $key = $this->getDoctrine()->getRepository(Key::class)->findOneBy(['name'=>$keyLanguageTranslation->getKey()]);
        if (!$key) {
            throw new EntityNotFoundException('Key with name '.$keyLanguageTranslation->getKey().' does not exist!');
        }

        /** @var Language $language */
        $language = $this->getDoctrine()->getRepository(Language::class)->findOneBy(['ISO'=>$keyLanguageTranslation->getIso()]);
        if (!$language) {
            throw new EntityNotFoundException('Language with iso '.$keyLanguageTranslation->getIso().' does not exist!');
        }

        /** @var Translation $translation */
        $translation = $this->getDoctrine()->getRepository(Translation::class)->findOneBy(['keyId'=>$key->getId(), 'language'=>$language->getId()]);
        $translation->setText($keyLanguageTranslation->getText());
        $entityManager->persist($translation);
        $entityManager->flush();

        return $translation;
    }
}
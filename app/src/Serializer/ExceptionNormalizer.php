<?php

namespace App\Serializer;

use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ExceptionNormalizer implements NormalizerInterface
{
    public function normalize($object, $format = null, array $context = array())
    {
        return ["code" => 404, "message" => "Element not found"];
    }

    public function supportsNormalization($data, $format = null)
    {
        if ( $data instanceof FlattenException ) {
            /** @var FlattenException $data */
            return  $data->getClass() == NotFoundHttpException::class;
        }

        return false;
    }
}
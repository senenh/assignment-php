<?php

namespace App\Helper;

use Doctrine\Inflector\Inflector;
use Symfony\Component\HttpFoundation\JsonResponse;

trait ValidateHelper
{
    public function returnErrors($violations) {
        $errors = [];
        foreach ($violations as $violation) {
            $errors[Inflector::tableize($violation->getPropertyPath())][] = $violation->getMessage();
        }
        return new JsonResponse($errors, 400);
    }

    public function validate($content, $class, $serializer, $validator) {
        $requestPayload = $serializer->deserialize(
            $content,
            $class,
            'json',
        );

        return [$validator->validate($requestPayload), $requestPayload];
    }
}
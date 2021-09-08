<?php

namespace App\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/key")
 */
class KeyController extends AbstractController
{
    /**
     * @Route("", methods={"GET"})
    */
     public function index(EntityManager $manager): Response
    {
        return $manager->getRepository()->findAll();

    }
}
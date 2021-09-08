<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
    * @Route("/hola")
    */
     public function index(): Response
    {
        return new Response(
            '<html><body>Lucky number: asdf</body></html>'
        );
    }
}
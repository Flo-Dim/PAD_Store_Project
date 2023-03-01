<?php

namespace App\Controller\Gest;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GestValidtionController extends AbstractController
{
    #[Route('/gest', name: 'app_gest_validtion')]
    public function index(): Response
    {
        return $this->render('gest_validtion/index.html.twig', [
            'controller_name' => 'GestValidtionController',
        ]);
    }
}

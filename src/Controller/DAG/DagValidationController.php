<?php

namespace App\Controller\DAG;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DagValidationController extends AbstractController
{
    #[Route('/dag', name: 'app_dag_validation')]
    public function index(): Response
    {
        return $this->render('dag_validation/index.html.twig', [
            'controller_name' => 'DagValidationController',
        ]);
    }
}

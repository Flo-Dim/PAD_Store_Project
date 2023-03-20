<?php

namespace App\Controller\DAG;

use App\Entity\Command;
use App\Repository\CommandRepository;
use App\Repository\LeftBudgetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class DagValidationController extends AbstractController
{
    #[Route('/dag/confirm', name: 'app_dag_validation')]
    public function index(): Response
    {
        return $this->render('dag_validation/index.html.twig', [
            'controller_name' => 'DagValidationController',
        ]);
    }

    #[Route('/dag', name: 'app_dag_view_command')]
    public function homeCommand(CommandRepository $ComRep): Response
    {
        
        return $this->render('dag_validation/index.html.twig', [
            'commands' => $ComRep->findAll()
        ]);
    }
    
    

   

}

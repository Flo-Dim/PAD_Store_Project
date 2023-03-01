<?php

namespace App\Controller\Admin;

use App\Entity\Budget;
use App\Entity\LeftBudget;
use App\Entity\Category;
use App\Form\BudgetFormType;
use App\Repository\LeftBudgetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminBudgetController extends AbstractController
{
    #[Route('/admin/budget', name: 'app_admin_budget')]
    public function index(LeftBudgetRepository $BudgRep): Response
    {
        return $this->render('admin_budget/home.html.twig', [
            'budgets' => $BudgRep->findAll()
        ]);
    }

    #[Route('/admin/budget/add', name: 'app_admin_budget_add')]
    public function addBudget(Request $request, EntityManagerInterface $entityManager){

        $budget = new LeftBudget();

        $form = $this->createForm(BudgetFormType::class, $budget);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //$entityManager= $this->getDoctrine()->getManager();
            $entityManager->persist($budget);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_budget');
        }

        return $this->render('admin_budget/index.html.twig', [
            'BudgetForm' => $form->createView(),
        ]);

    }

    #[Route('/admin/budget/modify/{id}', name: 'app_admin_budget_modify')]
    public function ModifyBudget(LeftBudget $budget ,Request $request, EntityManagerInterface $entityManager){


        $form = $this->createForm(BudgetFormType::class, $budget);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //$entityManager= $this->getDoctrine()->getManager();
            $entityManager->persist($budget);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_budget');
        }

        return $this->render('admin_budget/index.html.twig', [
            'BudgetForm' => $form->createView(),
        ]);

    }

    #[Route('/admin/budget/delete/{id}', name: 'app_admin_budget_delete')]
    public function DeleteBudget(ManagerRegistry $doctrine, int $id, EntityManagerInterface $entityManager){

        $entityManager = $doctrine->getManager();
        $budget = $entityManager->getRepository(LeftBudget::class)->find($id);
        $entityManager->remove($budget);
        $entityManager->flush();

        return $this->redirectToRoute('app_admin_budget');
        
    }

}

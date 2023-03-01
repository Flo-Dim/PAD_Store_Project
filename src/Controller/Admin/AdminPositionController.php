<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Position;
use App\Form\PositionFormType;
use App\Repository\PositionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Framework\Test;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPositionController extends AbstractController
{
    #[Route('/admin/position', name: 'app_admin_position')]
    public function index(PositionRepository $PosRep): Response
    {   

        return $this->render('admin_position/home.html.twig', [
            'positions' => $PosRep->findAll()
        ]);
    }

    #[Route('/admin/position/add', name: 'app_admin_position_add')]
    public function addPosition(Request $request, EntityManagerInterface $entityManager){

        $position = new Position();

        $form = $this->createForm(PositionFormType::class, $position);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //$entityManager= $this->getDoctrine()->getManager();
            $entityManager->persist($position);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_position');
        }

        return $this->render('admin_position/index.html.twig', [
            'PositionForm' => $form->createView(),
        ]);

    }

    #[Route('/admin/position/modify/{id}', name: 'app_admin_position_modify')]
    public function ModifyPosition(Position $position ,Request $request, EntityManagerInterface $entityManager){


        $form = $this->createForm(PositionFormType::class, $position);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            
            $entityManager->persist($position);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_position');
        }

        return $this->render('admin_position/index.html.twig', [
            'PositionForm' => $form->createView(),
        ]);

    }

    #[Route('/admin/position/delete/{id}', name: 'app_admin_position_delete')]
    public function DeletePosition(ManagerRegistry $doctrine, int $id, EntityManagerInterface $entityManager){

        $entityManager = $doctrine->getManager();
        $position = $entityManager->getRepository(Position::class)->find($id);
        $entityManager->remove($position);
        $entityManager->flush();

        return $this->redirectToRoute('app_admin_position');
        
    }

    


}

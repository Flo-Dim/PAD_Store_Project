<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryFormType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategoryController extends AbstractController
{
    #[Route('/admin/category', name: 'app_admin_category')]
    public function index(CategoryRepository $CatRep): Response
    {
        return $this->render('admin_category/home.html.twig', [
            'categories' => $CatRep->findAll()
        ]);
    }

    #[Route('/admin/category/add', name: 'app_admin_category_add')]
    public function addCategory(Request $request, EntityManagerInterface $entityManager){

        $category = new Category();

        $form = $this->createForm(CategoryFormType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //$entityManager= $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_category');
        }

        return $this->render('admin_category/index.html.twig', [
            'CategoryForm' => $form->createView(),
        ]);

    }

    #[Route('/admin/category/modify/{id}', name: 'app_admin_category_modify')]
    public function ModifyCategory(Category $category ,Request $request, EntityManagerInterface $entityManager){


        $form = $this->createForm(CategoryFormType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //$entityManager= $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_category');
        }

        return $this->render('admin_category/index.html.twig', [
            'CategoryForm' => $form->createView(),
        ]);

    }

    #[Route('/admin/category/delete/{id}', name: 'app_admin_category_delete')]
    public function DeleteCategory(ManagerRegistry $doctrine, int $id, EntityManagerInterface $entityManager){

        $entityManager = $doctrine->getManager();
        $category = $entityManager->getRepository(Category::class)->find($id);
        $entityManager->remove($category);
        $entityManager->flush();

        return $this->redirectToRoute('app_admin_position');
        
    }



}

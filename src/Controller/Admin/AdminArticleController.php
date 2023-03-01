<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Form\ArticleFormType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminArticleController extends AbstractController
{
    #[Route('/admin', name: 'app_admin_article')]
    public function index(ArticleRepository $ArtRep): Response
    {
        return $this->render('admin_article/home.html.twig', [
            'articles' => $ArtRep->findAll()
        ]);
    }

    #[Route('/admin/article/add', name: 'app_admin_article_add')]
    public function addArticle(Request $request, EntityManagerInterface $entityManager){

        $article = new Article();

        $form = $this->createForm(ArticleFormType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //$entityManager= $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_article');
        }

        return $this->render('admin_article/index.html.twig', [
            'ArticleForm' => $form->createView(),
        ]);

    }

    #[Route('/admin/position/article/{id}', name: 'app_admin_article_modify')]
    public function ModifyArticle(Article $article ,Request $request, EntityManagerInterface $entityManager){


        $form = $this->createForm(ArticleFormType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //$entityManager= $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_article');
        }

        return $this->render('admin_article/index.html.twig', [
            'ArticleForm' => $form->createView(),
        ]);

    }

    #[Route('/admin/article/delete/{id}', name: 'app_admin_article_delete')]
    public function DeleteCategory(ManagerRegistry $doctrine, int $id, EntityManagerInterface $entityManager){

        $entityManager = $doctrine->getManager();
        $article = $entityManager->getRepository(Article::class)->find($id);
        $entityManager->remove($article);
        $entityManager->flush();

        return $this->redirectToRoute('app_admin_article');
        
    }

}

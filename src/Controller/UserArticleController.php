<?php

namespace App\Controller;

use App\Entity\SearchData;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserArticleController extends AbstractController
{
    #[Route(path:'/article', name: 'app_user_article')]
    public function index(ArticleRepository $ArtRep): Response
    {
        return $this->render('user_article/home.html.twig', [
            'articles' => $ArtRep->findAll()
        ]);
    }

    #[Route(path:'/article/search', name: 'app_user_article_search')]
    public function search(ArticleRepository $ArtRep, Request $request): Response
    {   
        // Here we Perfom a search on the article search bar
        $searchData=new SearchData;
        $form = $this->createForm(SearchType::class,$searchData);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){


        }
        return $this->render('user_article/home.html.twig', ['form'=>$form->createView(),
            'articles' => $ArtRep->find($request->query->getInt('article',1))
        ]);
    }
        

        
}

<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

}

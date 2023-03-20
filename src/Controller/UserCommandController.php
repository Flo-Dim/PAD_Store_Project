<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Command;
use App\Entity\LeftBudget;
use App\Entity\Quantity;
use App\Entity\User;
use App\Repository\ArticleRepository;
use App\Repository\CommandRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;



class UserCommandController extends AbstractController
{
    #[Route('/user/command', name: 'app_user_command')]
    public function index(SessionInterface $session, ArticleRepository $ArtRepo): Response
    {   
        
        $command = $session->get("command",[]);
        $datacommand=[];
        $total=0;
        $lbudget= 0;
        //$user->;
        //$budget= $user->getLeftBudget();
        foreach($command as $id => $quantity){
            $article = $ArtRepo->find($id);
            $datacommand[] = [
                "article"=>$article,
                "quantity"=>$quantity
            ];
            $total += $article->getPrice()*$quantity;
            
            
        }


        return $this->render('user_command/index.html.twig', compact("datacommand","total","lbudget")
        );
    }

    #[Route('/user/command/add/{id}', name: 'app_user_command_add')]
    public function addCommand(Article $article, SessionInterface $session): Response
    {   
        $command= $session->get("command",[]);
        $id = $article ->getId();

        if(!empty($command[$id])){
            $command[$id]++;
        }
        else{
            $command[$id] = 1;
        }

        $session->set("command",$command);
        return $this->redirectToRoute('app_user_command');        
    }

    #[Route('/user/command/remove/{id}', name: 'app_user_command_remove')]
    public function RemoveCommand(Article $article, SessionInterface $session): Response
    {   
        $command= $session->get("command",[]);
        $id = $article ->getId();

        if(!empty($command[$id])){
            if($command[$id] > 1 ){
                $command[$id]--;
            }else{
                unset($command[$id]);
            }
            
        }
      

        $session->set("command",$command);
        return $this->redirectToRoute('app_user_command');

       
    }

    #[Route('/user/command/delete/{id}', name: 'app_user_command_delete')]
    public function DeleteCommand(Article $article, SessionInterface $session): Response
    {   
        $command= $session->get("command",[]);
        $id = $article ->getId();

        if(!empty($command[$id])){
            
                unset($command[$id]);
            
        }
      

        $session->set("command",$command);
        return $this->redirectToRoute('app_user_command');

       
    }

    #[Route('/user/command/viewcommand', name: 'app_user_view_command')]
    public function UserViewCommand(ArticleRepository $ArtRepo,Request $request,EntityManagerInterface $entityManager,CommandRepository $comRep,SessionInterface $session): Response
    {   
       
       $total=0.0;
       $user = $this->getUser();
       $commands= new Command();
       $command = $session->get("command",[]);
       $datacommand=[];
       foreach($command as $id => $quantity){
            $article = $ArtRepo->find($id);
            $datacommand[] = [
            "articles"=>$article,
            "quantity"=>$quantity
                         ];
            $cart[$article->getId()]=['quantity'=>$quantity];
            $commands->addArticle($article);
            $commands->setQuantity($quantity);
            $commands->addUser($user);
            $total += $article->getPrice()*$quantity;
            $commands->setAmount($total); 
            $commands->setDate(new \DateTime());
            $entityManager->persist($commands);
            $entityManager->flush(); 
        }
    
  
     return $this->redirectToRoute('app_user_home_command', compact("commands"));
           
    }


    #[Route('/user/command/homecommand', name: 'app_user_home_command')]
    public function homeCommand(CommandRepository $ComRep): Response
    {
        $user = $this->getUser();
        return $this->render('user_command/commandview.html.twig', ['commands' => $ComRep->findAll(),'user'=>$user]);
    }

}

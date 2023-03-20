<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\Command;
use App\Repository\ArticleRepository;
use App\Repository\CommandRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PdfGeneratorController extends AbstractController
{
    #[Route('/pdf/generator', name: 'app_pdf_generator')]
    public function index(ArticleRepository $ArtRepo,SessionInterface $session): Response
    { 
       $total=0.0;
       $user = $this->getUser();
       $commands= new Command();
       $command = $session->get("command",[]);
       $datacommand=[];
       $art=[];
       foreach($command as $id => $quantity){
            $article = $ArtRepo->find($id);
            $datacommand[] = [
            "articles"=>$article,
            "quantity"=>$quantity
                             ];
            //$cart[$article->getId()]=['quantity'=>$quantity];
            $commands->addArticle($article);
            $commands->setQuantity($quantity);
            $commands->addUser($user);
            $total += $article->getPrice()*$quantity;
            $commands->setAmount($total); 
            $commands->setDate(new \DateTime());
            
        }
        $total=$commands->getAmount();
        $date=$commands->getDate();
        $unitp= $article->getPrice();
        $id=$commands->getId();

        $html = $this->renderView('pdf_generator/index.html.twig', [
            'amount'=>$total,
            'date'=>$date,
            'unitp'=>$unitp,
            'Id'=>$id,
            'datacommand'=>$datacommand,
            'quantity'=>$quantity
        ]);

        $options = new Options();
        $options->set('defaultFont', 'Bodoni');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream();

        return $this->render('pdf_generator/index.html.twig', [
            'amount'=>$total,
            'date'=>$date,
            'unitp'=>$unitp,
            'Id'=>$id,
            'art'=>$art,
            'datacommand'=>$datacommand,
            'quantity'=>$quantity
        ]);
    }
}


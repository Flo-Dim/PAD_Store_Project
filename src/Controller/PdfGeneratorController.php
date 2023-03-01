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
    public function index(CommandRepository $ComRepo, SessionInterface $session): Response
    { 

$html = $this->renderView('pdf_generator/index.html.twig');
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

        return $this->render('pdf_generator/index.html.twig');
    }
}


<?php

namespace App\Service;

use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\HttpFoundation\Response;

use App\Vente;
use Twig\Environment;

class Pdf
{
    private $domPdf;
    private $twig;

    public function __construct(Environment $twig) {
        $this->domPdf = new Dompdf();
        $this->twig = $twig;

        // Options de DOMPDF
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'helvetica'); // Utiliser la même police que dans TCPDF
        $pdfOptions->set('isPhpEnabled', true); // Activer l'exécution du PHP dans le HTML
        $pdfOptions->set('isHtml5ParserEnabled', true); // Activer le support HTML5

        $pdfOptions->set('defaultPaperSize', 'A4'); 

        $this->domPdf->setOptions($pdfOptions);
    }

    // Autres méthodes de la classe...

    public function generateVentePdf($vente): Response
    {
        // Générer le contenu HTML du PDF en utilisant Twig
        $html = $this->twig->render('vente/pdf.html.twig', [
            'vente' => $vente,
        ]);

        // Générer le PDF binaire
        $this->domPdf->loadHtml($html);
        $this->domPdf->render();
        $pdfBinary = $this->domPdf->output();

        // Créer une réponse pour le PDF
        $response = new Response($pdfBinary);
        $response->headers->set('Content-Type', 'application/pdf');

        return $response;
    }
}

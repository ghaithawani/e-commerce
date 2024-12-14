<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Reclamation;
use App\Entity\Response as ResponseEntity;
use App\Repository\ReclamationRepository;
use App\Repository\ResponseRepository;

class StatsController extends AbstractController
{
    #[Route('/stats', name: 'app_stats')]
    public function index(ReclamationRepository $reclamationRepository, ResponseRepository $responseRepository): Response
    {
        $totalReclamationsCount = $reclamationRepository->countReclamations();
        $totalResponsesCount = $responseRepository->countResponses();
        $totalTraiteeReClamationsCount = $reclamationRepository->countReclamationsByStatus('traitee');
        $totalNonTraiteeReClamationsCount = $reclamationRepository->countReclamationsByStatus('non traitee');
        $reclamationsForTenLastMonths = $reclamationRepository->countReclamationsByMonth();

        return $this->render('stats/index.html.twig', [
            'totalReclamationsCount' => $totalReclamationsCount,
            'totalResponsesCount' => $totalResponsesCount,
            'totalTraiteeReclamationsCount' => $reclamationRepository->countReclamationsByStatus('traitee'),
            'totalNonTraiteeReclamationsCount' => $reclamationRepository->countReclamationsByStatus('non traitee'),
            'reclamationsForTenLastMonths' => $reclamationsForTenLastMonths,
        ]);
    
    }
}

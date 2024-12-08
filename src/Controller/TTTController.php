<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TTTController extends AbstractController
{
    #[Route('/t', name: 'app_t_t_t')]
    public function index(): Response
    {
        return $this->render('t.html.twig', [
            'controller_name' => 'TTTController',
        ]);
    }
}

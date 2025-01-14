<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BackController extends AbstractController
{
    #[Route('/b', name: 'app_back')]
    public function index(): Response
    {
        return $this->render('b.html.twig', [
            'controller_name' => 'BackController',
        ]);
    }
}

<?php

namespace App\Controller;

use Knp\Component\Pager\PaginatorInterface;
use App\Entity\Reclamation;
use App\Form\ReclamationType;
use App\Form\ResponseType;
use App\Repository\ReclamationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Response as ResponseEntity;

#[Route('/reclamationfront')]
class ReclamationControllerFront extends AbstractController

{#[Route('/', name: 'reclamationfront_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ReclamationRepository $reclamationRepository): Response
    {
        $reclamation = new Reclamation();
        // Set the current date and time to daterec
        $reclamation->setDaterec(new \DateTime());
        $reclamation->setStatutrec('non traitee');

        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reclamationRepository->save($reclamation);
            return $this->redirectToRoute('reclamation_index');
        }

        return $this->render('reclamationfront/newfront.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form->createView(),
        ]);
    }}
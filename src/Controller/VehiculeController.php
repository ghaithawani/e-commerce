<?php

namespace App\Controller;

use App\Entity\Vehicule;
use App\Form\VehiculeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/vehicule')]
class VehiculeController extends AbstractController
{
    #[Route('/', name: 'app_vehicule_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $vehicules = $entityManager
            ->getRepository(Vehicule::class)
            ->findAll();

        return $this->render('vehicule/index.html.twig', [
            'vehicules' => $vehicules,
        ]);
    }
 #[Route('/affichfront', name: 'app_vehicule_affichfront', methods: ['GET'])]
    public function affichfront(EntityManagerInterface $entityManager): Response
    {
        $vehicules = $entityManager
            ->getRepository(Vehicule::class)
            ->findAll();

        return $this->render('vehicule/affichfront.html.twig', [
            'vehicules' => $vehicules,
        ]);
    }
    #[Route('/new', name: 'app_vehicule_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $vehicule = new Vehicule();
        $form = $this->createForm(VehiculeType::class, $vehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($vehicule);
            $entityManager->flush();

            return $this->redirectToRoute('app_vehicule_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vehicule/new.html.twig', [
            'vehicule' => $vehicule,
            'form' => $form,
        ]);
    }

    #[Route('/{idvehicule}', name: 'app_vehicule_show', methods: ['GET'])]
    public function show(Vehicule $vehicule): Response
    {
        return $this->render('vehicule/show.html.twig', [
            'vehicule' => $vehicule,
        ]);
    }
 #[Route('/showfront/{idvehicule}', name: 'app_vehicule_showfront', methods: ['GET'])]
    public function showfront(Vehicule $vehicule): Response
    {
        return $this->render('vehicule/showfront.html.twig', [
            'vehicule' => $vehicule,
        ]);
    }

    #[Route('/{idvehicule}/edit', name: 'app_vehicule_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Vehicule $vehicule, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VehiculeType::class, $vehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_vehicule_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vehicule/edit.html.twig', [
            'vehicule' => $vehicule,
            'form' => $form,
        ]);
    }

    #[Route('/{idvehicule}', name: 'app_vehicule_delete', methods: ['POST'])]
    public function delete(Request $request, Vehicule $vehicule, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vehicule->getIdvehicule(), $request->request->get('_token'))) {
            $entityManager->remove($vehicule);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_vehicule_index', [], Response::HTTP_SEE_OTHER);
    }
}

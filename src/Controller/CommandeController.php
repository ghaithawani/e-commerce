<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Form\CommandeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/commande')]
class CommandeController extends AbstractController
{
    #[Route('/', name: 'app_commande_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $commandes = $entityManager
            ->getRepository(Commande::class)
            ->findAll();

        return $this->render('commande/index.html.twig', [
            'commandes' => $commandes,
           
        ]);

    }
  #[Route('/triecommande', name:'app_trie_commande', methods: ['GET'])]
public function trierCommandeParEvenement(EntityManagerInterface $entityManager, Request $request): Response
{
    if ($request->isXmlHttpRequest()) {
        // Récupérer les paramètres de tri depuis la requête AJAX
        $tri = $request->query->get('tri');

        // Votre logique de tri des commandes en fonction des paramètres reçus
        if ($tri === 'ASC') { // Changer ASC à DESC pour trier de façon descendante
            $commandes = $entityManager
                ->getRepository(Commande::class)
                ->findBy([], ['idCommande' => 'DESC']); // Changer DESC à ASC pour trier de façon descendante
        } else {
            $commandes = $entityManager
                ->getRepository(Commande::class)
                ->findBy([], ['idCommande' => 'ASC']);
        }

        // Convertir les données triées en JSON et les renvoyer
        return $this->json($commandes);
    }

    // Si ce n'est pas une requête AJAX, renvoyer la page HTML normale
    $commandes = $entityManager
        ->getRepository(Commande::class)
        ->findBy([], ['idCommande' => 'DESC']);

    return $this->render('commande/affichfront.html.twig', [
        'commandes' => $commandes,
    ]);
}


     #[Route('/affichfront', name: 'app_commande_affichfront', methods: ['GET'])]
    public function affichfront(EntityManagerInterface $entityManager): Response
    {
        $commandes = $entityManager
            ->getRepository(Commande::class)
            ->findAll();

        return $this->render('commande/affichfront.html.twig', [
            'commandes' => $commandes,
           
        ]);

    }

    #[Route('/new', name: 'app_commande_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $commande = new Commande();
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($commande);
            $entityManager->flush();

            return $this->redirectToRoute('app_commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commande/new.html.twig', [
            'commande' => $commande,
            'form' => $form,
        ]);
    }

    #[Route('/{idCommande}', name: 'app_commande_show', methods: ['GET'])]
    public function show(Commande $commande): Response
    {
        return $this->render('commande/show.html.twig', [
            'commande' => $commande,
        ]);
    }
 #[Route('/frontshow/{idCommande}', name: 'app_commande_show', methods: ['GET'])]
    public function frontshow(Commande $commande): Response
    {
        return $this->render('commande/frontshow.html.twig', [
            'commande' => $commande,
        ]);
    }
 #[Route('/front/frontshow/{idCommande}', name: 'app_commande_showf', methods: ['GET'])]
    public function frontshowf(Commande $commande): Response
    {
        return $this->render('commande/showf.html.twig', [
            'commande' => $commande,
        ]);
    }
    #[Route('/{idCommande}/edit', name: 'app_commande_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Commande $commande, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commande/edit.html.twig', [
            'commande' => $commande,
            'form' => $form,
        ]);
    }

    #[Route('/{idCommande}', name: 'app_commande_delete', methods: ['POST'])]
    public function delete(Request $request, Commande $commande, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commande->getIdCommande(), $request->request->get('_token'))) {
            $entityManager->remove($commande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_commande_index', [], Response::HTTP_SEE_OTHER);
    }
}

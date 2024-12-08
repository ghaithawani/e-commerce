<?php

namespace App\Controller;

use App\Entity\Produits;
use App\Form\ProduitsType;
use App\Repository\ProduitsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;




#[Route('/produits')]
class ProduitsController extends AbstractController
{
    #[Route('/', name: 'app_produits_index', methods: ['GET'])]
    public function index(ProduitsRepository $produitsRepository, Request $request, PaginatorInterface $paginator): Response
    {
        // Fetch products from the repository
        $produitsQuery = $produitsRepository->findAll();
    
        // Paginate the products query
        $produits = $paginator->paginate(
            $produitsQuery, // Query to paginate
            $request->query->getInt('page', 1), // Current page number, default is 1
            3 // Items per page
        );
    
        return $this->render('produits/index.html.twig', [
            'produits' => $produits, // Pass the paginated products to the template
        ]);
    }

        
 #[Route('/new', name: 'app_produits_new', methods: ['GET', 'POST'])]
 public function new(Request $request, EntityManagerInterface $entityManager): Response
 {
     $produit = new Produits();
     
     // Utilisez le formulaire ProduitsType avec les modifications apportées
     $form = $this->createForm(ProduitsType::class, $produit);
     $form->handleRequest($request);

     if ($form->isSubmitted() && $form->isValid()) {
         $entityManager->persist($produit);
         $entityManager->flush();

         return $this->redirectToRoute('app_produits_index', [], Response::HTTP_SEE_OTHER);
     }

     return $this->renderForm('produits/new.html.twig', [
         'produit' => $produit,
         'form' => $form,
     ]);
 }

    #[Route('/{id}', name: 'app_produits_show', methods: ['GET'])]
    public function show(Produits $produit): Response
    {
        return $this->render('produits/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_produits_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Produits $produit, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProduitsType::class, $produit);

        $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->flush();

        return $this->redirectToRoute('app_produits_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('produits/edit.html.twig', [
        'produit' => $produit,
        'form' => $form,
    ]);
    }

    #[Route('/{id}', name: 'app_produits_delete', methods: ['POST'])]
    public function delete(Request $request, Produits $produit, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
            $entityManager->remove($produit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_produits_index', [], Response::HTTP_SEE_OTHER);
    }
}

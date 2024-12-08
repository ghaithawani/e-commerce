<?php

namespace App\Controller;

use App\Entity\Vente;
use App\Form\VenteType;
use App\Repository\VenteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use App\Service\Pdf;


#[Route('/vente')]
class VenteController extends AbstractController
{
    #[Route('/', name: 'app_vente_index', methods: ['GET'])]
    public function index(VenteRepository $venteRepository,Request $request, PaginatorInterface $paginator): Response
    {

        // Fetch products from the repository
        $venteQuery = $venteRepository->findAll();
    
        // Paginate the products query
        $ventes = $paginator->paginate(
            $venteQuery, // Query to paginate
            $request->query->getInt('page', 1), // Current page number, default is 1
            3// Items per page
        );
        return $this->render('vente/index.html.twig', [
            'ventes' => $ventes, // Pass the paginated ventes to the template
        ]);
    }

    #[Route('/new', name: 'app_vente_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
    
        $vente = new Vente();
        $form = $this->createForm(VenteType::class, $vente);
        $form->handleRequest($request);
    
    
        if ($form->isSubmitted() && $form->isValid()) {
    
            $produit = $form->get('idProduit')->getData();
            $quantiteVendu = $form->get('quantitevendu')->getData();
            $montanttotal = $form->get('montanttotal')->getData();


                $entityManager->persist($vente);
                $entityManager->flush();
          
            return $this->redirectToRoute('app_vente_show', ['id' => $vente->getId()]);
        
            }
    
        return $this->render('vente/new.html.twig', [
            'vente' => $vente, // Pass the vente entity to the template
            'form' => $form->createView(),
        ]);
    }
    
    #[Route('/{id}/pdf', name: 'app_vente_pdf', methods: ['GET'])]
    public function ventePdf(Vente $vente, Pdf $pdfService): Response
    {
        // Générer le PDF à partir des données de la vente
        $pdfResponse = $pdfService->generateVentePdf($vente);
    return $pdfResponse;
    }
    
    #[Route('/{id}', name: 'app_vente_show', methods: ['GET'])]
    public function show(Vente $vente): Response
    {
        return $this->render('vente/show.html.twig', [
            'vente' => $vente,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_vente_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Vente $vente, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VenteType::class, $vente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_vente_show', ['id' => $vente->getId()]);
        }

        return $this->renderForm('vente/edit.html.twig', [
            'vente' => $vente,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_vente_delete', methods: ['POST'])]
    public function delete(Request $request, Vente $vente, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vente->getId(), $request->request->get('_token'))) {
            $entityManager->remove($vente);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_vente_index', [], Response::HTTP_SEE_OTHER);
    }
}

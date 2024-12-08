<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Reclamation;
use App\Entity\Response as ResponseEntity;
use App\Form\ReclamationType;
use App\Form\ResponseType;
use App\Repository\ReclamationRepository;
use App\Repository\ResponseRepository;
use Knp\Component\Pager\PaginatorInterface;

class ResponseController extends AbstractController
{
    #[Route('/response', name: 'response_index', methods: ['GET'])]
    public function index(Request $request, ResponseRepository $responseRepository, PaginatorInterface $paginator): Response
    {
        $searchQuery = $request->query->get('search', '');
        $queryBuilder = $responseRepository->findBySearchQuery($searchQuery);

        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1), /* page number */
            10 /* limit per page */
        );

        return $this->render('response/index.html.twig', [
            'pagination' => $pagination,
            'search' => $searchQuery,
        ]);
    }
    #[Route('/response/new', name: 'response_new', methods: ['GET', 'POST'])]
    
    public function new(Request $request, ResponseRepository $responseRepository): Response
    {
        $response = new ResponseEntity();
        $form = $this->createForm(ResponseType::class, $response);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $responseRepository->save($response);

            return $this->redirectToRoute('response_index');

        }

        return $this->render('response/new.html.twig', [
            'responseForm' => $form->createView(),
        ]);
    }

    #[Route('/response/{idrep}/edit', name: 'response_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, $idrep, ResponseRepository $responseRepository): Response
    {
        $response = $responseRepository->find($idrep);

        if (!$response) {
            throw $this->createNotFoundException('No response found for id '.$idrep);
        }

        $form = $this->createForm(ResponseType::class, $response);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $responseRepository->save($response);
            return $this->redirectToRoute('response_index');
        }

        return $this->render('response/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    // src/Controller/ResponseController.php

    #[Route('/response/{idrep}/delete', name: 'response_delete', methods: ['GET', 'POST'])]
    public function delete(
        Request $request, 
        ResponseEntity $response, 
        ResponseRepository $responseRepository, 
        ReclamationRepository $reclamationRepository
    ): Response
    {
        if ($request->isMethod('GET')) {
            $deleteForm = $this->createFormBuilder()
                ->setAction($this->generateUrl('response_delete', ['idrep' => $response->getIdrep()]))
                ->setMethod('POST')
                ->getForm();
    
            return $this->render('response/confirm_delete.html.twig', [
                'response' => $response,
                'delete_form' => $deleteForm->createView(),
            ]);
        }
    
        if ($this->isCsrfTokenValid('delete'.$response->getIdrep(), $request->request->get('_token'))) {
            $reclamation = $response->getReclamation();
            
            // Check if the reclamation exists
            if ($reclamation) {
                $reclamation->setStatutrec('non traitee');
                $reclamationRepository->save($reclamation);
            }
    
            $responseRepository->delete($response);
            $this->addFlash('success', 'The response has been deleted.');
    
            return $this->redirectToRoute('response_index');
        }
    
        return $this->redirectToRoute('response_index');
    }
    



}

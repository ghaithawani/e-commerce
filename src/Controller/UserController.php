<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
#[Route('/user')]
class UserController extends AbstractController
{

    #[Route('/', name: 'app_user', methods: ['GET'])]
    public function index(UserRepository $userRepository,Request $request, PaginatorInterface $paginator): Response
    {

        // Fetch products from the repository
        $userQuery = $userRepository->findAll();
    
        // Paginate the products query
        $users = $paginator->paginate(
            $userQuery, // Query to paginate
            $request->query->getInt('page', 1), // Current page number, default is 1
            3// Items per page
        );
        return $this->render('user/index.html.twig', [
            'users' => $users, // Pass the paginated ventes to the template
        ]);
    }
    /*#[Route('/user', name: 'app_user')]
    public function index(): Response
    {

        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }*/
}

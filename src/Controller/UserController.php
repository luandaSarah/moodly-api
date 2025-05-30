<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('api', name: 'api_users_')]
class UserController extends AbstractController
{

    public function __construct(
        private UserRepository $userRepository,
    ) {}

    #[Route('/users', 'index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return $this->json(
            $this->userRepository->findAll(),
            Response::HTTP_OK,
        );
    }

    #[Route('/profile', name: 'profile_show', methods: ['GET'])]
    public function show(): JsonResponse
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->json(
                [
                    'error' => 'L\'utilisateur n\'est pas connecté'
                ],
                Response::HTTP_UNAUTHORIZED
            );
        }
        return $this->json(
            $user,
            Response::HTTP_OK,
            context: [
                'groups' => ['profile:show', 'common:index'],
            ],
        );
        // dd($this->getUser());
    }
}

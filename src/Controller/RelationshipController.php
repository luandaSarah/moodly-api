<?php

namespace App\Controller;

use App\Entity\UserInfo;
use App\Entity\Relationship;
use App\Repository\RelationshipRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('api', name: 'api_relationship_')]
class RelationshipController extends AbstractController
{
    public function __construct(
        private RelationshipRepository $relationshipRepository,
    ) {}

    /**
     * Récupere les utilisateurs qui suive l'user connecté
     *
     * @return JsonResponse
     */
    #[Route('/profile/followers', name: 'profile_followers', methods: ['GET'])]
    public function profileFollowers(): JsonResponse
    {
        $user = $this->getUser();

        return $this->json(
            $this->relationshipRepository->findBy(['followed' => $user]), //les utilisateurs qui following users donc users=followed
            Response::HTTP_OK,
            context: [
                'groups' => ['common:index', 'followers:index'],
            ],
        );
    }


    /**
     * Récupere les utilisateurs que l'user connecté suit
     *
     * @return JsonResponse
     */
    #[Route('/profile/following', name: 'profile_following', methods: ['GET'])]
    public function profileFollowing(): JsonResponse
    {
        $user = $this->getUser();

        return $this->json(
            $this->relationshipRepository->findBy(['following' => $user]), //les utilisateurs qui following users donc users=followed
            Response::HTTP_OK,
            context: [
                'groups' => ['common:index', 'following:index'],
            ],
        );
    }

     #[Route('/users/{id}/followers', name: 'users_followers', methods:['GET'])]
    public function usersFollowers(UserInfo $user): JsonResponse
    {
           return $this->json(
            $this->relationshipRepository->findBy(['followed' => $user]), //les utilisateurs qui following users donc users=followed
            Response::HTTP_OK,
            context: [
                'groups' => ['common:index', 'followers:index'],
            ],
        );
    }

    #[Route('/users/{id}/following', name: 'users_following', methods:['GET'])]
    public function usersFollowing(UserInfo $user): JsonResponse
    {
           return $this->json(
            $this->relationshipRepository->findBy(['following' => $user]), //les utilisateurs qui following users donc users=followed
            Response::HTTP_OK,
            context: [
                'groups' => ['common:index', 'following:index'],
            ],
        );
    }
}

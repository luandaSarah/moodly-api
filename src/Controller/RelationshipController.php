<?php

namespace App\Controller;

use App\Entity\UserInfo;
use App\Entity\Relationship;
use App\Repository\RelationshipRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Dto\Relationship\RelationshipCreateDto;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Mapper\Relationship\RelationshipCreateMapper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('api', name: 'api_relationship_')]
class RelationshipController extends AbstractController
{
    public function __construct(
        private RelationshipRepository $relationshipRepository,
        private EntityManagerInterface $em,
        private RelationshipCreateMapper $relationshipCreateMapper,

    ) {}

    /**
     * Récupere les utilisateurs qui suive l'user connecté
     *
     * @return JsonResponse
     */
    #[Route('/profile/followersIndex', name: 'profile_followers_index', methods: ['GET'])]
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
    #[Route('/profile/following', name: 'profile_following_index', methods: ['GET'])]
    public function profileFollowingIndex(): JsonResponse
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


    /**
     * Récupere les utilisateurs qui suive l'user en paramettre
     * @param \App\Entity\UserInfo $user
     * @return JsonResponse
     */
    #[Route('/users/{id}/followers', name: 'users_followers_index', methods: ['GET'])]

    public function usersFollowersIndex(UserInfo $user): JsonResponse
    {
        return $this->json(
            $this->relationshipRepository->findBy(['followed' => $user]), //les utilisateurs qui following users donc users=followed
            Response::HTTP_OK,
            context: [
                'groups' => ['common:index', 'followers:index'],
            ],
        );
    }


    /**
     * Récupere les utilisateurs que l'user en paramettre suit
     * @param \App\Entity\UserInfo $user
     * @return JsonResponse
     */
    #[Route('/users/{id}/following', name: 'users_following_index', methods: ['GET'])]
    public function usersFollowingIndex(UserInfo $user): JsonResponse
    {
        return $this->json(
            $this->relationshipRepository->findBy(['following' => $user]), //les utilisateurs qui following users donc users=followed
            Response::HTTP_OK,
            context: [
                'groups' => ['common:index', 'following:index'],
            ],
        );
    }

    #[Route('/follow', name: 'create', methods: ['POST'])]
    public function create(
        #[MapRequestPayload]
        RelationshipCreateDto $dto
    ): JsonResponse {
        $userConnected = $this->getUser();
        $relationship = $this->relationshipCreateMapper->map($dto, $userConnected);
        $this->em->persist($relationship);
        $this->em->flush();

        return $this->json(
            [
                'id' => $relationship->getId(),
            ],
            Response::HTTP_CREATED,
            context: [
                'groups' => ['common:index'],
            ],
        );
    }

    #[Route('/follow/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(Relationship $relationship): JsonResponse
    {
        $this->em->remove($relationship);
        $this->em->flush();
        return $this->json(
            null,
            Response::HTTP_NO_CONTENT
        );
    }
}

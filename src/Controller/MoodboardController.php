<?php

namespace App\Controller;

use App\Entity\UserInfo;
use App\Entity\Moodboard;
use App\Dto\Filter\PaginationFilterDto;
use App\Repository\MoodboardRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Dto\Moodboard\MoodboardCreateDto;
use App\Dto\Moodboard\MoodboardUpdateDto;
use App\Repository\RelationshipRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Mapper\Moodboard\MoodboardCreateMapper;
use App\Mapper\Moodboard\MoodboardUpdateMapper;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('api', name: 'api_moodboard_')]

class MoodboardController extends AbstractController
{
    public function __construct(
        private MoodboardRepository $moodboardRepository,
        private RelationshipRepository $relationshipRepository,
        private EntityManagerInterface $em,
        private MoodboardCreateMapper $moodboardCreateMapper,
        private MoodboardUpdateMapper $moodboardUpdateMapper,
    ) {}


    #[Route('/moodboards', name: 'index', methods: ['GET'])]
    public function index(
        #[MapQueryString]
        PaginationFilterDto $paginationDto,
    ): JsonResponse {

        return $this->json(
            $this->moodboardRepository->findPaginate($paginationDto),
            Response::HTTP_OK,
            context: [
                'groups' => ['common:index', 'moodboard:index', 'moodboard:image'],
            ],
        );
    }

    #[Route('/profile/following/moodboards', name: 'profile_following_index', methods: ['GET'])]
    public function moodboardProfileFollowingIndex(
        #[MapQueryString]
        PaginationFilterDto $paginationDto,
    ): JsonResponse {

        $user = $this->getUser();
        return $this->json(
            $this->moodboardRepository->findPaginate($paginationDto, $user, true),
            Response::HTTP_OK,
            context: [
                'groups' => ['common:index', 'moodboard:index', 'moodboard:image'],
            ],
        );
    }

    #[Route('/profile/moodboards', name: 'profile_index', methods: ['GET'])]
    public function moodboardProfileIndex(
        #[MapQueryString]
        PaginationFilterDto $paginationDto,
    ): JsonResponse {
        $user = $this->getUser();

        return $this->json(
            $this->moodboardRepository->findPaginate($paginationDto, $user),
            Response::HTTP_OK,
            context: [
                'groups' => ['common:index', 'moodboard:index', 'moodboard:image'],
            ],
        );
    }


    #[Route('/users/{id}/moodboards', name: 'user_index', methods: ['GET'])]
    public function moodboardUserIndex(
        UserInfo $user,
        #[MapQueryString]
        PaginationFilterDto $paginationDto,
    ): JsonResponse {
        return $this->json(
            $this->moodboardRepository->findPaginate($paginationDto, $user),
            Response::HTTP_OK,
            context: [
                'groups' => ['common:index', 'moodboard:index', 'moodboard:image'],
            ],
        );
    }


    #[Route('/moodboards/{id}', name: 'show', methods: ['GET'])]
    public function show(Moodboard $moodboard): JsonResponse
    {
        return $this->json(
            $moodboard,
            Response::HTTP_OK,
            context: [
                'groups' => ['common:index', 'moodboard:show', 'moodboard:image'],
            ],
        );
    }

    #[Route('/moodboards', name: 'create', methods: ['POST'])]
    public function create(
        #[MapRequestPayload]
        MoodboardCreateDto $dto,
    ): JsonResponse {
        $userConnected = $this->getUser();
        $moodboard = $this->moodboardCreateMapper->map($dto, $userConnected);
        $this->em->persist($moodboard);
        $this->em->flush();

        return $this->json(
            [
                'id' => $moodboard->getId(),
            ],
            Response::HTTP_CREATED,
        );
    }

    #[Route('/moodboards/{id}', name: 'update', methods: ['PATCH'])]
    public function update(
        Moodboard $moodboard,
        #[MapRequestPayload]
        MoodboardUpdateDto $dto,
    ): JsonResponse {
        $this->moodboardUpdateMapper->map($dto, $moodboard);
        $this->em->flush();

        return $this->json(
            [
                $moodboard
            ],
            Response::HTTP_OK,
            context: [
                'groups' => ['common:index', 'moodboard:index', 'moodboard:image'],
            ],
        );
    }

    #[Route('/moodboards/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(Moodboard $moodboard): JsonResponse
    {
        $this->em->remove($moodboard);
        $this->em->flush();

        return $this->json(
            null,
            Response::HTTP_NO_CONTENT
        );
    }
}

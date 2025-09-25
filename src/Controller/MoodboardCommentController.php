<?php

namespace  App\Controller;

use App\Dto\Filter\PaginationFilterDto;
use App\Dto\Moodboard\MoodboardUpdateDto;
use App\Entity\Moodboard;
use App\Entity\MoodboardComment;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\MoodboardCommentRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Dto\MoodboardComment\MoodboardCommentCreateDto;
use App\Dto\MoodboardComment\MoodboardCommentUpdateDto;
use App\Mapper\MoodboardComment\MoodboardCommentCreateMapper;
use App\Mapper\MoodboardComment\MoodboardCommentUpdateMapper;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;

#[Route('api', name: 'api_moodboard_comment_')]
class MoodboardCommentController extends AbstractController
{

    public function __construct(
        private MoodboardCommentRepository $moodboardCommentRepository,
        private EntityManagerInterface $em,
        private MoodboardCommentCreateMapper $moodboardCommentCreateMapper,
        private MoodboardCommentUpdateMapper $moodboardCommentUpdateMapper,

    ) {}


    #[Route('/moodboards/{id}/comments', 'index', methods: ['GET'])]
    public function index(
        #[MapQueryString]
        PaginationFilterDto $paginationFilterDto,
        Moodboard $moodboard,
    ): JsonResponse {
        return $this->json(
            $this->moodboardCommentRepository->findPaginate($paginationFilterDto, $moodboard),
            Response::HTTP_OK,
            context: ['groups' => ['moodboard:comments', 'common:index']]
        );
    }

    #[Route('/moodboards/comments/{id}', 'show', methods: ['GET'])]
    public function show(

        MoodboardComment $moodboardComment,
    ): JsonResponse {
        return $this->json(
            $this->moodboardCommentRepository->find($moodboardComment),
            Response::HTTP_OK,
            context: ['groups' => ['moodboard:comments', 'common:index']]
        );
    }

    #[Route('/moodboards/{id}/comments', name: 'create', methods: ['POST'])]
    public function create(
        #[MapRequestPayload]
        MoodboardCommentCreateDto $dto,
        Moodboard $moodboard,
    ): JsonResponse {
        $connectedUser = $this->getUser();
        $moodboardComment = $this->moodboardCommentCreateMapper->map($dto, $connectedUser, $moodboard);
        $this->em->persist($moodboardComment);
        $this->em->flush();

        return $this->json(
            $moodboardComment,
            Response::HTTP_CREATED,
            context: ['groups' => ['moodboard:comments', 'common:index']]
        );
    }

    #[Route('/moodboards/comments/{id}', name: 'update', methods: ['PATCH'])]
    public function update(
        #[MapRequestPayload]
        MoodboardCommentUpdateDto $dto,
        MoodboardComment $moodboardComment,
    ): JsonResponse {
        $this->moodboardCommentUpdateMapper->map($dto, $moodboardComment);
        $this->em->flush();

        return $this->json(
            [
                $moodboardComment,
            ],
            Response::HTTP_OK,
            context: ['groups' => ['moodboard:comments', 'common:index']]
        );
    }


    #[Route('/moodboards/comments/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(MoodboardComment $moodboardComment): JsonResponse
    {
        $this->em->remove($moodboardComment);
        $this->em->flush();

        return $this->json(
            null,
            Response::HTTP_NO_CONTENT
        );
    }
}

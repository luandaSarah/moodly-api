<?php

namespace App\Controller;

use App\Entity\Moodboard;
use App\Entity\MoodboardLike;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Mapper\MoodboardLike\MoodboardLikeMapper;
use App\Repository\MoodboardLikeRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('api', name: 'api_moodboard_likes_')]
class MoodboardLikeController extends AbstractController
{

    public function __construct(
        private MoodboardLikeRepository $moodboardLikeRepository,
        private EntityManagerInterface $em,
        private MoodboardLikeMapper $moodboardLikeMapper
    ) {}



    #[Route('/moodboards/{id}/likes', 'count', methods: ['GET'])]
    public function count(
        Moodboard $moodboard
    ): JsonResponse {
        $connectedUser = $this->getUser();

        $moodboardLikeTotal = $this->moodboardLikeRepository->count(['moodboard' => $moodboard]);

        $liked = $this->moodboardLikeRepository->findOneBy([
            'moodboard' => $moodboard,
            'user' => $connectedUser,
        ]) !== null;

        return $this->json(
            [
                "likeNumber" => $moodboardLikeTotal,
                'likedByCurrentUser' => $liked,
            ],
            Response::HTTP_OK,
            context: ['groups' => 'moodboard:index']
        );
    }



    #[Route('/moodboards/{id}/likes', 'create', methods: ['POST'])]
    public function create(
        Moodboard $moodboard
    ): JsonResponse {
        $connectedUser = $this->getUser();

        $moodboardLike = $this->moodboardLikeMapper->map($moodboard, $connectedUser);

        $this->em->persist($moodboardLike);
        $this->em->flush();

        return $this->json(
            ["id" => $moodboardLike->getId()],
            Response::HTTP_CREATED,
            context: ['groups' => 'moodboard:index']
        );
    }



    #[Route('/moodboards/{id}/likes', 'delete', methods: ['DELETE'])]
    public function delete(
        Moodboard $moodboard
    ): JsonResponse {

        $connectedUser = $this->getUser();

        $moodboardLike = $this->moodboardLikeRepository->findOneBy([
            'moodboard' => $moodboard,
            'user' => $connectedUser,
        ]);

        if (!$moodboardLike) {
            return $this->json([
                'error' => 'Like non trouvé.'
            ], Response::HTTP_NOT_FOUND);
        }
        $this->em->remove($moodboardLike);
        $this->em->flush();

        return $this->json(
            null,
            Response::HTTP_NO_CONTENT,
        );
    }
}

<?php

namespace App\Mapper\MoodboardComment;

use App\Dto\MoodboardComment\MoodboardCommentCreateDto;
use App\Entity\Moodboard;
use App\Entity\MoodboardComment;
use App\Repository\MoodboardRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\User\UserInterface;

class MoodboardCommentCreateMapper
{

    public function __construct(
        private MoodboardRepository $moodboardRepository,
    ) {}

    public function map(MoodboardCommentCreateDto $dto, UserInterface $connectedUser, Moodboard $moodboard): MoodboardComment
    {
        $moodboardComment = new MoodboardComment;

        if (null !== $dto->getContent()) {
            $moodboardComment->setContent(
                $dto->getContent()
            );
        }

        if (null === $moodboard) {
            throw new NotFoundHttpException('Moodboard introuvable');
        }

        $moodboardComment->setMoodboard(
            $moodboard
        );

        if (null !== $connectedUser) {

            $moodboardComment->setUser(
                $connectedUser,
            );
        } else {
            throw new NotFoundHttpException('Vous devez être connecté');
        }


        return $moodboardComment;
    }
}

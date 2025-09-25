<?php

namespace App\Mapper\MoodboardComment;

use App\Dto\MoodboardComment\MoodboardCommentUpdateDto;
use App\Entity\MoodboardComment;
use App\Repository\MoodboardRepository;


class MoodboardCommentUpdateMapper
{

    public function __construct(
        private MoodboardRepository $moodboardRepository,
    ) {}

    public function map(MoodboardCommentUpdateDto $dto, MoodboardComment $moodboardComment): MoodboardComment
    {

        if (null !== $dto->getContent()) {
            $moodboardComment->setContent(
                $dto->getContent()
            );
        }

        return $moodboardComment;
    }
}

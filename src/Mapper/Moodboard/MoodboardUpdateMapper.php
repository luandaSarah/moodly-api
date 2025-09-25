<?php

namespace App\Mapper\Moodboard;

use App\Entity\Moodboard;
use App\Dto\Moodboard\MoodboardUpdateDto;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MoodboardUpdateMapper
{
    public function map(MoodboardUpdateDto $dto, Moodboard $moodboard): Moodboard
    {

        if (null !== $dto->getTitle()) {
            $moodboard->setTitle(
                $dto->getTitle()
            );
        }

        if (null !== $dto->getBackgroundColor()) {
            $moodboard->setBackgroundColor(
                $dto->getBackgroundColor()
            );
        }

        
        if (null !== $dto->getStatus()) {
            $moodboard->setStatus(
                $dto->getStatus()
            );
        }


        return $moodboard;
    }
}

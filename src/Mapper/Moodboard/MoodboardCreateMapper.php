<?php

namespace App\Mapper\Moodboard;

use App\Entity\Moodboard;
use App\Dto\Moodboard\MoodboardCreateDto;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MoodboardCreateMapper
{
    public function map(MoodboardCreateDto $dto, $connectedUser): Moodboard
    {
        $moodboard = new Moodboard;

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


        if (null !== $connectedUser) {

            $moodboard->setUser(
                $connectedUser,
            );
        } else {
            throw new NotFoundHttpException('Vous devez être connecté');
        }
        return $moodboard;
    }
}

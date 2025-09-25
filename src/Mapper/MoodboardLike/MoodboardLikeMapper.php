<?php

namespace App\Mapper\MoodboardLike;

use App\Entity\Moodboard;
use App\Entity\MoodboardLike;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\User\UserInterface;

class MoodboardLikeMapper
{

    public function __construct() {}

    public function map(Moodboard $moodboard, UserInterface $user): MoodboardLike
    {

        $moodboardLike = new MoodboardLike;

        if (null !== $moodboard) {
            $moodboardLike->setMoodboard(
                $moodboard
            );
        } else {
            throw new NotFoundHttpException('Moodboard introuvable');
        }


        if (null !== $user) {

            $moodboardLike->setUser(
                $user,
            );
        } else {
            throw new NotFoundHttpException('Vous devez être connecté');
        }

        return $moodboardLike;
    }
}

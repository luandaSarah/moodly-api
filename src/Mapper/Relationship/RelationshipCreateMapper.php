<?php

namespace App\Mapper\Relationship;

use App\Entity\Relationship;
use App\Repository\UserInfoRepository;
use App\Dto\Relationship\RelationshipCreateDto;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RelationshipCreateMapper
{
    public function __construct(
        private readonly UserInfoRepository $userInfoRepository,
    ) {}

    public function map(RelationshipCreateDto $dto, $ConnectedUser): Relationship
    {
        $relationship = new Relationship;

        if (null !== $dto->getFollowed()) {
            $followed = $this->userInfoRepository->find($dto->getFollowed());
            if (null === $followed) {
                throw new NotFoundHttpException('Utilisateur introuvable');
            }

            $relationship->setFollowed(
                $followed
            );
        }

        if (null !== $ConnectedUser) {

            if ($ConnectedUser !== $followed) {
                $relationship->setFollowing(
                    $ConnectedUser,
                );
            } else {
                throw new NotFoundHttpException('Vous ne pouvez vous suivre vous même');
            }
        } else {
            throw new NotFoundHttpException('Vous devez être connecté');
        }

        return $relationship;
    }
}

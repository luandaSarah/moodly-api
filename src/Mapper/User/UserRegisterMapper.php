<?php

namespace App\Mapper\User;

use App\Dto\User\UserRegisterDto;
use App\Entity\UserInfo;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserRegisterMapper
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {}

    public function map(UserRegisterDto $dto): UserInfo
    {
        $user = new UserInfo;

        if (null !== $dto->getPseudo()) {
            $user->setPseudo(
                $dto->getPseudo()
            );
        }

        if (null !== $dto->getName()) {
            $user->setName(
                $dto->getName()
            );
        }

        if (null !== $dto->getEmail()) {
            $user->setEmail(
                $dto->getEmail()
            );
        }

        if (null !== $dto->getPlainPassword()) {
            $user->setPassword(
                $this->passwordHasher->hashPassword(
                    $user,
                    $dto->getPlainPassword()
                )
            );
        }

        
        // if (null !== $dto->getAvatarUrl()) {
        //     $user->setAvatarUrl(
        //         $dto->getAvatarUrl()
        //     );
        // }

        // if (null !== $dto->getBio()) {
        //     $user->setBio(
        //         $dto->getBio()
        //     );
        // }


        return $user;
    }
}

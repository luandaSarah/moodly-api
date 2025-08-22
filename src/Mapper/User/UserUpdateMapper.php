<?php

namespace App\Mapper\User;

use App\Dto\User\UserAdminUpdateDto;
use App\Entity\UserInfo;
use App\Dto\User\UserUpdateDto;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserUpdateMapper
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {}

    public function map(UserUpdateDto|UserAdminUpdateDto $dto, UserInfo $user ): UserInfo
    {
        

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

     

        if (null !== $dto->getBio()) {
            $user->setBio(
                $dto->getBio()
            );
        }

           if (null !== $dto->getRoles()) {
            $user->setRoles(
                $dto->getRoles()
            );
        }


        return $user;
    }
}

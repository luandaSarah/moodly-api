<?php

namespace App\Mapper;

use App\Dto\Interfaces\UserRequestInterface;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserMapper
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {}

    public function map(UserRequestInterface $dto, ?User $user = null): User
    {
        $user ??= new User;

        if (null !== $dto->getUsername()) {
            $user->setUsername(
                $dto->getUsername()
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

        return $user;
    }
}

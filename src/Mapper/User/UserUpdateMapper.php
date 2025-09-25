<?php

namespace App\Mapper\User;

use App\Entity\UserInfo;
use App\Dto\User\UserUpdateDto;
use App\Dto\User\UserAdminUpdateDto;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserUpdateMapper
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {}

    public function map(UserUpdateDto|UserAdminUpdateDto $dto, UserInfo $user): UserInfo
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

        if (null !== $dto->getNewPassword()) {
            if (!$dto->getCurrentPassword()) {
                throw new NotFoundHttpException('Veuillez valider votre mot de passe actuel');
            }

            if (
                $this->passwordHasher->isPasswordValid($user, $dto->getCurrentPassword())
            ) {
                $user->setPassword(
                    $this->passwordHasher->hashPassword(
                        $user,
                        $dto->getNewPassword()
                    )
                );
            } else {
                throw new NotFoundHttpException('Le mot de passe actuel entrée n\'est pas correcte');
            }
        }




        if (null !== $dto->getBio()) {
            $user->setBio(
                $dto->getBio()
            );
        }

        // if (null !== $dto->getRoles()) {
        //     $user->setRoles(
        //         $dto->getRoles()
        //     );
        // }


        return $user;
    }
}

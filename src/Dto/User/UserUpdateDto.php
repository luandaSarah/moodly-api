<?php

namespace App\Dto\User;

use App\Entity\UserInfo;
use App\Dto\Interfaces\UserRequestInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[UniqueEntity(
    fields: ['pseudo'],
    entityClass: UserInfo::class,
    message: 'Ce pseudo est déjà pris'
)]

#[UniqueEntity(
    fields: ['email'],
    entityClass: UserInfo::class,
    message: 'Ce mail est déjà pris'
)]
class UserUpdateDto
{
    public function __construct(


        #[Assert\Length(
            min: 3,
            max: 30,
            minMessage: 'Le pseudo doit contenir au moins {{limit}} caractères',
            maxMessage: 'Le pseudo ne doit pas contenir plus de {{limit}} caractères',
        )]
        #[Assert\Regex(
            pattern: '/^[a-zA-Z0-9._]{3,30}$/',
            message: 'Le pseudo ne peut contenir que des lettres(minuscules et majuscules), des chiffres et les caractères spécieux \'.\' et \'_\''
        )]
        private readonly ?string $pseudo = null,

        #[Assert\Length(
            min: 3,
            max: 30,
            minMessage: 'Le nom doit contenir au moins {{limit}} caractères',
            maxMessage: 'Le nom ne doit pas contenir plus de {{limit}} caractères',
        )]
        private readonly ?string $name = null,


        #[Assert\Email(
            message: 'Veuillez entrer une adresse e-mail valide.'
        )]
        private readonly ?string $email = null,


        private readonly ?string $currentPassword = null,

        #[Assert\Regex(
            pattern: '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&.,]{6,}$/',
            message: 'Le mot de passe doit contenir au moins une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial (@ $ ! % * ? &)'
        )]
        #[Assert\Length(
            min: 6,
            max: 4096,
            minMessage: 'Le mot de passe doit contenir au moins {{limit}} caractères',
            maxMessage: 'Le mot de pass ne doit pas contenir plus de {{limit}} caractères',
        )]
        #[Assert\EqualTo(
            propertyPath: 'confirmNewPassword',
            message: 'Les mots de passe doivent être identique',
        )]
        private readonly ?string $newPassword = null,

        #[Assert\EqualTo(
            propertyPath: 'newPassword',
            message: 'Les mots de passe doivent être identique',
        )]
        private readonly ?string $confirmNewPassword = null,

        // #[Assert\Url(
        //     message: 'Cette Url n\'est pas valide'
        // )]
        // private readonly ?string $avatarUrl = null,

        #[Assert\Length(
            min: 0,
            max: 180,
            maxMessage: 'La bio ne doit pas contenir plus de {{limit}} caractères',
        )]
        private readonly ?string $bio = null,


    ) {}

    /**
     * Get the value of pseudo
     */
    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    /**
     * Get the value of name
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Get the value of email
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }



    /**
     * Get the value of bio
     */
    public function getBio(): ?string
    {
        return $this->bio;
    }

    /**
     * Get the value of currentPassword
     */
    public function getCurrentPassword(): ?string
    {
        return $this->currentPassword;
    }

    /**
     * Get the value of newPassword
     */
    public function getNewPassword(): ?string
    {
        return $this->newPassword;
    }

    /**
     * Get the value of confirmNewPassword
     */
    public function getConfirmNewPassword(): ?string
    {
        return $this->confirmNewPassword;
    }
}

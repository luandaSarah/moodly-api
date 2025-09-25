<?php

namespace App\Dto\User;

use App\Entity\UserInfo;
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
class UserAdminUpdateDto
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
            propertyPath: 'confirmPassword',
            message: 'Les mots de passe doivent être identique',
        )]
        private readonly ?string $plainPassword = null,

        #[Assert\EqualTo(
            propertyPath: 'plainPassword',
            message: 'Les mots de passe doivent être identique',
        )]
        private readonly ?string $confirmPassword = null,

        #[Assert\Length(
            min: 0,
            max: 180,
            maxMessage: 'La bio ne doit pas contenir plus de {{limit}} caractères',
        )]
        private readonly ?string $bio = null,

        #[Assert\Choice(
            choices: ['ROLE_USER', 'ROLE_ADMIN'],
            message: 'Le rôle doit être soit ROLE_USER, soit ROLE_ADMIN',
            multiple: true,
        )]
        private readonly ?array $roles = null,
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
     * Get the value of confirmPassword
     */
    public function getConfirmPassword(): ?string
    {
        return $this->confirmPassword;
    }

    /**
     * Get the value of plainPassword
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * Get the value of bio
     */
    public function getBio(): ?string
    {
        return $this->bio;
    }

    /**
     * Get the value of roles
     */
    public function getRoles():?array
    {
        return $this->roles;
    }
}

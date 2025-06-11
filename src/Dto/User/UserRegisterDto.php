<?php

namespace App\Dto\User;

use App\Entity\User;
use App\Dto\Interfaces\UserRequestInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[UniqueEntity(
    fields: ['username'],
    entityClass: User::class,
    message: 'Ce nom d\'utilisateur est déjà pris'
)]
#[UniqueEntity(
    fields: ['email'],
    entityClass: User::class,
    message: 'Ce mail est déjà pris'
)]
class UserRegisterDto implements UserRequestInterface
{
    public function __construct(

        #[Assert\NotBlank(
            message: 'Veuillez entrer un nom d\'utilisateur',
        )]
        #[Assert\Length(
            min: 3,
            max: 30,
            minMessage: 'Le nom d\'utilisateur doit contenir au moins {{limit}} caractères',
            maxMessage: 'Le nom d\'utilisateur ne doit pas contenir plus de {{limit}} caractères',
        )]
        #[Assert\Regex(
            pattern: '/^[a-zA-Z0-9._]{3,30}$/',
            message: 'Le nom d\'utilisateur ne peut contenir que des lettres(minuscules et majuscules), des chiffres et les caractères spécieux \'.\' et \'_\''
        )]
        private readonly ?string $username = null,

        #[Assert\NotBlank(
            message: 'Veuillez entrer un nom',
        )]
        #[Assert\Length(
            min: 3,
            max: 30,
            minMessage: 'Le nom doit contenir au moins {{limit}} caractères',
            maxMessage: 'Le nom ne doit pas contenir plus de {{limit}} caractères',
        )]
        private readonly ?string $name = null,

        #[Assert\NotBlank(
            message: 'Veuillez entrer un nom',
        )]
        #[Assert\Email(
            message: 'Veuillez entrer une adresse e-mail valide.'
        )]
        private readonly ?string $email = null,

        #[Assert\NotBlank(
            message: 'Veuillez entrer un mot de passe',
        )]
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
        private readonly ?string $plainPassword = null,

        #[Assert\NotBlank(
            message: 'Veuillez confirmer votre mot de passe',
        )]
        #[Assert\EqualTo(
            propertyPath: 'plainPassword',
            message: 'Les mots de passe doivent être identique',
        )]
        private readonly ?string $confirmPassword = null,

    ) {}

    /**
     * Get the value of username
     */
    public function getUsername(): ?string
    {
        return $this->username;
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
}

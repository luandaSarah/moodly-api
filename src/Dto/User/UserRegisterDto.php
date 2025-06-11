<?php

namespace App\Dto\User;

use App\Dto\Interfaces\UserRequestInterface;
use App\Entity\UserInfo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[UniqueEntity(
    fields: ['pseudo'],
    entityClass: UserInfo::class,
    message: 'pseudo est déjà pris'
)]
#[UniqueEntity(
    fields: ['email'],
    entityClass: UserInfo::class,
    message: 'Ce mail est déjà pris'
)]
class UserRegisterDto 
{
    public function __construct(

        #[Assert\NotBlank(
            message: 'Veuillez entrer un pseudo',
        )]
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
}

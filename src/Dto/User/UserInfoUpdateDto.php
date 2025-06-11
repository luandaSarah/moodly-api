<?php

namespace App\Dto\User;

use Symfony\Component\Validator\Constraints as Assert;

class UserInfoUpdateDto 
{

    public function __construct(

        #[Assert\Url(
            message: 'Cette Url n\'est pas valide'
        )]
        private readonly ?string $avatarUrl = null,

        #[Assert\Length(
            min: 0,
            max: 180,
            maxMessage: 'La bio ne doit pas contenir plus de {{limit}} caractères',
        )]
        private readonly ?string $bio = null,

        // #[Assert\NotBlank(message: 'L\'user ne peut être vide',)]
        // #[Assert\Positive(message: 'L\'utilisateur doit etre un identifiant valide',)]
        // private readonly ?int $user = null,
    ) {}

    /**
     * Get the value of avatarUrl
     */
    public function getAvatarUrl(): ?string
    {
        return $this->avatarUrl;
    }

    /**
     * Get the value of bio
     */
    public function getBio(): ?string
    {
        return $this->bio;
    }

    // /**
    //  * Get the value of user
    //  */
    // public function getUser(): ?int
    // {
    //     return $this->user;
    // }
}

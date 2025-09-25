<?php

namespace App\Dto\Relationship;

use App\Entity\UserInfo;
use App\Entity\Relationship;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Constraints as Assert;


// #[UniqueEntity(
//     fields: ['following', 'followed'],
//     entityClass: Relationship::class,
//     message: 'Vous ne pouvez pas suivre deux fois la même personne'
// )]

class RelationshipCreateDto
{
    public function __construct(

        #[Assert\NotBlank(
            message: 'Veuillez indiquer l\'utilisateur que vous souhaitez suivre.'
        )]
        #[Assert\Positive(message: 'L\'utilisateur doit etre un identifiant valide',)]
        private readonly ?int $followed = null,
    ) {}

    /**
     * Get the value of followed
     */
    public function getFollowed(): int|null
    {
        return $this->followed;
    }
}

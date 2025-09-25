<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\DateTimeTraits;
use App\Repository\RelationshipRepository;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: RelationshipRepository::class)]
#[ORM\UniqueConstraint(name: 'unique_follow', columns: ['following_id', 'followed_id'])]
#[ORM\HasLifecycleCallbacks]
class Relationship
{

    use DateTimeTraits;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['relationship:index'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'relationships')]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    #[Groups(['followers:index'])]
    private ?UserInfo $following = null;

    #[ORM\ManyToOne(inversedBy: 'relationships')]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    #[Groups(['following:index'])]
    private ?UserInfo $followed = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFollowing(): ?UserInfo
    {
        return $this->following;
    }

    public function setFollowing(?UserInfo $following): static
    {
        $this->following = $following;

        return $this;
    }

    public function getFollowed(): ?UserInfo
    {
        return $this->followed;
    }

    public function setFollowed(?UserInfo $followed): static
    {
        $this->followed = $followed;

        return $this;
    }
}

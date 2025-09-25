<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserAvatarRepository;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: UserAvatarRepository::class)]
#[ORM\HasLifecycleCallbacks]

class UserAvatar
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 2083)]
    private ?string $avatarUrl = null;

    #[ORM\OneToOne(inversedBy: 'userAvatar', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?UserInfo $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    #[Groups(['common:show', 'common:index', 'relationship:index'])]
    public function getAvatarUrl(): ?string
    {
        return $this->avatarUrl;
    }

    public function setAvatarUrl(string $avatarUrl): static
    {
        $this->avatarUrl = $avatarUrl;

        return $this;
    }

    public function getUser(): ?UserInfo
    {
        return $this->user;
    }

    public function setUser(?UserInfo $user): static
    {
        $this->user = $user;

        if ($user !== null && $user->getUserAvatar() !== $this) {
            $user->setUserAvatar($this);
        }

        return $this;
    }

    
}

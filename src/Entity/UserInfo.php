<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\DateTimeTraits;
use App\Repository\UserInfoRepository;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: UserInfoRepository::class)]
class UserInfo extends User
{
    // use DateTimeTraits;
    
    #[ORM\Column(length: 2083, nullable: true)]
    #[Groups(['common:show'])]
    private ?string $avatarUrl = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['common:show'])]
    private ?string $bio = null;

    public function getAvatarUrl(): ?string
    {
        return $this->avatarUrl;
    }

    public function setAvatarUrl(?string $avatarUrl): static
    {
        $this->avatarUrl = $avatarUrl;

        return $this;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(?string $bio): static
    {
        $this->bio = $bio;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserInfoRepository;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: UserInfoRepository::class)]
#[UniqueEntity('pseudo')]
#[ORM\HasLifecycleCallbacks]
class UserInfo extends User
{


    #[ORM\Column(length: 2083, nullable: true)]
    #[Groups(['common:show'])]
    private ?string $avatarUrl = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['common:show'])]
    private ?string $bio = null;

    #[ORM\Column(length: 255)]
    #[Groups(['common:show'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['common:show'])]
    private ?string $pseudo = null;

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {

        $this->name = $name;

        return $this;
    }

    #[ORM\prePersist]
    public function setDefaultName(): static
    {
        if (!$this->name) {
            $this->name = $this->pseudo;
        }
        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): static
    {
        $this->pseudo = $pseudo;

        return $this;
    }
}

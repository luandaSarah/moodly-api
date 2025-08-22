<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MoodboardLikeRepository;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: MoodboardLikeRepository::class)]
#[ORM\UniqueConstraint(name: 'user_moodboard_unique', columns: ['user_id', 'moodboard_id'])]
class MoodboardLike
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['moodboard:index', 'moodboard:show'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'moodboardLikes')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['moodboard:index', 'moodboard:show'])]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'moodboardLikes')]
    #[ORM\JoinColumn(nullable: false)]
    // #[Groups(['moodboard:index', 'moodboard:show'])]
    private ?Moodboard $moodboard = null;


    public function getId(): ?int
    {
        return $this->id;
    }
    public function getUser(): ?User
    {
        return $this->user;
    }
    public function setUser(User $user): static
    {
        $this->user = $user;
        return $this;
    }

    public function getMoodboard(): ?Moodboard
    {
        return $this->moodboard;
    }
    public function setMoodboard(Moodboard $moodboard): static
    {
        $this->moodboard = $moodboard;
        return $this;
    }
}

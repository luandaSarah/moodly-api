<?php

namespace App\Entity;

use App\Repository\MoodboardImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MoodboardImageRepository::class)]
#[ORM\HasLifecycleCallbacks]
class MoodboardImage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 2083)]
    private ?string $imageUrl = null;

    #[ORM\ManyToOne(inversedBy: 'moodboardImages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Moodboard $moodboard = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(string $imageUrl): static
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    public function getMoodboard(): ?Moodboard
    {
        return $this->moodboard;
    }

    public function setMoodboard(?Moodboard $moodboard): static
    {
        $this->moodboard = $moodboard;

        return $this;
    }
}

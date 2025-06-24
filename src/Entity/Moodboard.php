<?php

namespace App\Entity;

use App\Repository\MoodboardRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MoodboardRepository::class)]
class Moodboard
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $backgroundColor = null;

    #[ORM\Column(length: 255, options: ['default' => 'draft'])]
    private ?string $status = null;

    #[ORM\ManyToOne(inversedBy: 'moodboards')]
    #[ORM\JoinColumn(nullable: false)]
    private ?UserInfo $user = null;

    public function __construct()
    {
        // On le place dans le constructeurs, à la création l'entité user aura toujours le status active
        $this->status = 'draft';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getBackgroundColor(): ?string
    {
        return $this->backgroundColor;
    }

    public function setBackgroundColor(string $backgroundColor): static
    {
        $this->backgroundColor = $backgroundColor;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getUser(): ?UserInfo
    {
        return $this->user;
    }

    public function setUser(?UserInfo $user): static
    {
        $this->user = $user;

        return $this;
    }
}

<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\DateTimeTraits;
use App\Repository\MoodboardCommentRepository;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: MoodboardCommentRepository::class)]
#[ORM\HasLifecycleCallbacks]

class MoodboardComment
{

    use DateTimeTraits;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['moodboard:comments'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['moodboard:comments'])]
    private ?string $content = null;

    #[ORM\ManyToOne(inversedBy: 'moodboardComments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'moodboardComments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Moodboard $moodboard = null;

    #[ORM\Column(options: ['default' => true])]
    #[Groups(['admin:index'])]
    private ?bool $enabled = null;

    public function __construct()
    {
        $this->enabled = true;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    #[Groups(['moodboard:comments'])]
    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

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

    public function isEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): static
    {
        $this->enabled = $enabled;

        return $this;
    }
}

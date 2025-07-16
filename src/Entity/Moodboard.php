<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\DateTimeTraits;
use App\Repository\MoodboardRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: MoodboardRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Moodboard
{

    use DateTimeTraits;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['moodboard:index','moodboard:image'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['moodboard:index'])]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Groups(['moodboard:index'])]
    private ?string $backgroundColor = null;

    #[ORM\Column(length: 255, options: ['default' => 'draft'])]
    #[Groups(['moodboard:index'])]
    private ?string $status = null;

    #[ORM\ManyToOne(inversedBy: 'moodboards')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['moodboard:index'])]
    private ?UserInfo $user = null;

    /**
     * @var Collection<int, MoodboardImage>
     */
    #[ORM\OneToMany(targetEntity: MoodboardImage::class, mappedBy: 'moodboard', orphanRemoval: true)]
    private Collection $moodboardImages;

    public function __construct()
    {
        // On le place dans le constructeurs, à la création l'entité user aura toujours le status active
        $this->status = 'draft';
        $this->moodboardImages = new ArrayCollection();
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
        //la couleur sera toujours en mminiscule
        $this->backgroundColor = strtolower($backgroundColor);

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

    /**
     * @return Collection<int, MoodboardImage>
     */
    public function getMoodboardImages(): Collection
    {
        return $this->moodboardImages;
    }

    public function addMoodboardImage(MoodboardImage $moodboardImage): static
    {
        if (!$this->moodboardImages->contains($moodboardImage)) {
            $this->moodboardImages->add($moodboardImage);
            $moodboardImage->setMoodboard($this);
        }

        return $this;
    }

    public function removeMoodboardImage(MoodboardImage $moodboardImage): static
    {
        if ($this->moodboardImages->removeElement($moodboardImage)) {
            // set the owning side to null (unless already changed)
            if ($moodboardImage->getMoodboard() === $this) {
                $moodboardImage->setMoodboard(null);
            }
        }

        return $this;
    }
}

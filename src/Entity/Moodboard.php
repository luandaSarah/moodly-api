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
    #[Groups(['moodboard:index', 'moodboard:image', 'moodboard:show'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['moodboard:index', 'moodboard:show'])]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Groups(['moodboard:index', 'moodboard:show'])]
    private ?string $backgroundColor = null;

    #[ORM\Column(length: 255, options: ['default' => 'draft'])]
    #[Groups(['admin:index'])]
    private ?string $status = null;

    #[ORM\ManyToOne(inversedBy: 'moodboards')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['moodboard:index', 'moodboard:show'])]
    private ?UserInfo $user = null;

    /**
     * @var Collection<int, MoodboardImage>
     */
    #[ORM\OneToMany(targetEntity: MoodboardImage::class, mappedBy: 'moodboard', orphanRemoval: true)]
    private Collection $moodboardImages;

    /**
     * @var Collection<int, MoodboardComment>
     */
    #[ORM\OneToMany(targetEntity: MoodboardComment::class, mappedBy: 'moodboard', orphanRemoval: true)]
    private Collection $moodboardComments;

    /**
     * @var Collection<int, MoodboardLike>
     */
    #[ORM\OneToMany(targetEntity: MoodboardLike::class, mappedBy: 'moodboard', orphanRemoval: true)]
    private Collection $moodboardLikes;

    public function __construct()
    {
        // On le place dans le constructeurs, à la création l'entité user aura toujours le status active
        $this->status = 'draft';
        $this->moodboardImages = new ArrayCollection();
        $this->moodboardComments = new ArrayCollection();
        $this->moodboardLikes = new ArrayCollection();
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
    #[Groups(['moodboard:index', 'moodboard:show'])]
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

    /**
     * @return Collection<int, MoodboardComment>
     */
    public function getMoodboardComments(): Collection
    {
        return $this->moodboardComments;
    }

    public function addMoodboardComment(MoodboardComment $moodboardComment): static
    {
        if (!$this->moodboardComments->contains($moodboardComment)) {
            $this->moodboardComments->add($moodboardComment);
            $moodboardComment->setMoodboard($this);
        }

        return $this;
    }

    public function removeMoodboardComment(MoodboardComment $moodboardComment): static
    {
        if ($this->moodboardComments->removeElement($moodboardComment)) {
            // set the owning side to null (unless already changed)
            if ($moodboardComment->getMoodboard() === $this) {
                $moodboardComment->setMoodboard(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MoodboardLike>
     */
    // #[Groups(['moodboard:index', 'moodboard:show'])]
    public function getMoodboardLikes(): Collection
    {
        return $this->moodboardLikes;
    }
}

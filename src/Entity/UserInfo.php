<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    #[Groups(['common:show', 'common:index','relationship:index'])]
    private ?string $avatarUrl = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['common:show'])]
    private ?string $bio = null;

    #[ORM\Column(length: 255)]
    #[Groups(['common:show', 'common:index','relationship:index'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['common:show', 'common:index','relationship:index'])]
    private ?string $pseudo = null;

    /**
     * @var Collection<int, Relationship>
     */
    #[ORM\OneToMany(targetEntity: Relationship::class, mappedBy: 'following', orphanRemoval: true)]
    private Collection $relationships;

    /**
     * @var Collection<int, Moodboard>
     */
    #[ORM\OneToMany(targetEntity: Moodboard::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $moodboards;

    public function __construct()
    {
        parent::__construct();
        $this->relationships = new ArrayCollection();
        $this->moodboards = new ArrayCollection();
    }

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

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): static
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * @return Collection<int, Relationship>
     */
    public function getRelationships(): Collection
    {
        return $this->relationships;
    }

    public function addRelationship(Relationship $relationship): static
    {
        if (!$this->relationships->contains($relationship)) {
            $this->relationships->add($relationship);
            $relationship->setFollowing($this);
        }

        return $this;
    }

    public function removeRelationship(Relationship $relationship): static
    {
        if ($this->relationships->removeElement($relationship)) {
            // set the owning side to null (unless already changed)
            if ($relationship->getFollowing() === $this) {
                $relationship->setFollowing(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Moodboard>
     */
    public function getMoodboards(): Collection
    {
        return $this->moodboards;
    }

    public function addMoodboard(Moodboard $moodboard): static
    {
        if (!$this->moodboards->contains($moodboard)) {
            $this->moodboards->add($moodboard);
            $moodboard->setUser($this);
        }

        return $this;
    }

    public function removeMoodboard(Moodboard $moodboard): static
    {
        if ($this->moodboards->removeElement($moodboard)) {
            // set the owning side to null (unless already changed)
            if ($moodboard->getUser() === $this) {
                $moodboard->setUser(null);
            }
        }

        return $this;
    }
}

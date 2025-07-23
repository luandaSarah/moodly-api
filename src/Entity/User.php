<?php

namespace App\Entity;

use App\Entity\UserInfo;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use App\Entity\Traits\DateTimeTraits;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[InheritanceType('JOINED')]
#[DiscriminatorColumn(name: 'discr', type: 'string')]
#[DiscriminatorMap(['userInfo' => UserInfo::class])]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[ORM\HasLifecycleCallbacks]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use DateTimeTraits;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['common:index', 'relationship:index', 'moodboard:index', 'moodboard:show', 'moodboard:comments'])]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    #[Groups(['profile:show', 'admin:show'])]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    #[Groups(['admin:show', 'admin:index'])]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    /**
     * propriété status
     * si aucune valeur n'est persisté, ORM persistera 'active' par defaut
     * @var string|null
     */
    #[ORM\Column(length: 255, options: ['default' => 'active'])]
    #[Groups(['admin:show', 'admin:index'])]
    private ?string $status = null;

    /**
     * @var Collection<int, MoodboardComment>
     */
    #[ORM\OneToMany(targetEntity: MoodboardComment::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $moodboardComments;

    /**
     * @var Collection<int, MoodboardLike>
     */
    #[ORM\ManyToMany(targetEntity: MoodboardLike::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $moodboardLikes;



    public function __construct()
    {
        //On le place dans le constructeurs, à la création l'entité user aura toujours le status active 
        $this->status = 'active';
        $this->moodboardComments = new ArrayCollection();
        $this->moodboardLikes = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    // public function getUsername(): ?string
    // {
    //     return $this->username;
    // }

    // public function setUsername(string $username): static
    // {
    //     $this->username = $username;

    //     return $this;
    // }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

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
            $moodboardComment->setUser($this);
        }

        return $this;
    }

    public function removeMoodboardComment(MoodboardComment $moodboardComment): static
    {
        if ($this->moodboardComments->removeElement($moodboardComment)) {
            // set the owning side to null (unless already changed)
            if ($moodboardComment->getUser() === $this) {
                $moodboardComment->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MoodboardLike>
     */
    public function getMoodboardLikes(): Collection
    {
        return $this->moodboardLikes;
    }
}

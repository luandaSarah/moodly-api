<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

/**
 * Traits pour la réutilisation des propriété createdAt et updatedAt dans mes entités
 */
trait DateTimeTraits
{

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updateAt = null;



    /**
     * Get the value of createdAt
     *
     * @return ?\DateTimeImmutable
     */
    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     *
     * @param ?\DateTimeImmutable $createdAt
     *
     * @return self
     */
    #[ORM\PrePersist]
    public function setCreatedAt(): self
    {
         if (!$this->createdAt) {
            $this->createdAt = new \DateTimeImmutable();
        }
        return $this;
    }

    /**
     * Get the value of updateAt
     *
     * @return ?\DateTimeImmutable
     */
    public function getUpdateAt(): ?\DateTimeImmutable
    {
        return $this->updateAt;
    }

    /**
     * Set the value of updateAt
     *
     * @param ?\DateTimeImmutable $updateAt
     *
     * @return self
     */
    #[ORM\PreUpdate]
    public function setUpdateAt(): self
    {
        if (!$this->updatedAt) {
            $this->updatedAt = new \DateTimeImmutable();
        }
        return $this;
    }

}

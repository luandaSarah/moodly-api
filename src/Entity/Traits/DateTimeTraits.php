<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

/**
 * Traits pour la réutilisation des propriété createdAt et updatedAt dans mes entités
 */
trait DateTimeTraits
{
    #[ORM\Column]
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
    public function setCreatedAt(?\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

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
    public function setUpdateAt(?\DateTimeImmutable $updateAt): self
    {
        $this->updateAt = $updateAt;

        return $this;
    }


    /**
     * Cette methode génére automatiquement la date de création à la persistance de notre entité en bdd 
     * grace à au LifeCycleCallback : PrePersist
     * @return static
     */
    #[ORM\PrePersist] 
    public function autosetCreatedAt(): static
    {
        if (!$this->createdAt) {
            $this->createdAt = new \DateTimeImmutable();
        }
        return $this;
    }

     /**
     * Cette methode génére automatiquement la date de mise à jour à la persistance de notre entité en bdd
     *grace à au LifeCycleCallback : PreUpdate
     * @return static
     */

    #[ORM\PreUpdate]
    public function autosetUpdatedAt(): static
    {
        if (!$this->updatedAt) {
            $this->updatedAt = new \DateTimeImmutable();
        }
        return $this;
    }


}

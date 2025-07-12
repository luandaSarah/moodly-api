<?php


namespace App\Dto\Moodboard;

use Symfony\Component\Validator\Constraints as Assert;

class MoodboardCreateDto
{
    public function __construct(

        #[Assert\NotBlank(
            message: 'Veuillez entrer un titre',
        )]
        #[Assert\Length(
            min: 3,
            max: 150,
            minMessage: 'Le titre doit contenir au moins {{limit}} caractères',
            maxMessage: 'Le titre ne doit pas contenir plus de {{limit}} caractères',
        )]
        private readonly ?string $title = null,


        #[Assert\NotBlank(
            message: 'Veuillez entrer un titre',
        )]
        #[Assert\Length(
            min: 3,
            max: 7,
            minMessage: 'La couleur doit etre un code hexadécimal et doit contenir au moins {{limit}} caractères',
            maxMessage: 'La couleur doit etre un code hexadécimal et  ne doit pas contenir plus de {{limit}} caractères',
        )]
        #[Assert\Regex(
            pattern: '/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/',
            message: 'La couleur doit être un code hexadécimal valide, comme #fff ou #ffffff.'
        )]
        private readonly ?string $backgroundColor = null,


        #[Assert\NotBlank(
            message: 'Veuillez entrer le statut',
        )]
        #[Assert\Choice(
            ['draft', 'published'],
            message: 'Le status doit être "draft" ou "published"',
        )]
        private readonly ?string $status = null,
    ) {}



    /**
     * Get the value of title
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Get the value of backgroundColor
     */
    public function getBackgroundColor(): ?string
    {
        return $this->backgroundColor;
    }

        /**
         * Get the value of status
         */
        public function getStatus()
        {
                return $this->status;
        }
}

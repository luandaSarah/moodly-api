<?php

namespace App\Dto\MoodboardComment;

use Symfony\Component\Validator\Constraints as Assert;


class MoodboardCommentUpdateDto
{
    public function __construct(

        #[Assert\Length(
            min: 1,
            max: 1000,
            minMessage: 'Le contenu doit contenir au moins {{limit}} caractères',
            maxMessage: 'Le contenu  ne doit pas contenir plus de {{limit}} caractères',
        )]
        private readonly ?string $content = null,

        //   #[Assert\NotBlank(
        //     message: 'Veuillez indiquer le moodboard sous lequel vous commentez.'
        // )]
        // #[Assert\Positive(message: 'le moodboard doit etre un identifiant valide',)]
        // private readonly ?int $moodboard = null,
    ) {}



    /**
     * Get the value of content
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Get the value of moodboard
     */
    // public function getMoodboard()
    // {
    //     return $this->moodboard;
    // }
}

<?php

namespace App\Dto\Filter;

use Symfony\Component\Validator\Constraints as Assert;


class PaginationFilterDto
{
    public function __construct(

        #[Assert\Positive]
        private readonly int $page = 1,

        #[Assert\Positive]
        private readonly int $limit = 10,


    ) {}

    /**
     * Get the value of page
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Get the value of limit
     */
    public function getLimit()
    {
        return $this->limit;
    }
}

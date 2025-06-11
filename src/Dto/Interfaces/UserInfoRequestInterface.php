<?php

namespace App\Dto\Interfaces;

interface UserInfoRequestInterface
{
    public function getAvatarUrl(): ?string;

    public function getBio(): ?string;

}

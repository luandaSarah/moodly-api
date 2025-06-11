<?php

namespace App\Dto\Interfaces;

interface UserRequestInterface
{
    public function getUsername(): ?string;

    public function getName(): ?string;

    public function getEmail(): ?string;

    public function getPlainPassword(): ?string;
}

<?php

namespace App\Mapper;

use App\Dto\Interfaces\UserInfoRequestInterface;
use App\Dto\User\UserInfoUpdateDto;
use App\Entity\UserInfo;
use App\Repository\UserRepository;

class UserInfoMapper
{
    public function __construct(
        private readonly UserRepository $userRepository,
    ) {}

    public function map(UserInfoUpdateDto $dto, ?UserInfo $userInfo = null): UserInfo
    {
        $userInfo ??= new UserInfo;

        if (null !== $dto->getAvatarUrl()) {
            $userInfo->setAvatarUrl(
                $dto->getAvatarUrl()
            );
        }

        if (null !== $dto->getBio()) {
            $userInfo->setBio(
                $dto->getBio()
            );
        }

        return $userInfo;
    }
}

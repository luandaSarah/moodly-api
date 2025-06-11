<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserInfo;
use App\Mapper\UserMapper;
use App\Mapper\UserInfoMapper;
use App\Dto\User\UserUpdateDto;
use App\Dto\User\UserRegisterDto;
use App\Repository\UserRepository;
use App\Dto\User\UserInfoUpdateDto;
use App\Repository\UserInfoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('api', name: 'api_users_')]
class UserController extends AbstractController
{

    public function __construct(
        private UserRepository $userRepository,
        private UserInfoRepository $userInfoRepository,
        private EntityManagerInterface $em,
        private UserMapper $userMapper,
        private UserInfoMapper $userInfoMapper,
    ) {}


    /**
     * Récupere tout les Users
     *
     * @return JsonResponse
     */
    #[Route('/users', 'index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return $this->json(
            $this->userRepository->findAll(),
            Response::HTTP_OK,
            context: [
                'groups' => ['common:index'],
            ],
        );
    }


    /**
     * 
     * Recupere un utilisateur
     * 
     * @param \App\Entity\User $user
     * @return JsonResponse
     */
    #[Route('/users/{id}', 'show', methods: ['GET'])]

    public function showUser(User $user): JsonResponse
    {
        return $this->json(
            $user,
            Response::HTTP_OK,
            context: [
                'groups' => ['common:index', 'common:show'],
            ],
        );
    }

    /**
     * Recupere l'utilisateur connecté
     *
     * @return JsonResponse
     */
    #[Route('/profile', name: 'profile_show', methods: ['GET'])]
    public function showProfile(): JsonResponse
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->json(
                [
                    'error' => 'L\'utilisateur n\'est pas connecté'
                ],
                Response::HTTP_UNAUTHORIZED
            );
        }
        return $this->json(
            $user,
            Response::HTTP_OK,
            context: [
                'groups' => ['profile:show', 'common:index', 'common:show'],
            ],
        );
    }


    #[Route('/register', name: 'register', methods: ['POST'])]
    public function register(

        #[MapRequestPayload]
        UserRegisterDto $dto

    ): JsonResponse {

        $user = $this->userMapper->map($dto);
        $userInfo = new UserInfo;
        $userInfo->setUser($user);
        $this->em->persist($user);
        $this->em->persist($userInfo);
        $this->em->flush();

        return $this->json(
            [
                'id' => $user->getId(),
            ],
            Response::HTTP_CREATED,
        );
    }


    #[Route('/profile', name: 'update', methods: ['POST'])]
    public function update(
        #[MapRequestPayload]
        UserUpdateDto $userDto,
        #[MapRequestPayload]
        UserInfoUpdateDto $userInfoDto,
    ): JsonResponse {

        $user = $this->getUser();

        $userInfo = $this->userInfoRepository->findOneBy(['user' => $user]);
        $this->userMapper->map($userDto, $user);
        $this->userInfoMapper->map($userInfoDto, $userInfo);
        $this->em->flush();

        return $this->json(
            $user,
            Response::HTTP_OK,
            context: [
                'groups' => ['profile:show', 'common:index', 'common:show'],
            ],
        );
    }

    #[Route('/profile', name: 'delete', methods: ['DELETE'])]
    public function delete(): JsonResponse
    {
        $user = $this->getUser();

        $this->em->remove($user);
        $this->em->flush();

        return $this->json(
            null,
            Response::HTTP_NO_CONTENT
        );
    }
}

<?php

namespace App\Controller;

use App\Dto\Filter\PaginationFilterDto;
use App\Entity\UserInfo;
use App\Dto\User\UserUpdateDto;
use App\Dto\User\UserRegisterDto;

use App\Mapper\User\UserUpdateMapper;

use App\Repository\UserInfoRepository;
use App\Mapper\User\UserRegisterMapper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;

#[Route('api', name: 'api_users_')]
class UserController extends AbstractController
{

    public function __construct(
        private UserInfoRepository $userInfoRepository,
        private EntityManagerInterface $em,
        private UserRegisterMapper $userRegisterMapper,
        private UserUpdateMapper $userUpdateMapper,

    ) {}

    /**
     * Récupere tout les Users
     *
     * @return JsonResponse
     */
    #[Route('/users', 'index', methods: ['GET'])]
    public function index(
        #[MapQueryString]
        PaginationFilterDto $paginationDto,
    ): JsonResponse {
        return $this->json(
            $this->userInfoRepository->findPaginate($paginationDto),
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

    public function showUser(UserInfo $user): JsonResponse
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

        $user = $this->userRegisterMapper->map($dto);

        $this->em->persist($user);

        $this->em->flush();

        return $this->json(
            [
                'id' => $user->getId(),
            ],
            Response::HTTP_CREATED,
        );
    }


    #[Route('/profile', name: 'update', methods: ['PATCH'])]
    public function update(
        #[MapRequestPayload]
        UserUpdateDto $dto,
    ): JsonResponse {

        $ConnectedUser = $this->getUser();
        $email = $ConnectedUser->getUserIdentifier();

        $user = $this->userInfoRepository->findOneBy(['email' => $email]);


        if (!$user) {
            return $this->json(
                [
                    'error' => 'L\'utilisateur n\'existe pas'
                ],
                Response::HTTP_UNAUTHORIZED
            );
        }
        $this->userUpdateMapper->map($dto, $user);

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

<?php

namespace App\Controller\Admin;

use App\Entity\UserInfo;
use App\Dto\User\UserAdminUpdateDto;
use App\Mapper\User\UserUpdateMapper;
use App\Repository\UserInfoRepository;
use App\Dto\Filter\PaginationFilterDto;
use App\Mapper\User\UserRegisterMapper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('api/admin/users', 'api_admin_users_')]
class UserController extends AbstractController
{
    public function __construct(
        private UserInfoRepository $userInfoRepository,
        private EntityManagerInterface $em,
        private UserRegisterMapper $userRegisterMapper,
        private UserUpdateMapper $userUpdateMapper,

    ) {}

    /**
     *
     * @return JsonResponse
     */
    #[Route('', 'index', methods: ['GET'])]
    public function index(
        #[MapQueryString]
        PaginationFilterDto $paginationDto,
    ): JsonResponse {
        return $this->json(
            $this->userInfoRepository->findPaginate($paginationDto),
            Response::HTTP_OK,
            context: [
                'groups' => ['common:index', 'admin:index'],
            ],
        );
    }

    /**
     * 
     * @param \App\Entity\User $user
     * @return JsonResponse
     */
    #[Route('/{id}', 'show', methods: ['GET'])]

    public function showUser(UserInfo $user): JsonResponse
    {
        return $this->json(
            $user,
            Response::HTTP_OK,
            context: [
                'groups' => ['common:index', 'common:show', 'admin:index', 'admin:show'],
            ],
        );
    }

    #[Route('/{id}', name: 'update', methods: ['PATCH'])]
    public function update(
        UserInfo $user,
        #[MapRequestPayload]
        UserAdminUpdateDto $dto,
    ): JsonResponse {


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
                'groups' => ['common:index', 'common:show', 'admin:index', 'admin:show'],
            ],
        );
    }


    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(UserInfo $user): JsonResponse
    {


        if (!$user) {
            return $this->json(
                [
                    'error' => 'L\'utilisateur n\'existe pas'
                ],
                Response::HTTP_UNAUTHORIZED
            );
        }

        $this->em->remove($user);
        $this->em->flush();

        return $this->json(
            null,
            Response::HTTP_NO_CONTENT
        );
    }
}
